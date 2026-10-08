<?php
/**
 * Diagnóstico e Configuração do Servidor Local
 * Verifica requisitos de ambiente PHP, extensões e diretórios de dados
 */

$isCli = (php_sapi_name() === 'cli');

function printCheck(string $title, bool $pass, string $note = ''): void {
    global $isCli;
    $status = $pass ? "[OK]" : "[AVISO]";
    $color = $pass ? "#10b981" : "#f59e0b";
    if ($isCli) {
        echo sprintf("%-10s %-40s %s\n", $status, $title, $note);
    } else {
        echo "<div style='font-family:monospace;margin:4px 0;color:{$color}'><b>{$status}</b> {$title} <i>{$note}</i></div>";
    }
}

echo ($isCli ? "=== DIAGNÓSTICO DO SERVIDOR LOCAL (PHP) ===\n\n" : "<h3>Diagnóstico do Servidor Local</h3>");

// 1. Versão do PHP
$phpVersion = PHP_VERSION;
$versionPass = version_compare($phpVersion, '8.1.0', '>=');
printCheck("Versão do PHP ($phpVersion >= 8.1)", $versionPass, $versionPass ? "Adequada" : "Recomenda-se PHP 8.2+");

// 2. Extensões Essenciais
$extensions = [
    'pdo' => 'Camada de abstração PDO',
    'pdo_mysql' => 'Driver de conexão MySQL',
    'json' => 'Manipulação de JSON da API',
    'mbstring' => 'Manipulação de strings multi-byte (i18n)',
    'curl' => 'Cliente HTTP para integrações',
    'openssl' => 'Criptografia e segurança de sessão'
];

foreach ($extensions as $ext => $desc) {
    $loaded = extension_loaded($ext);
    printCheck("Extensão '{$ext}'", $loaded, $loaded ? $desc : "Não instalada (pode usar modo resiliente JSON)");
}

// 3. Diretórios de Armazenamento Local
$dataDir = __DIR__ . '/../../backend/data_storage';
$dirExists = is_dir($dataDir) && is_writable($dataDir);
printCheck("Permissão em backend/data_storage", $dirExists, $dirExists ? "Leitura/Escrita OK" : "Verifique permissões");

// 4. Arquivos Essenciais
$requiredFiles = [
    '../../router.php' => 'Roteador do servidor embutido',
    '../../backend/index.php' => 'Controlador da API REST',
    '../../db/schema.php' => 'Esquema de banco de dados 100% PHP',
    '../../frontend/dist/index.html' => 'Bundle compilado do Frontend'
];

foreach ($requiredFiles as $file => $desc) {
    $exists = file_exists(__DIR__ . '/' . $file);
    printCheck("Arquivo: {$desc}", $exists, $exists ? "Presente" : "Execute 'npm run build' se for frontend");
}

echo ($isCli ? "\nDiagnóstico concluído.\n" : "<hr><p>Diagnóstico concluído.</p>");
