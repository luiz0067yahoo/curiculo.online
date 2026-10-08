#!/bin/bash
# ==============================================================================
# INICIALIZADOR DO SERVIDOR LOCAL EMBUTIDO PHP (LINUX / MACOS)
# ==============================================================================

PORT=8000
HOST="127.0.0.1"

echo "======================================================================"
echo "   INICIANDO SERVIDOR LOCAL PHP EMBUTIDO (http://${HOST}:${PORT})"
echo "======================================================================"

if ! command -v php &> /dev/null; then
    echo "[ERRO] PHP não está instalado ou não foi encontrado no PATH."
    exit 1
fi

cd "$(dirname "$0")/../.."

echo "Executando: php -S ${HOST}:${PORT} router.php"
php -S "${HOST}:${PORT}" router.php
