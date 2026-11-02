<?php
/**
 * Suíte de Testes Automatizados - Curriculo.online
 * Executa todas as asserções de backend, banco de dados, autenticação e APIs
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

// 2. Teste do Modelo de Usuários (Cadastro, Login e Conta Google com Senha)
require_once __DIR__ . '/../backend/models/User.php';
$uniqueEmail = 'pesquisador.' . time() . '@gmail.com';
$googleUser = UserModel::googleAuth([
    'name' => 'Pesquisador Google',
    'email' => $uniqueEmail,
    'password' => 'senha123'
]);
assertTest("Criação de login e senha com conta Google", !empty($googleUser['id']) && $googleUser['email'] === $uniqueEmail && !empty($googleUser['token']));

$loggedIn = UserModel::login($uniqueEmail, 'senha123');
assertTest("Login por e-mail e senha da conta Google", $loggedIn['email'] === $uniqueEmail && !empty($loggedIn['token']));

$byToken = UserModel::findByToken($loggedIn['token']);
assertTest("Validação de sessão ativa por Bearer Token", !empty($byToken) && $byToken['email'] === $uniqueEmail);

// 3. Teste do Modelo de Etapas
require_once __DIR__ . '/../backend/models/Etapa.php';
$etapas = EtapaModel::getAll();
assertTest("Recuperação de etapas do currículo", is_array($etapas) && count($etapas) >= 10, "Total: " . count($etapas));

// 4. Teste de Modelo de Currículos Lattes
require_once __DIR__ . '/../backend/models/Modelo.php';
$modelos = ModeloModel::getAll();
assertTest("Recuperação dos modelos de currículo Lattes", is_array($modelos) && count($modelos) === 5, "Total: " . count($modelos));

// 5. Teste de Salvamento e Recuperação de Currículo vinculado ao Usuário
require_once __DIR__ . '/../backend/models/Curriculo.php';
$testPayload = [
    'user_id' => $googleUser['id'],
    'titulo' => 'Currículo Lattes Integrado',
    'nome_completo' => 'Pesquisador Google',
    'email' => $uniqueEmail,
    'modelo_slug' => 'lattes-tradicional',
    'cor_tema' => '#0f3a68',
    'dados' => [
        'dados_basicos' => ['nome' => 'Pesquisador Google', 'email' => $uniqueEmail],
        'formacao_academica' => [
            ['nivel' => 'Doutorado', 'curso' => 'Computação', 'instituicao' => 'USP', 'ano_conclusao' => '2024']
        ]
    ]
];
$saved = CurriculoModel::save($testPayload);
assertTest("Salvamento de currículo vinculado ao usuário", !empty($saved['uuid']) && $saved['email'] === $uniqueEmail);

$fetchedByUser = CurriculoModel::getByUser($googleUser['id'], $uniqueEmail);
assertTest("Recuperação de currículo por usuário autenticado", !empty($fetchedByUser) && $fetchedByUser['uuid'] === $saved['uuid']);

// 6. Teste de Reordenação de Etapas
$originalIds = array_map(fn($e) => $e['id'], $etapas);
$reversedIds = array_reverse($originalIds);
$reordered = EtapaModel::reorder($reversedIds);
assertTest("Reordenação de etapas no backend", $reordered[0]['id'] === end($originalIds));
EtapaModel::reorder($originalIds);

// Limpeza dos dados temporários de teste nos arquivos JSON fallback
foreach (['users', 'curriculos'] as $entity) {
    $file = Database::getFallbackStoragePath($entity);
    if (file_exists($file)) {
        $items = json_decode(file_get_contents($file), true) ?? [];
        $items = array_values(array_filter($items, fn($item) => ($item['email'] ?? '') !== $uniqueEmail));
        file_put_contents($file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

echo "\n========================================================\n";
echo "   RESULTADO FINAL: {$testsPassed} PASSOU | {$testsFailed} FALHOU\n";
echo "========================================================\n";

exit($testsFailed > 0 ? 1 : 0);
