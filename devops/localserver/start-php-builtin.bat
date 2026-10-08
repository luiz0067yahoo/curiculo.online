@echo off
REM ==============================================================================
REM INICIALIZADOR DO SERVIDOR LOCAL EMBUTIDO PHP (WINDOWS)
REM ==============================================================================

setlocal enabledelayedexpansion

set PORT=8000
set HOST=127.0.0.1

echo ======================================================================
echo    INICIANDO SERVIDOR LOCAL PHP EMBUTIDO (http://%HOST%:%PORT%)
echo ======================================================================

REM Localizar PHP
where php >nul 2>nul
if %ERRORLEVEL% equ 0 (
    set PHP_EXE=php
    goto :RUN_SERVER
)

if exist "C:\Users\10345\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" (
    set "PHP_EXE=C:\Users\10345\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
    goto :RUN_SERVER
)

if exist "C:\xampp\php\php.exe" (
    set "PHP_EXE=C:\xampp\php\php.exe"
    goto :RUN_SERVER
)

echo [ERRO] Binario do PHP nao encontrado.
pause
exit /b 1

:RUN_SERVER
cd ..\..
echo Executando: "%PHP_EXE%" -S %HOST%:%PORT% router.php
start "" "http://%HOST%:%PORT%"
"%PHP_EXE%" -S %HOST%:%PORT% router.php
