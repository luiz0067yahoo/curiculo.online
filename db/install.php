<?php
/**
 * Script de Instalação e Migração do Banco de Dados (100% PHP)
 * Executa o schema MySQL e Seed diretamente em PHP, sem arquivos .sql externos
 * Similar à estrutura do projeto ESP32 Urna Eletronica
 */

require_once __DIR__ . '/schema.php';

$host = getenv('DB_HOST') ?: '127.0.0.1';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'curriculo_online';

$isCli = (php_sapi_name() === 'cli');

function outputMsg(string $msg, string $type = 'info'): void {
    global $isCli;
    if ($isCli) {
        $prefix = match($type) {
            'success' => "[SUCESSO] ",
            'error'   => "[ERRO] ",
            'warn'    => "[AVISO] ",
            default   => "[INFO] "
        };
        echo $prefix . $msg . PHP_EOL;
    } else {
        $color = match($type) {
            'success' => '#10b981',
            'error'   => '#ef4444',
            'warn'    => '#f59e0b',
            default   => '#3b82f6'
        };
        echo "<div style='font-family:sans-serif;margin:4px 0;color:{$color}'>{$msg}</div>";
    }
}

outputMsg("Iniciando instalação do banco de dados `{$dbname}` via PHP...");

if (!extension_loaded('pdo_mysql')) {
    outputMsg("Extensão PHP 'pdo_mysql' não detectada no ambiente.", 'warn');
    outputMsg("O sistema continuará operando através da camada de persistência JSON resiliente em `backend/data_storage/`.", 'info');
    exit(0);
}

try {
    // 1. Conexão inicial no MySQL sem selecionar banco
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    outputMsg("Conexão com servidor MySQL estabelecida com sucesso.", 'success');

    // 2. Criar banco se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $pdo->exec("USE `{$dbname}`;");
    outputMsg("Banco de dados `{$dbname}` pronto e selecionado.", 'success');

    // 3. Criar tabelas via PHP (DatabaseSchema)
    DatabaseSchema::createTables($pdo);
    outputMsg("Tabelas criadas com sucesso a partir de `db/schema.php`.", 'success');

    // 4. Executar Seed inicial de dados
    $seedResult = DatabaseSchema::seed($pdo);
    outputMsg("Carga inicial (Seed) aplicada com sucesso: {$seedResult['etapas']} etapas e {$seedResult['modelos']} modelos.", 'success');

    // 5. Listar tabelas ativas
    $stmt = $pdo->query("SHOW TABLES;");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    outputMsg("Tabelas ativas no banco: " . implode(', ', $tables), 'info');

    outputMsg("Instalação 100% PHP concluída com êxito!", 'success');

} catch (Throwable $e) {
    outputMsg("Falha ao instalar no MySQL: " . $e->getMessage(), 'error');
    outputMsg("Dica: Verifique se o MySQL (XAMPP/Laragon/Docker) está em execução na porta {$port}.", 'warn');
}
