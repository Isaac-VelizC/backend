import sys
import json

try:
    # Obtener los parámetros de la línea de comandos
    ingredientes_nombres_json = sys.argv[1]
    tipo_plato = sys.argv[2]
    # Imprimir los argumentos para depuración
    # print("Argumento 1:", ingredientes_nombres_json)
    # print("Argumento 2:", tipo_plato)
    # Decodificar la cadena JSON
    ingredientes_nombres = json.loads(ingredientes_nombres_json)
    # Imprimir los datos recibidos
    print("Ingredientes:", ingredientes_nombres)
    print("Tipo de plato:", tipo_plato)
except Exception as e:
    print("Error al procesar los argumentos:", str(e))
