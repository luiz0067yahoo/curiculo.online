@echo off
REM ==============================================================================
REM SCRIPT DE INICIALIZACAO DE POD NATIVO ROOTLESS DO PODMAN (WINDOWS)
REM ==============================================================================

setlocal enabledelayedexpansion

set POD_NAME=curriculo-pod

echo === Verificando Podman ===
where podman >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo [ERRO] Podman nao encontrado no PATH do Windows.
    pause
    exit /b 1
)

echo === Removendo pod antigo se existente ===
podman pod rm -f %POD_NAME% >nul 2>nul

echo === Criando Podman Pod (%POD_NAME%) ===
podman pod create --name %POD_NAME% -p 3000:80 -p 8000:8000 -p 3306:3306

echo === Iniciando MySQL no Pod ===
podman run -d --pod %POD_NAME% --name pod-mysql -e MYSQL_DATABASE=curriculo_online -e MYSQL_ROOT_PASSWORD=root docker.io/library/mysql:8.0

echo === Construindo imagens Backend e Frontend ===
podman build -t curriculo-backend:latest -f ..\docker\Dockerfile.backend ..\..
podman build -t curriculo-frontend:latest -f ..\docker\Dockerfile.frontend ..\..

echo === Iniciando Backend no Pod ===
podman run -d --pod %POD_NAME% --name pod-backend -e DB_HOST=127.0.0.1 -e DB_PORT=3306 -e DB_NAME=curriculo_online -e DB_USER=root -e DB_PASS=root curriculo-backend:latest

echo === Iniciando Frontend no Pod ===
podman run -d --pod %POD_NAME% --name pod-frontend curriculo-frontend:latest

echo === Podman Pod Inicializado com Sucesso! ===
echo Frontend: http://localhost:3000
echo Backend:  http://localhost:8000
pause
