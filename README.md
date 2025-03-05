<h1>Documentación Tablero StateSkill</h1>

<p>El tablero <strong>StateSkill</strong> está diseñado para monitorear el estado de las colas de Asterisk, brindando mayor control sobre agentes y llamadas.</p>

<h2>Sección de Skills</h2>

<p>El código se estructura en múltiples métodos privados para mejorar la organización y flexibilidad. La actualización de los datos ocurre cada 8 segundos dinámicamente.</p>

<h3>Funcionamiento</h3>

<ol>
    <li>El usuario selecciona una skill desde un selector.</li>
    <li>El índice de la skill se extrae de un array dentro del controlador.</li>
    <li>Este índice se almacena en la variable <code>$selectedCampaign</code> y en una sesión.</li>
    <li>Se genera dinámicamente un comando que se ejecutará en el servidor:</li>
</ol>

<pre>
<code>rasterisk -rx 'queue show q{$campaignIndex}' | sort</code>
</pre>

<h3>Conexión con el Servidor</h3>

<p>Para ejecutar el comando en el servidor, se utiliza la librería <a href="https://phpseclib.com/docs/connect">phpseclib</a>, permitiendo una conexión momentánea para obtener los datos.</p>

<h3>Procesamiento de Datos</h3>

<p>Los datos devueltos suelen ser extensos y técnicos, por lo que se realiza una limpieza y procesamiento para mejorar la comprensión de la información mostrada en el tablero.</p>

<h2>Sección de Todas las Colas</h2>

<p>Además del monitoreo por skill, el tablero muestra un resumen general de todas las colas, proporcionando una visión completa del estado del sistema.</p>

<hr>

<h2>Explicación del Código</h2>

<h3><code>executeCommand(Request $request)</code></h3>

<p>Este método gestiona la ejecución de comandos en el servidor para obtener información sobre las colas.</p>

<pre>
<code>
public function executeCommand(Request $request) {
    $timing = [];
    $campaignIndex = $request->input('campaign');
    session(['selectedCampaign' => $campaignIndex]);
    $command = "rasterisk -rx 'queue show q{$campaignIndex}' | sort";

    $output = $this->getSSHOutput($command);
    $cleanOutput = $this->removeAnsiCharacters($output);
    
    return view('campaigns', [
        'calls' => $this->extractCallsInQueue($cleanOutput),
        'members' => $this->extractQueueMembersSummary($cleanOutput),
        'agents' => $this->getAgentDetails($cleanOutput),
    ]);
}
</code>
</pre>

<h3><code>validateCampaign(Request $request)</code> y <code>validateOperation(Request $request)</code></h3>

<p>Estos métodos validan los parámetros recibidos en la solicitud:</p>

<pre>
<code>
return $request->validate([
    'campaign' => 'required|integer|min:1|max:' . count(self::CAMPAIGN_OPTIONS),
]);
</code>
</pre>

<h3><code>getSSHOutput(string $command): ?string</code></h3>

<p>Establece conexión con el servidor usando <code>phpseclib</code>:</p>

<pre>
<code>
$user = env('USER_SERVER');
$password = env('PASSWORD_SERVER');
$host_server = env('HOST_SERVER');
$ssh = new SSH2($host_server);
if (!$ssh->login($user, $password)) {
    return null;
}
return $ssh->exec($command);
</code>
</pre>

<h3><code>removeAnsiCharacters(string $output): string</code></h3>

<p>Elimina caracteres ANSI de la salida:</p>

<pre>
<code>
$ansiEscape = '/\x1B\[.*?m/';
return preg_replace($ansiEscape, '', $output);
</code>
</pre>

<h3><code>extractCallsInQueue(string $output): array</code></h3>

<p>Extrae las llamadas en espera, incluyendo SIP e IAX2:</p>

<pre>
<code>
$queueCallsPattern = '/\d+.\s+(?:SIP|IAX2)\/\S+\s+\(.*?\)/m';
preg_match_all($queueCallsPattern, $cleanOutput, $matches);
</code>
</pre>

<h3><code>extractQueueMembersSummary(string $output): array</code></h3>

<p>Obtiene el resumen de miembros en la cola:</p>

<pre>
<code>
$membersPattern = '/^Q\d+\s+.*?strategy.*?$/m';
preg_match_all($membersPattern, $output, $matches);
</code>
</pre>

<h3><code>extractQueueAll(string $output): array</code></h3>

<p>Extrae el estado de todas las colas:</p>

<pre>
<code>
$pattern = '/Q(\d+).*?has\s+(\d+)\s+calls/';
preg_match_all($pattern, $output, $matches, PREG_SET_ORDER);
</code>
</pre>
