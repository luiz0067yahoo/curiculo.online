<?php
/**
 * Suíte de Testes Automatizados - Curriculo.online
 * Executa todas as asserções de backend, banco de dados e APIs
 */

echo "========================================================\n";
echo "   INICIANDO SUÍTE DE TESTES AUTOMATIZADOS              \n";
echo "========================================================\n\n";

$testsPassed = 0;
$testsFailed = 0;

function assertTest(string $name, bool $condition, string $details = ''): void {
    global $testsPassed, $testsFailed;
    if ($condition) {
        echo "[ PASS ] {$name}\n";
        $testsPassed++;
    } else {
        echo "[ FAIL ] {$name}" . ($details ? " -> {$details}" : "") . "\n";
        $testsFailed++;
    }
}

// 1. Teste de Configuração e Conexão de Banco
require_once __DIR__ . '/../backend/config/Database.php';
assertTest("Carregamento da classe Database", class_exists('Database'));

// 2. Teste do Modelo de Etapas
require_once __DIR__ . '/../backend/models/Etapa.php';
$etapas = EtapaModel::getAll();
assertTest("Recuperação de etapas do currículo", is_array($etapas) && count($etapas) >= 10, "Total: " . count($etapas));

// 3. Teste de Modelo de Currículos Lattes
require_once __DIR__ . '/../backend/models/Modelo.php';
$modelos = ModeloModel::getAll();
assertTest("Recuperação dos modelos de currículo Lattes", is_array($modelos) && count($modelos) === 5, "Total: " . count($modelos));

// 4. Teste de Salvamento de Currículo
require_once __DIR__ . '/../backend/models/Curriculo.php';
$testPayload = [
    'titulo' => 'Teste Unitário Lattes',
    'nome_completo' => 'Dr. Teste Automatizado',
    'email' => 'teste@pesquisa.online',
    'modelo_slug' => 'lattes-tradicional',
    'cor_tema' => '#0f3a68',
    'dados' => [
        'dados_basicos' => ['nome' => 'Dr. Teste Automatizado', 'email' => 'teste@pesquisa.online'],
        'formacao_academica' => [
            ['nivel' => 'Doutorado', 'curso' => 'Computação', 'instituicao' => 'USP', 'ano_conclusao' => '2024']
        ]
    ]
];
$saved = CurriculoModel::save($testPayload);
assertTest("Salvamento de currículo completo", !empty($saved['uuid']) && $saved['nome_completo'] === 'Dr. Teste Automatizado');

$fetched = CurriculoModel::getByUuid($saved['uuid']);
assertTest("Recuperação de currículo salvo por UUID", !empty($fetched) && $fetched['uuid'] === $saved['uuid']);

// 5. Teste de Reordenação de Etapas
$originalIds = array_map(fn($e) => $e['id'], $etapas);
$reversedIds = array_reverse($originalIds);
$reordered = EtapaModel::reorder($reversedIds);
assertTest("Reordenação de etapas no backend", $reordered[0]['id'] === end($originalIds));
// Restaurar ordem
EtapaModel::reorder($originalIds);

echo "\n========================================================\n";
echo "   RESULTADO FINAL: {$testsPassed} PASSOU | {$testsFailed} FALHOU\n";
echo "========================================================\n";

exit($testsFailed > 0 ? 1 : 0);
