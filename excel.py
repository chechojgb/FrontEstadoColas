import paramiko
import pandas as pd
import re

# Verificar si los módulos están correctamente instalados
def verificar_dependencias():
    try:
        import paramiko
        import pandas as pd
    except ModuleNotFoundError as e:
        print(f"Error: {e}. Asegúrate de tener instalados los módulos necesarios ejecutando: pip install paramiko pandas")
        exit(1)

verificar_dependencias()

def conectar_servidor(host, usuario, clave):
    """Establece conexión SSH con el servidor."""
    cliente = paramiko.SSHClient()
    cliente.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    cliente.connect(hostname=host, username=usuario, password=clave)
    return cliente

def buscar_en_logs(cliente, patron):
    """Ejecuta grep en los logs de Asterisk y devuelve las coincidencias."""
    comando = f'grep {patron} /var/log/asterisk/messages'
    stdin, stdout, stderr = cliente.exec_command(comando)
    return stdout.read().decode().splitlines()

def extraer_identificador(linea):
    """Extrae el identificador después de AGI(""" 
    match = re.search(r'AGI\("(.+?)"', linea)
    return match.group(1) if match else None

def buscar_grabacion(cliente, identificador):
    """Busca si existe una grabación en los logs."""
    logs = buscar_en_logs(cliente, identificador)
    for linea in logs:
        if 'MixMonitor' in linea:
            return identificador  # Retorna el ID de grabación si existe
    return "No hay grabación"

def procesar_csv(archivo_csv, host, usuario, clave):
    """Lee el CSV, busca en los logs y actualiza la columna call_id con la grabación o mensaje."""
    try:
        df = pd.read_csv(archivo_csv, delimiter=';', encoding='ISO-8859-1')
    except Exception as e:
        print(f"Error al leer el archivo CSV: {e}")
        exit(1)
    
    if 'unique_id' not in df.columns or 'call_id' not in df.columns:
        print("El archivo no contiene las columnas necesarias: 'unique_id' y 'call_id'.")
        exit(1)

    cliente = conectar_servidor(host, usuario, clave)
    
    procesados = {}  # Diccionario para almacenar resultados de unique_id

    for index, row in df.iterrows():
        unique_id = str(row['unique_id'])

        # Si ya procesamos este unique_id, marcamos como "repetido" y seguimos
        if unique_id in procesados:
            df.at[index, 'call_id'] = "repetido"
            continue

        print(f"Procesando fila {index + 1} - unique_id: {unique_id}")  # Log para seguimiento

        logs_encontrados = buscar_en_logs(cliente, unique_id)
        identificador = None

        for linea in logs_encontrados:
            identificador = extraer_identificador(linea)
            if identificador:
                break
        
        if identificador:
            grabacion = buscar_grabacion(cliente, identificador)
        else:
            grabacion = "No hay grabación"

        # Guardamos el resultado para evitar consultas repetidas
        procesados[unique_id] = grabacion
        df.at[index, 'call_id'] = grabacion  # Actualizar la columna call_id
    
    cliente.close()

    try:
        df.to_csv('resultados_actualizados.csv', index=False, sep=';')  # Guardar en un nuevo archivo CSV
        print("Proceso completado. Resultados guardados en 'resultados_actualizados.csv'")
    except Exception as e:
        print(f"Error al guardar el archivo CSV: {e}")
        exit(1)

# Datos de conexión al servidor
HOST = '10.57.251.179'
USUARIO = 'root'
CLAVE = 'xbn4yobINpz*rtpjz+'

# Ejecutar el script
procesar_csv('datos.csv', HOST, USUARIO, CLAVE)
