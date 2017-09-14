:: Se debe configurar el proxy "HTTP_PROXY" en las variables de entorno.
::	HTTP_PROXY 		http://usuario:contrasena@proxy_server:puerto

:: Se debe configurar el "path" de php en las variables de entorno.
::	PATH 			C:\xampp\php

:: Oculta los mensajes y la ubicación desde donde se ejecuta el bat
@echo off
prompt $G

php composer.phar self-update

php composer.phar update
set /p DUMMY=Presione ENTER para continuar...