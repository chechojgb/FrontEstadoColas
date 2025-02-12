<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación Tablero StateSkill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }
        h1, h2 {
            color: #333;
        }
        code {
            background: #f4f4f4;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Documentación Tablero StateSkill</h1>
    <p>El tablero <strong>StateSkill</strong> está diseñado para monitorear el estado de las colas de Asterisk, brindando mayor control sobre agentes y llamadas.</p>
    
    <h2>Sección de Skills</h2>
    <p>El código se estructura en múltiples métodos privados para mejorar la organización y flexibilidad. La actualización de los datos ocurre cada 8 segundos dinámicamente.</p>
    
    <h3>Funcionamiento</h3>
    <p>Los datos se obtienen desde dos fuentes principales: el servidor y la base de datos. A continuación, se detallan los pasos clave:</p>
    <ul>
        <li>El usuario selecciona una skill desde un selector.</li>
        <li>El índice de la skill se extrae de un array dentro del controlador.</li>
        <li>Este índice se almacena en la variable <code>$selectedCampaign</code> y en una sesión.</li>
        <li>Se genera dinámicamente un comando que se ejecutará en el servidor:</li>
    </ul>
    
    <pre><code>rasterisk -rx 'queue show q{$campaignIndex}' | sort</code></pre>
    
    <h3>Conexión con el Servidor</h3>
    <p>Para ejecutar el comando en el servidor, se utiliza la librería <a href="https://phpseclib.com/docs/connect">phpseclib</a>, permitiendo una conexión momentánea para obtener los datos.</p>
    
    <h3>Procesamiento de Datos</h3>
    <p>Los datos devueltos suelen ser extensos y técnicos, por lo que se realiza una limpieza y procesamiento para mejorar la comprensión de la información mostrada en el tablero.</p>
    
    <h2>Sección de Todas las Colas</h2>
    <p>Además del monitoreo por skill, el tablero muestra un resumen general de todas las colas, proporcionando una visión completa del estado del sistema.</p>
</body>
</html>
