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
        $timing = [];
        $timing['start'] = microtime(true);

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
            session(['operationIndex' => $operationIndex, 'campaignIndex' => null]);

            $operationQueues = [
                1 => [17, 18, 19, 20, 21, 22, 24, 25, 26],
                2 => [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23],
                3 => [27, 28, 29, 30, 31, 32, 33, 34, 35, 37],
                4 => [1, 2, 3],
            ];

            if (!isset($operationQueues[$operationIndex])) {
                return response()->json(['error' => 'Operación no válida'], 400);
            }

            $commands = array_map(fn($queue) => "rasterisk -rx 'queue show q{$queue}' | grep -v 'Unavailable' &", $operationQueues[$operationIndex]);
            $command = implode(' ', $commands) . ' wait';
            // dd($command);
        } else {
            return response()->json(['error' => 'No se enviaron datos válidos'], 400);
        }

        $timing['command_start'] = microtime(true);
        $output = $this->getSSHOutput($command);
        $timing['command_end'] = microtime(true);
        // dd($output);
        if (!$output) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }

        $timing['all_campaign_start'] = microtime(true);
        $allCampOutput = $this->getSSHOutput("rasterisk -rx 'queue show' | sort");
        $timing['all_campaign_end'] = microtime(true);

        $timing['clean_output_start'] = microtime(true);
        $cleanOutput = $this->removeAnsiCharacters($output);
        $timing['clean_output_end'] = microtime(true);

        session(['cleanOutput' => $cleanOutput]);

        $timing['calls_in_queue_start'] = microtime(true);
        $callsInQueue = $this->extractCallsInQueue($cleanOutput);
        $timing['calls_in_queue_end'] = microtime(true);

        $timing['queue_members_start'] = microtime(true);
        $queueMembersSummary = $this->extractQueueMembersSummary($cleanOutput);
        $timing['queue_members_end'] = microtime(true);

        $timing['agent_details_start'] = microtime(true);
        $agentDetails = collect($this->getAgentDetails($cleanOutput))->unique('name')->values()->all();
        $timing['agent_details_end'] = microtime(true);

        $timing['total_end'] = microtime(true);

        $executionTimes = [
            'Total Execution Time' => $timing['total_end'] - $timing['start'],
            'Command Execution' => $timing['command_end'] - $timing['command_start'],
            'All Campaign Execution' => $timing['all_campaign_end'] - $timing['all_campaign_start'],
            'Clean Output Processing' => $timing['clean_output_end'] - $timing['clean_output_start'],
            'Calls in Queue Extraction' => $timing['calls_in_queue_end'] - $timing['calls_in_queue_start'],
            'Queue Members Extraction' => $timing['queue_members_end'] - $timing['queue_members_start'],
            'Agent Details Extraction' => $timing['agent_details_end'] - $timing['agent_details_start'],
        ];

        $maxExecution = collect($executionTimes)->sortDesc()->first();
        $slowestProcess = collect($executionTimes)->search($maxExecution);
        // dd($agentDetails);
        // dd([
        //     'Execution Times' => $executionTimes,
        //     'Slowest Process' => $slowestProcess,
        // ]);

        return view('campaigns', [
            'campaign' => $selectedCampaign,
            'agentDetails' => $agentDetails,
            'callsInQueue' => $callsInQueue,
            'queueMembersSummary' => $queueMembersSummary,
            'membersSummaryAll' => $this->extractQueueAll($allCampOutput),
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


    private function getAgentDetails(string $output): array
    {
        $pattern = '/SIP\/(\d+)\s+\((.*?)\)\s+\((.*?)\)/';
        preg_match_all($pattern, $output, $matches, PREG_SET_ORDER);
        $filteredMatches = collect($matches)
            ->filter(fn($match) => !in_array($match[3], ['Unavailable', 'Invalid']))
            ->unique(fn($match) => $match[1])
            ->values();
        $extensions = $filteredMatches->pluck(1)->unique()->values()->all();
        $users = DB::table('usersv2')->whereIn('extension', $extensions)->get()->keyBy('extension');
        $userIds = $users->pluck('id')->all();
        $calls = DB::table('calls')
            ->whereIn('user_id', $userIds)
            ->orderBy('start', 'desc')
            ->get()
            ->groupBy('user_id');
        $command = "rasterisk -rx 'sip show peers' && rasterisk -rx 'core show channels verbose'";
        $output = $this->getSSHOutput($command);

        
        if (!$output) {
            return back()->withErrors(['error' => 'Failed to connect to the server.']);
        }
        $agentDetails = $filteredMatches->map(function ($match) use ($users, $calls, $output) {
            $extension = $match[1];
            $callStatus = $match[3];
            $user = $users[$extension] ?? null;
            if (!$user) {
                return [
                    'extension' => $extension,
                    'message' => 'User Info not found',
                    'state' => $callStatus,
                ];
            }
            $call = $calls[$user->id]->first() ?? null;
            $callState = optional($call)->end ? 'Call finished' : 'Call in progress';

            preg_match("/^$extension\/$extension\s+([\d\.]+)/m", $output, $ipMatch);
            $ipUser = $ipMatch[1] ?? 'Not IP';

            preg_match_all("/(?:SIP\/\S+\s+)?\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+\S+\s+(\d{2}:\d{2}:\d{2})\s+$extension\b/", $output, $durations);
            $duration1 = $durations[1][0] ?? 'NA';
            $duration2 = $durations[1][1] ?? 'NA';
            // dd($durations[1][0] ?? 'Not Available');
            return [
                'call_id' => optional($call)->id,
                'extension' => $extension,
                'name' => $user->name,
                'call_state' => $callState,
                'state' => $callStatus,
                'ipUser' => $ipUser,
                'duration1' => $duration1,
                'duration2' => $duration2,
            ];
        })->all();


        return $agentDetails;
    }

    // private function getAgentDetails(string $output): array
    // {
    //     $pattern = '/SIP\/(\d+)\s+\((.*?)\)\s+\((.*?)\)/';
    //     preg_match_all($pattern, $output, $matches, PREG_SET_ORDER);
    //     $filteredMatches = array_filter($matches, function ($match) {
    //         return $match[3] !== "Unavailable" && $match[3] !== 'Invalid';
    //     });
    //     $filteredMatches = collect($filteredMatches)
    //     ->unique(fn($match) => $match[1])
    //     ->values()
    //     ->all();
    //     $agentDetails = [];
    //     foreach ($filteredMatches as $match) {
    //         $extension = $match[1];
    //         $ringinuseStatus = $match[2];
    //         $callStatus = $match[3];
    //         $user = DB::table('usersv2')->where('extension', $extension)->first();
    //         if ($user) {
                
    //             $call = DB::table('calls')->where('user_id', $user->id)->orderBy('start', 'desc')->first();
    //             $callState = $call && isset($call->end) ? 'Call finished' : 'Call in progress';
    //             $command = "rasterisk -rx 'sip show peers' |grep $extension";
    //             $output = $this->getSSHOutput($command);
    //             if (!$output) {
    //                 return back()->withErrors(['error' => 'Failed to connect to the server.']);
    //             }
    //             preg_match('/\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/', $output, $matches);
    //             if (!empty($matches)) {
    //                 $ipUser = $matches[0];
    //             } else {
    //                 $ipUser = 'Not IP';
    //             }
    //             $agentDetails[] = [
    //                 'call_id' => $call->id ?? null,
    //                 'extension' => $extension,
    //                 'name' => $user->name,
    //                 'call_state' => $callState,
    //                 'state' => $callStatus,
    //                 'ipUser' => $ipUser,
    //             ];
    //         } else {
    //             $agentDetails[] = [
    //                 'extension' => $extension,
    //                 'message' => 'User Info not found',
    //                 'state' => $callStatus,
    //             ];
    //         }
    //     }
    //     return $agentDetails;
    // }

    

    private function getAgentDetailsForCampaign($campaignIndex)
    {
        $command = $campaignIndex === count(self::CAMPAIGN_OPTIONS)
            ? "rasterisk -rx 'queue show' | sort"
            : "rasterisk -rx 'queue show q{$campaignIndex}' | sort";
        $output = $this->getSSHOutput($command);
        if (!$output) {
            throw new \Exception('Failed to connect to the server.');
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
            throw new \Exception('Failed to connect to the server.');
        }
        $cleanOutput = $this->removeAnsiCharacters($output);
        $agentDetails = $this->getAgentDetails($cleanOutput);
        $agentDetails = collect($agentDetails)->unique('name')->values()->all();
        return $agentDetails = collect($agentDetails)->unique('name')->values()->all();
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
