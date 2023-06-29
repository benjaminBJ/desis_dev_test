# Sistema de Votación

Sistema de votación desarrollado en PHP para un ejercicio de evaluación desis.

## Requisitos

- PHP (versión > 8.0.0)
- Postgresql 
- Apache server (version > 2.4)
- pgAdmin 
- Navegador Web compatible con PHP y JavaSript

## Instalación

1. Clona este repositorio en tu máquina local

2. Configura de la base de datos:
- Ejecutar script.sql desde PgAdmin

3. Configuración del servidor web:
- Configurar servidor web Apache para que apunte al directorio raíz del proyecto.

4. Configuración del archivo de conexión a la base de datos:
- En los archivos .php, actualiza las variables `$host`, `$usuario`, `$contrasena` y `$basedatos` con la información de conexión a tu base de datos.

5. Accede al sistema de votación:
- Abre un navegador web y visita la URL correspondiente al servidor web configurado. (http://localhost por defecto)
## Uso

1. Completa el formulario de votación con los datos requeridos.
2. Haz clic en el botón "Votar" para enviar el formulario.
3. El resultado de la votación se mostrará en la página.
