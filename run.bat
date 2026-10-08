@echo off
chcp 65001 >nul
title Curriculo.online - Launcher

:: Detect PHP executable if not in PATH
set "PHP_CMD=php"
where php >nul 2>nul
if %errorlevel% neq 0 (
    if exist "C:\Users\%USERNAME%\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" (
        set "PHP_CMD=C:\Users\%USERNAME%\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
    )
)

:SELECT_LANG
cls
echo ========================================================================
echo    Curriculo.online - Launcher / Iniciador / Iniziatore
echo ========================================================================
echo.
echo  Please select your language / Seleccione su idioma:
echo  Selecione seu idioma / Seleziona la lingua:
echo.
echo    [1] English (Default / Preferential)
echo    [2] Español
echo    [3] Português
echo    [4] Italiano
echo.
set /p LANG_CHOICE="Enter choice [1-4] (Default is 1): "

if "%LANG_CHOICE%"=="" set LANG_CHOICE=1
if "%LANG_CHOICE%"=="1" goto MENU_EN
if "%LANG_CHOICE%"=="2" goto MENU_ES
if "%LANG_CHOICE%"=="3" goto MENU_PT
if "%LANG_CHOICE%"=="4" goto MENU_IT
goto MENU_EN

:: ========================================================================
:: 1. ENGLISH MENU (DEFAULT)
:: ========================================================================
:MENU_EN
cls
echo ========================================================================
echo    Curriculo.online - Control Panel [English]
echo ========================================================================
echo.
echo    [1] Start Integrated Application (PHP API + React on port 8000)
echo    [2] Start React Frontend in Development Mode (Vite port 3000)
echo    [3] Install / Migrate MySQL Database (db/install.php)
echo    [4] Run Automated Test Suite (teste/run_tests.php)
echo    [5] Start Docker Containers (devops/docker-compose.yml)
echo    [6] Open Documentation (README.md)
echo    [7] Change Language
echo    [0] Exit
echo.
set /p OPT="Select an option [0-7]: "

if "%OPT%"=="1" goto START_APP_EN
if "%OPT%"=="2" goto START_DEV_EN
if "%OPT%"=="3" goto DB_INSTALL_EN
if "%OPT%"=="4" goto RUN_TESTS_EN
if "%OPT%"=="5" goto DOCKER_EN
if "%OPT%"=="6" goto DOCS_EN
if "%OPT%"=="7" goto SELECT_LANG
if "%OPT%"=="0" exit /b
goto MENU_EN

:START_APP_EN
cls
echo Starting Curriculo.online on http://localhost:8000 ...
start http://localhost:8000
"%PHP_CMD%" -S 127.0.0.1:8000 router.php
pause
goto MENU_EN

:START_DEV_EN
cls
echo Starting React Vite Dev Server on port 3000...
cd frontend
start http://localhost:3000
npm run dev
cd ..
pause
goto MENU_EN

:DB_INSTALL_EN
cls
echo Running database installer...
"%PHP_CMD%" db/install.php
pause
goto MENU_EN

:RUN_TESTS_EN
cls
echo Running automated test suite...
"%PHP_CMD%" teste/run_tests.php
pause
goto MENU_EN

:DOCKER_EN
cls
echo Starting Docker containers...
cd devops
docker-compose up -d
cd ..
pause
goto MENU_EN

:DOCS_EN
start README.md
goto MENU_EN


:: ========================================================================
:: 2. SPANISH MENU
:: ========================================================================
:MENU_ES
cls
echo ========================================================================
echo    Curriculo.online - Panel de Control [Español]
echo ========================================================================
echo.
echo    [1] Iniciar Aplicación Integrada (API PHP + React en puerto 8000)
echo    [2] Iniciar Frontend React en Modo Desarrollo (Vite puerto 3000)
echo    [3] Instalar / Migrar Base de Datos MySQL (db/install.php)
echo    [4] Ejecutar Pruebas Automatizadas (teste/run_tests.php)
echo    [5] Iniciar Contenedores Docker (devops/docker-compose.yml)
echo    [6] Abrir Documentación (README.es.md)
echo    [7] Cambiar Idioma
echo    [0] Salir
echo.
set /p OPT="Seleccione una opción [0-7]: "

if "%OPT%"=="1" goto START_APP_ES
if "%OPT%"=="2" goto START_DEV_ES
if "%OPT%"=="3" goto DB_INSTALL_ES
if "%OPT%"=="4" goto RUN_TESTS_ES
if "%OPT%"=="5" goto DOCKER_ES
if "%OPT%"=="6" goto DOCS_ES
if "%OPT%"=="7" goto SELECT_LANG
if "%OPT%"=="0" exit /b
goto MENU_ES

:START_APP_ES
cls
echo Iniciando Curriculo.online en http://localhost:8000 ...
start http://localhost:8000
"%PHP_CMD%" -S 127.0.0.1:8000 router.php
pause
goto MENU_ES

:START_DEV_ES
cls
echo Iniciando servidor Vite en puerto 3000...
cd frontend
start http://localhost:3000
npm run dev
cd ..
pause
goto MENU_ES

:DB_INSTALL_ES
cls
echo Instalando base de datos MySQL...
"%PHP_CMD%" db/install.php
pause
goto MENU_ES

:RUN_TESTS_ES
cls
echo Ejecutando suite de pruebas...
"%PHP_CMD%" teste/run_tests.php
pause
goto MENU_ES

:DOCKER_ES
cls
echo Iniciando contenedores Docker...
cd devops
docker-compose up -d
cd ..
pause
goto MENU_ES

:DOCS_ES
start README.es.md
goto MENU_ES


:: ========================================================================
:: 3. PORTUGUESE MENU
:: ========================================================================
:MENU_PT
cls
echo ========================================================================
echo    Curriculo.online - Painel de Controle [Português]
echo ========================================================================
echo.
echo    [1] Iniciar Aplicação Integrada (API PHP + React na porta 8000)
echo    [2] Iniciar Frontend React em Modo Desenvolvimento (Vite porta 3000)
echo    [3] Instalar / Migrar Banco de Dados MySQL (db/install.php)
echo    [4] Executar Testes Automatizados (teste/run_tests.php)
echo    [5] Subir Contêineres Docker (devops/docker-compose.yml)
echo    [6] Abrir Documentação (README.pt.md)
echo    [7] Mudar Idioma
echo    [0] Sair
echo.
set /p OPT="Selecione uma opção [0-7]: "

if "%OPT%"=="1" goto START_APP_PT
if "%OPT%"=="2" goto START_DEV_PT
if "%OPT%"=="3" goto DB_INSTALL_PT
if "%OPT%"=="4" goto RUN_TESTS_PT
if "%OPT%"=="5" goto DOCKER_PT
if "%OPT%"=="6" goto DOCS_PT
if "%OPT%"=="7" goto SELECT_LANG
if "%OPT%"=="0" exit /b
goto MENU_PT

:START_APP_PT
cls
echo Iniciando Curriculo.online em http://localhost:8000 ...
start http://localhost:8000
"%PHP_CMD%" -S 127.0.0.1:8000 router.php
pause
goto MENU_PT

:START_DEV_PT
cls
echo Iniciando servidor Vite na porta 3000...
cd frontend
start http://localhost:3000
npm run dev
cd ..
pause
goto MENU_PT

:DB_INSTALL_PT
cls
echo Instalando banco de dados MySQL...
"%PHP_CMD%" db/install.php
pause
goto MENU_PT

:RUN_TESTS_PT
cls
echo Executando testes automatizados...
"%PHP_CMD%" teste/run_tests.php
pause
goto MENU_PT

:DOCKER_PT
cls
echo Subindo contêineres Docker...
cd devops
docker-compose up -d
cd ..
pause
goto MENU_PT

:DOCS_PT
start README.pt.md
goto MENU_PT


:: ========================================================================
:: 4. ITALIAN MENU
:: ========================================================================
:MENU_IT
cls
echo ========================================================================
echo    Curriculo.online - Pannello di Controllo [Italiano]
echo ========================================================================
echo.
echo    [1] Avvia Applicazione Integrata (API PHP + React sulla porta 8000)
echo    [2] Avvia Frontend React in Modalità Sviluppo (Vite porta 3000)
echo    [3] Installa / Migra Database MySQL (db/install.php)
echo    [4] Esegui Test Automatizzati (teste/run_tests.php)
echo    [5] Avvia Container Docker (devops/docker-compose.yml)
echo    [6] Apri Documentazione (README.it.md)
echo    [7] Cambia Lingua
echo    [0] Esci
echo.
set /p OPT="Seleziona un'opzione [0-7]: "

if "%OPT%"=="1" goto START_APP_IT
if "%OPT%"=="2" goto START_DEV_IT
if "%OPT%"=="3" goto DB_INSTALL_IT
if "%OPT%"=="4" goto RUN_TESTS_IT
if "%OPT%"=="5" goto DOCKER_IT
if "%OPT%"=="6" goto DOCS_IT
if "%OPT%"=="7" goto SELECT_LANG
if "%OPT%"=="0" exit /b
goto MENU_IT

:START_APP_IT
cls
echo Avvio di Curriculo.online su http://localhost:8000 ...
start http://localhost:8000
"%PHP_CMD%" -S 127.0.0.1:8000 router.php
pause
goto MENU_IT

:START_DEV_IT
cls
echo Avvio server Vite sulla porta 3000...
cd frontend
start http://localhost:3000
npm run dev
cd ..
pause
goto MENU_IT

:DB_INSTALL_IT
cls
echo Installazione database MySQL...
"%PHP_CMD%" db/install.php
pause
goto MENU_IT

:RUN_TESTS_IT
cls
echo Esecuzione suite di test...
"%PHP_CMD%" teste/run_tests.php
pause
goto MENU_IT

:DOCKER_IT
cls
echo Avvio container Docker...
cd devops
docker-compose up -d
cd ..
pause
goto MENU_IT

:DOCS_IT
start README.it.md
goto MENU_IT
