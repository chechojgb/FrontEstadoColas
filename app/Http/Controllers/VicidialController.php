<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib3\Net\SSH2;
use Illuminate\Support\Facades\DB;

class VicidialController extends Controller
{
    public const CAMPAIGN_OPTIONS = [
        "TRAMITES_CW17932",
        "SOPORTE_CW17932",
        "MOVIL_CW17932",
        "HOGARES-POSTVENTAS",
        "CANCELACION-TOTAL_FTTH",
        "CROSS_POSVENTA_CAMBIO_DE_PLAN-COS",
        "HOGARES-POSTVENTA_PQR_PLATINO",
        "HOGARES-POSTVENTA_TRASLADOS_COBRE",
        "HOGARES-POSTVENTA_TRASLADOS_FIBRA",
        "HOGARES-POSTVENTA_TRAMITES_COBRE",
        "HOGARES-POSTVENTA_TRAMITES_FIBRA",
        "HOGARES-POSTVENTA_QUEJAS_RECURSOS_COBRE",
        "HOGARES-POSTVENTA_QUEJAS_RECURSOS_FIBRA_2",
        "HOGARES-POSTVENTA_PROCESO_EMPRESA-COS",
        "MIGRACIONES SOPORTE-COS",
        "CANCELACION-TOTAL_PLATINO",
        "HOGARES-SOPORTE_TECNICO_PLATINO",
        "HOGARES-SOPORTE_TECNICO_COBRE",
        "HOGARES-SOPORTE_TECNICO_FIBRA_2",
        "HOGARES-SOPORTE_FALLAS MASIVAS",
        "HOGARES-SOPORTE_TECNICO",
        "HOGARES_SOPORTE_PLATINO-COS",
        "CANCELACION-TOTAL_COBRE",
        "HOGARES-SOPORTE_TECNICO_AGENDADAS",
        "HOGARES-SOPORTE_TECNICO_DTV",
        "HOGARES-SOPORTE_TECNICO_WIFI",
        "MOVILES-POSTVENTA_PREPAGO",
        "MOVILES-POSTVENTA_PREPAGO_PERDIDA_ROBO",
        "PREPAGO_POSVENTA_COS",
        "MOVILES-POSTVENTA_POSPAGO_PERDIDA_ROBO",
        "CLIENTES_EMPRESAS_COS",
        "MOVILES-POSTVENTA_MOVILES_DEFAULT",
        "MOVILES-POSTVENTA_SIM_PREACTIVAS_750",
        "MOVILES-SOPORTE_PREPAGO",
        "MOVILES-POSTVENTA_POSPAGO",
        "OUTBOUND",
        "MOVILES-SOPORTE_POSPAGO",
        "ETB RECUPERACION",
        "T_HOGARES-POSTVENTA_TRASLADOS_COBRE"
    ];

    public const OPERATION_OPTIONS = [
        "SUPPORT",
        "FORMALITIES",
        "MOBILES",
        "RETENTION"
    ];


    public function showCampaigns()
    {
        return view('campaigns', ['campaigns' => self::CAMPAIGN_OPTIONS, 'operations' => self::OPERATION_OPTIONS] );
    }


    public function executeCommand(Request $request)
    {
        $selectedCampaign = null;
        $campaignIndex = null;
        
        if ($request->has('campaign')) {
            $validated = $this->validateCampaign($request);
            $campaignIndex = $validated['campaign'];
            $selectedCampaign = self::CAMPAIGN_OPTIONS[$campaignIndex - 1];
            session(['campaignIndex' => $campaignIndex, 'operationIndex' => null]);
            $command = "rasterisk -rx 'queue show q{$campaignIndex}' | sort";
        } elseif ($request->has('operation')) {
            $validatedOp = $this->validateOperation($request);
            $operationIndex = $validatedOp['operation'];
            // dd(['validated_operation' => $validatedOp['operation']]);
            session(['operationIndex' => $operationIndex, 'campaignIndex' => null]);
            $operationQueues = [
                1 => [17, 18, 19, 20, 21, 22, 24, 25, 26],
                2 => [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23],
                3 => [27, 28, 29, 30, 31, 32, 33, 34, 35, 37],
                4 => [1, 2, 3],
            ];
            if (isset($operationQueues[$operationIndex])) {
                $queues = $operationQueues[$operationIndex];
                $commands = array_map(function($queue) {
                    return "rasterisk -rx 'queue show q{$queue}'";
                }, $queues);
                $command = implode(' && ', $commands) . ' | sort';

            } else {
                return response()->json(['error' => 'Operación no válida'], 400);
            }
        } else {
            return response()->json(['error' => 'No se enviaron datos válidos'], 400);
        }
        // dd($validated, $campaignIndex);
        // dd($campaignIndex, $selectedCampaign);
        $output = $this->getSSHOutput($command);
        if (!$output) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }

        $allCampaignCommand = "rasterisk -rx 'queue show' | sort";
        $allCampOutput = $this->getSSHOutput($allCampaignCommand);
        $membersSummaryAll = $this->extractQueueAll($allCampOutput);
        // dd($membersSummaryAll);
        $cleanOutput = $this->removeAnsiCharacters($output);
        // dd($allCampOutput);
        session(['cleanOutput' => $cleanOutput,]);
        $callsInQueue = $this->extractCallsInQueue($cleanOutput);
        $queueMembersSummary = $this->extractQueueMembersSummary($cleanOutput);
        $agentDetails = $this->getAgentDetails($cleanOutput);
        $agentDetails = collect($agentDetails)->unique('name')->values()->all();

        // dd($agentDetails);
        
        return view('campaigns', [
            'campaign' => $selectedCampaign,
            'agentDetails' => $agentDetails,
            'callsInQueue' => $callsInQueue,
            'queueMembersSummary' => $queueMembersSummary,
            'membersSummaryAll' => $membersSummaryAll,
            'campaignOptions' => VicidialController::CAMPAIGN_OPTIONS,
            'operationOptions' => self::OPERATION_OPTIONS
        ]);
    }

    private function validateCampaign(Request $request)
    {
        return $request->validate([
            'campaign' => 'required|integer|min:1|max:' . count(self::CAMPAIGN_OPTIONS),
        ]);
    }

    private function validateOperation(Request $request)
    {
        return $request->validate([
            'operation' => 'required|integer|min:1|max:' . count(self::OPERATION_OPTIONS),
        ]);
    }

    private function getSSHOutput(string $command): ?string
    {

        $user = env('USER_SERVER');
        $password = env('PASSWORD_SERVER');
        $host_server = env('HOST_SERVER');
        $ssh = new SSH2($host_server);
        if (!$ssh->login($user, $password)) {
            return null;
        }
        return $ssh->exec($command);
    }

    private function removeAnsiCharacters(string $output): string
    {
        $ansiEscape = '/\x1B\[.*?m/';
        return preg_replace($ansiEscape, '', $output);
    }

    private function extractCallsInQueue(string $output): array
    {
        $ansiEscape = '/\x1B\[.*?m/';
        $cleanOutput = preg_replace($ansiEscape, '', $output);
        $queueCallsPattern = '/\d+\.\s+SIP\/\S+\s+\(.*?\)/m';
        preg_match_all($queueCallsPattern, $cleanOutput, $matches);

        return !empty($matches[0]) ? $matches[0] : ['No calls in queue found.'];

    }

    private function extractQueueMembersSummary(string $output): array
    {
        $membersPattern = '/^Q\d+\s+.*?strategy.*?$/m';
        preg_match_all($membersPattern, $output, $matches);

        return $matches[0] ?? ['No members summary found.'];
    }

    private function extractQueueAll(string $output): array
    {
        $pattern = '/Q(\d+).*?has\s+(\d+)\s+calls/';
        preg_match_all($pattern, $output, $matches, PREG_SET_ORDER);
        $result = [];
        foreach ($matches as $match) {
            $result[] = "{$match[1]} has {$match[2]} calls";
        }
        // dd($result, $matches);
        return !empty($result) ? $result : ['No calls found.'];
    }

    private function getAgentDetailsForCampaign($campaignIndex)
    {
        $command = $campaignIndex === count(self::CAMPAIGN_OPTIONS)
            ? "rasterisk -rx 'queue show' | sort"
            : "rasterisk -rx 'queue show q{$campaignIndex}' | sort";
        $output = $this->getSSHOutput($command);
        if (!$output) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }
        $cleanOutput = $this->removeAnsiCharacters($output);
        return $this->getAgentDetails($cleanOutput);
    }
    private function getAgentDetailsForOperation($operationIndex)
    {
        $operationQueues = [
            1 => [17, 18, 19, 20, 21, 22, 24, 25, 26],
            2 => [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23],
            3 => [27, 28, 29, 30, 31, 32, 33, 34, 35, 37],
            4 => [1, 2, 3],
        ];
        if (isset($operationQueues[$operationIndex])) {
            $queues = $operationQueues[$operationIndex];
            $commands = array_map(function($queue) {
                return "rasterisk -rx 'queue show q{$queue}'";
            }, $queues);
            $command = implode(' && ', $commands) . ' | sort';
        }
        $output = $this->getSSHOutput($command);
        if (!$output) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }
        $cleanOutput = $this->removeAnsiCharacters($output);
        $agentDetails = $this->getAgentDetails($cleanOutput);
        $agentDetails = collect($agentDetails)->unique('name')->values()->all();
        return $agentDetails = collect($agentDetails)->unique('name')->values()->all();
    }

    private function getAgentDetails(string $output): array
    {
        $pattern = '/SIP\/(\d+)\s+\((.*?)\)\s+\((.*?)\)/';
        preg_match_all($pattern, $output, $matches, PREG_SET_ORDER);
        $filteredMatches = array_filter($matches, function ($match) {
            return $match[3] !== "Unavailable" && $match[3] !== 'Invalid';
        });
        $agentDetails = [];
        foreach ($filteredMatches as $match) {
            $extension = $match[1];
            $ringinuseStatus = $match[2];
            $callStatus = $match[3];

            $user = DB::table('usersv2')->where('extension', $extension)->first();

            if ($user) {
                $call = DB::table('calls')->where('user_id', $user->id)->orderBy('start', 'desc')->first();

                $callState = $call && isset($call->end) ? 'Call finished' : 'Call in progress';

                $agentDetails[] = [
                    'call_id' => $call->id ?? null,
                    'extension' => $extension,
                    'name' => $user->name,
                    'call_state' => $callState,
                    'state' => $callStatus,
                ];
            } else {
                $agentDetails[] = [
                    'extension' => $extension,
                    'message' => 'User Info not found',
                    'state' => $callStatus,
                ];
            }
        }

        return $agentDetails;
    }



    

    public function refreshTable(Request $request)
    {
        $campaignIndex = session('campaignIndex');
        if ($campaignIndex === null) {
            $operationIndex = session('operationIndex');
            $agentDetails = $this->getAgentDetailsForOperation($operationIndex);
        }else{
            $agentDetails = $this->getAgentDetailsForCampaign($campaignIndex);
        }
        if (is_null($agentDetails)) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }

        return view('partials.table', compact('agentDetails'));
    }

    public function refreshStateInfo(Request $request)
    {
        $campaignIndex = session('campaignIndex');
        if ($campaignIndex === null) {
            $operationIndex = session('operationIndex');
            $agentDetails = $this->getAgentDetailsForOperation($operationIndex);
        }else{
            $agentDetails = $this->getAgentDetailsForCampaign($campaignIndex);
        }
        if (is_null($agentDetails)) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }

        return view('partials.stateInfo', compact('agentDetails'));
    }

    public function refreshQueueDetail(Request $request)
    {

        $campaignIndex = session('campaignIndex');
        if ($campaignIndex === null) {
            $operationIndex = session('operationIndex');
            $operationQueues = [
                1 => [17, 18, 19, 20, 21, 22, 24, 25, 26],
                2 => [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23],
                3 => [27, 28, 29, 30, 31, 32, 33, 34, 35, 37],
                4 => [1, 2, 3],
            ];
            if (isset($operationQueues[$operationIndex])) {
                $queues = $operationQueues[$operationIndex];
                $commands = array_map(function($queue) {
                    return "rasterisk -rx 'queue show q{$queue}'";
                }, $queues);
                $command = implode(' && ', $commands) . ' | sort';
            }
            $output = $this->getSSHOutput($command);
            if (!$output) {
                return back()->withErrors(['error' => 'Failed to connect to the server.']);
            }
            $cleanOutput = $this->removeAnsiCharacters($output);
            $callsInQueue = $this->extractCallsInQueue($cleanOutput);
        }else{
            $command = "rasterisk -rx 'queue show q{$campaignIndex}' | sort";
            $output = $this->getSSHOutput($command);
            if (!$output) {
                return back()->withErrors(['error' => 'Failed to connect to the server.']);
            }
            $cleanOutput = $this->removeAnsiCharacters($output);
            $callsInQueue = $this->extractCallsInQueue($cleanOutput);
        }

        
        return view('partials.queueDetail', compact('callsInQueue'));
    }

    public function refreshAllCampaings(Request $request)
    {
        $allCampaignCommand = "rasterisk -rx 'queue show' | sort";  
        $allCampOutput = $this->getSSHOutput($allCampaignCommand);
        $membersSummaryAll = $this->extractQueueAll($allCampOutput);
        $campaignOptions = VicidialController::CAMPAIGN_OPTIONS;
        
        return view('partials.allCampaings', compact('membersSummaryAll', 'campaignOptions'));
    }

    

}
