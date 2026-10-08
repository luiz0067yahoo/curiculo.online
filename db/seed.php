<?php
/**
 * Script de Seed para Popular e Atualizar Dados Iniciais (100% PHP)
 * Similar à estrutura do projeto ESP32 Urna Eletronica
 */

require_once __DIR__ . '/schema.php';
require_once __DIR__ . '/../backend/config/Database.php';
require_once __DIR__ . '/../backend/models/Etapa.php';
require_once __DIR__ . '/../backend/models/Modelo.php';
require_once __DIR__ . '/../backend/models/Curriculo.php';

$isCli = (php_sapi_name() === 'cli');

function logSeed(string $msg): void {
    global $isCli;
    echo ($isCli ? "[SEED] " : "<p>[SEED] ") . $msg . ($isCli ? PHP_EOL : "</p>");
}

logSeed("Iniciando carga e verificação de dados (Seed 100% PHP)...");

$pdo = Database::getConnection();

if ($pdo) {
    try {
        $result = DatabaseSchema::seed($pdo);
        logSeed("Seed aplicado via PDO MySQL: {$result['etapas']} etapas e {$result['modelos']} modelos sincronizados.");
    } catch (Throwable $e) {
        logSeed("Aviso: Falha ao sincronizar via PDO (" . $e->getMessage() . "). Verificando fallback.");
    }
} else {
    logSeed("Modo armazenamento local/resiliente ativo.");
}

// 1. Verificação de Etapas
$etapas = EtapaModel::getAll();
logSeed("Etapas cadastradas verificadas: " . count($etapas) . " etapas ativas.");

// 2. Verificação de Modelos
$modelos = ModeloModel::getAll();
logSeed("Modelos de currículo Lattes verificados: " . count($modelos) . " modelos disponíveis.");

logSeed("Seed finalizado com sucesso!");
