<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Etapa.php';
require_once __DIR__ . '/models/Modelo.php';
require_once __DIR__ . '/models/Curriculo.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true) ?? [];

// Extrair Bearer Token se enviado no header Authorization
function getBearerToken(): string {
    $headers = function_exists('getallheaders') ? getallheaders() : [];
    $auth = $headers['Authorization'] ?? ($headers['authorization'] ?? ($_SERVER['HTTP_AUTHORIZATION'] ?? ''));
    if (preg_match('/Bearer\s+(.+)$/i', $auth, $m)) {
        return trim($m[1]);
    }
    return trim($_GET['token'] ?? ($GLOBALS['body']['token'] ?? ''));
}

// Helper para resposta JSON
function jsonResponse($data, int $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

// Roteamento
try {
    // 1. Status / Health Check
    if (preg_match('#^/api/?$#', $uri) || preg_match('#^/api/status/?$#', $uri)) {
        jsonResponse([
            'status' => 'online',
            'app' => 'Curriculo Online Lattes API',
            'version' => '2.1.0',
            'database_connected' => !Database::isFallback(),
            'storage_mode' => Database::isFallback() ? 'local_resilient_json' : 'mysql_pdo'
        ]);
    }

    // 1.1 AUTENTICAÇÃO (Cadastro, Login com E-mail/Senha e Login/Cadastro com Conta Google)
    if (preg_match('#^/api/auth/register/?$#', $uri) && $method === 'POST') {
        try {
            $user = UserModel::register($body);
            $curriculo = CurriculoModel::getByUser($user['id'] ?? null, $user['email'] ?? null);
            jsonResponse([
                'success' => true,
                'user' => $user,
                'curriculo' => $curriculo
            ], 201);
        } catch (InvalidArgumentException $e) {
            jsonResponse(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    if (preg_match('#^/api/auth/login/?$#', $uri) && $method === 'POST') {
        try {
            $email = $body['email'] ?? '';
            $password = $body['password'] ?? ($body['senha'] ?? '');
            $user = UserModel::login($email, $password);
            $curriculo = CurriculoModel::getByUser($user['id'] ?? null, $user['email'] ?? null);
            jsonResponse([
                'success' => true,
                'user' => $user,
                'curriculo' => $curriculo
            ]);
        } catch (InvalidArgumentException $e) {
            jsonResponse(['success' => false, 'error' => $e->getMessage()], 401);
        }
    }

    if (preg_match('#^/api/auth/google/?$#', $uri) && $method === 'POST') {
        try {
            $user = UserModel::googleAuth($body);
            $curriculo = CurriculoModel::getByUser($user['id'] ?? null, $user['email'] ?? null);
            jsonResponse([
                'success' => true,
                'user' => $user,
                'curriculo' => $curriculo
            ]);
        } catch (InvalidArgumentException $e) {
            jsonResponse(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    if (preg_match('#^/api/auth/me/?$#', $uri) && $method === 'GET') {
        $token = getBearerToken();
        $user = UserModel::findByToken($token);
        if (!$user) {
            jsonResponse(['success' => false, 'error' => 'Sessão inválida ou expirada.'], 401);
        }
        $curriculo = CurriculoModel::getByUser($user['id'] ?? null, $user['email'] ?? null);
        jsonResponse([
            'success' => true,
            'user' => $user,
            'curriculo' => $curriculo
        ]);
    }

    if (preg_match('#^/api/auth/logout/?$#', $uri) && $method === 'POST') {
        $token = getBearerToken();
        UserModel::logout($token);
        jsonResponse(['success' => true, 'message' => 'Sessão encerrada com sucesso.']);
    }

    // 2. ETAPAS
    if (preg_match('#^/api/etapas/reorder/?$#', $uri) && $method === 'POST') {
        $orderedIds = $body['ordered_ids'] ?? [];
        $res = EtapaModel::reorder($orderedIds);
        jsonResponse(['success' => true, 'data' => $res]);
    }

    if (preg_match('#^/api/etapas/?$#', $uri)) {
        if ($method === 'GET') {
            $etapas = EtapaModel::getAll();
            jsonResponse(['success' => true, 'data' => $etapas]);
        } elseif ($method === 'POST') {
            $created = EtapaModel::save($body);
            jsonResponse(['success' => true, 'data' => $created], 201);
        }
    }

    if (preg_match('#^/api/etapas/(\d+)/?$#', $uri, $matches)) {
        $id = (int)$matches[1];
        if ($method === 'PUT' || $method === 'POST') {
            $body['id'] = $id;
            $updated = EtapaModel::save($body);
            jsonResponse(['success' => true, 'data' => $updated]);
        } elseif ($method === 'DELETE') {
            EtapaModel::delete($id);
            jsonResponse(['success' => true, 'message' => "Etapa {$id} removida com sucesso"]);
        }
    }

    // 3. MODELOS
    if (preg_match('#^/api/modelos/?$#', $uri)) {
        if ($method === 'GET') {
            $modelos = ModeloModel::getAll();
            jsonResponse(['success' => true, 'data' => $modelos]);
        }
    }

    // 4. CURRICULOS
    if (preg_match('#^/api/curriculos/?$#', $uri)) {
        $token = getBearerToken();
        $authUser = $token ? UserModel::findByToken($token) : null;

        if ($method === 'GET') {
            $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : ($authUser['id'] ?? null);
            $email = $_GET['email'] ?? ($authUser['email'] ?? null);
            if ($userId || $email) {
                $curriculo = CurriculoModel::getByUser($userId, $email);
                jsonResponse(['success' => true, 'data' => $curriculo]);
            }
            $curriculos = CurriculoModel::getAll();
            jsonResponse(['success' => true, 'data' => $curriculos]);
        } elseif ($method === 'POST') {
            if ($authUser) {
                if (empty($body['user_id'])) {
                    $body['user_id'] = $authUser['id'];
                }
                if (empty($body['email'])) {
                    $body['email'] = $authUser['email'];
                }
            }
            $saved = CurriculoModel::save($body);
            jsonResponse(['success' => true, 'data' => $saved]);
        }
    }

    if (preg_match('#^/api/curriculos/([a-zA-Z0-9_\-]+)/?$#', $uri, $matches)) {
        $uuid = $matches[1];
        if ($method === 'GET') {
            $curriculo = CurriculoModel::getByUuid($uuid);
            if ($curriculo) {
                jsonResponse(['success' => true, 'data' => $curriculo]);
            } else {
                jsonResponse(['success' => false, 'error' => 'Currículo não encontrado'], 404);
            }
        }
    }

    // 5. GERADOR INTELIGENTE DE RESUMO LATTES (CNPq Style)
    if (preg_match('#^/api/gerar-lattes-resumo/?$#', $uri) && $method === 'POST') {
        $dados = $body['dados'] ?? [];
        $formacoes = $dados['formacao_academica'] ?? [];
        $areas = $dados['linhas_pesquisa'] ?? [];
        $atuacoes = $dados['atuacao_profissional'] ?? [];
        $nome = $dados['dados_basicos']['nome'] ?? 'O pesquisador';

        if (is_array($formacoes) && isset($formacoes['curso'])) {
            $formacoes = [$formacoes];
        }
        if (is_array($atuacoes) && isset($atuacoes['empresa'])) {
            $atuacoes = [$atuacoes];
        }

        $partes = [];
        $titulacaoEncontrada = false;
        if (is_array($formacoes)) {
            foreach ($formacoes as $f) {
                if (!is_array($f)) continue;
                $curso = $f['curso'] ?? '';
                $inst = $f['instituicao'] ?? '';
                $lbl = $f['nivel_label'] ?? ($f['nivel'] ?? 'formação');
                $ano = $f['ano_conclusao'] ?? ($f['ano_inicio'] ?? '');
                if ($curso) {
                    $partes[] = "Possui {$lbl} em {$curso}" . ($inst ? " pela {$inst}" : "") . ($ano ? " ({$ano})" : "") . ".";
                    $titulacaoEncontrada = true;
                    break;
                }
            }
        }
        if (!$titulacaoEncontrada) {
            $partes[] = "Pesquisador com sólida trajetória acadêmica e profissional.";
        }

        // Atuação atual
        if (is_array($atuacoes) && !empty($atuacoes[0])) {
            $at = $atuacoes[0];
            $cargo = $at['cargo'] ?? 'pesquisador(a)';
            $empresa = $at['empresa'] ?? '';
            if ($empresa) {
                $partes[] = "Atualmente atua como {$cargo} na instituição {$empresa}.";
            }
        }

        // Áreas de pesquisa
        if (is_array($areas) && !empty($areas)) {
            $listaAreas = [];
            foreach ($areas as $a) {
                if (is_array($a)) {
                    $listaAreas[] = $a['nome'] ?? ($a['area'] ?? '');
                } else if (is_string($a)) {
                    $listaAreas[] = $a;
                }
            }
            $listaAreas = array_filter(array_unique($listaAreas));
            if (!empty($listaAreas)) {
                $partes[] = "Tem experiência com ênfase em " . implode(', ', $listaAreas) . ", desenvolvendo pesquisas e projetos de inovação.";
            }
        }

        $resumoFinal = implode(' ', $partes);
        jsonResponse(['success' => true, 'resumo' => $resumoFinal]);
    }

    // Rota 404
    jsonResponse(['success' => false, 'error' => 'Endpoint não encontrado', 'uri' => $uri], 404);

} catch (Throwable $e) {
    jsonResponse(['success' => false, 'error' => $e->getMessage()], 500);
}
