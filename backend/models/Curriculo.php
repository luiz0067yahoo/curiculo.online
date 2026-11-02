<?php
require_once __DIR__ . '/../config/Database.php';

class CurriculoModel {
    public static function getAll(): array {
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT id, uuid, user_id, titulo, nome_completo, email, modelo_slug, cor_tema, dados_json, criado_em, atualizado_em FROM curriculos ORDER BY atualizado_em DESC");
                $rows = $stmt->fetchAll();
                foreach ($rows as &$r) {
                    if (!empty($r['dados_json']) && empty($r['dados'])) {
                        $r['dados'] = json_decode($r['dados_json'], true);
                    }
                }
                return $rows;
            } catch (Exception $e) {}
        }

        $file = Database::getFallbackStoragePath('curriculos');
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) return $data;
        }

        return [];
    }

    public static function getByUuid(string $uuid): ?array {
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM curriculos WHERE uuid = :uuid LIMIT 1");
                $stmt->execute([':uuid' => $uuid]);
                $row = $stmt->fetch();
                if ($row) {
                    $row['dados'] = json_decode($row['dados_json'], true);
                    return $row;
                }
            } catch (Exception $e) {}
        }

        $all = self::getAll();
        foreach ($all as $item) {
            if (($item['uuid'] ?? '') === $uuid) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Recupera o currículo vinculado ao usuário autenticado (por user_id ou email)
     */
    public static function getByUser(?int $userId, ?string $email): ?array {
        $normalizedEmail = strtolower(trim((string)$email));

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                if ($userId) {
                    $stmt = $pdo->prepare("SELECT * FROM curriculos WHERE user_id = :uid ORDER BY atualizado_em DESC LIMIT 1");
                    $stmt->execute([':uid' => $userId]);
                    $row = $stmt->fetch();
                    if ($row) {
                        $row['dados'] = json_decode($row['dados_json'], true);
                        return $row;
                    }
                }
                if ($normalizedEmail !== '') {
                    $stmt = $pdo->prepare("SELECT * FROM curriculos WHERE LOWER(email) = :email ORDER BY atualizado_em DESC LIMIT 1");
                    $stmt->execute([':email' => $normalizedEmail]);
                    $row = $stmt->fetch();
                    if ($row) {
                        $row['dados'] = json_decode($row['dados_json'], true);
                        return $row;
                    }
                }
            } catch (Exception $e) {}
        }

        $all = self::getAll();
        foreach (array_reverse($all) as $item) {
            if ($userId && isset($item['user_id']) && (int)$item['user_id'] === $userId) {
                return $item;
            }
            if ($normalizedEmail !== '' && strtolower(trim($item['email'] ?? '')) === $normalizedEmail) {
                return $item;
            }
        }
        return null;
    }

    public static function save(array $payload): array {
        $userId = !empty($payload['user_id']) ? (int)$payload['user_id'] : null;
        $email = strtolower(trim($payload['email'] ?? ($payload['dados']['dados_basicos']['email'] ?? '')));

        // Se não enviou uuid mas já existe currículo deste usuário, reutiliza o uuid existente
        $uuid = !empty($payload['uuid']) ? $payload['uuid'] : '';
        if ($uuid === '' && ($userId || $email !== '')) {
            $existingUserCv = self::getByUser($userId, $email);
            if ($existingUserCv && !empty($existingUserCv['uuid'])) {
                $uuid = $existingUserCv['uuid'];
            }
        }
        if ($uuid === '') {
            $uuid = bin2hex(random_bytes(16));
        }

        $titulo = $payload['titulo'] ?? 'Meu Currículo Lattes';
        $nome = $payload['nome_completo'] ?? ($payload['dados']['dados_basicos']['nome'] ?? 'Sem Nome');
        $modelo = $payload['modelo_slug'] ?? 'lattes-tradicional';
        $cor = $payload['cor_tema'] ?? '#0f3a68';
        $dadosJson = json_encode($payload['dados'] ?? [], JSON_UNESCAPED_UNICODE);
        $agora = date('Y-m-d H:i:s');

        $record = [
            'uuid' => $uuid,
            'user_id' => $userId,
            'titulo' => $titulo,
            'nome_completo' => $nome,
            'email' => $email,
            'modelo_slug' => $modelo,
            'cor_tema' => $cor,
            'dados_json' => $dadosJson,
            'dados' => $payload['dados'] ?? [],
            'criado_em' => $payload['criado_em'] ?? $agora,
            'atualizado_em' => $agora
        ];

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO curriculos (uuid, user_id, titulo, nome_completo, email, modelo_slug, cor_tema, dados_json, criado_em, atualizado_em)
                    VALUES (:uuid, :user_id, :titulo, :nome_completo, :email, :modelo_slug, :cor_tema, :dados_json, :criado_em, :atualizado_em)
                    ON DUPLICATE KEY UPDATE 
                    user_id=:user_id, titulo=:titulo, nome_completo=:nome_completo, email=:email, modelo_slug=:modelo_slug, cor_tema=:cor_tema, dados_json=:dados_json, atualizado_em=:atualizado_em");
                $stmt->execute([
                    ':uuid' => $uuid,
                    ':user_id' => $userId,
                    ':titulo' => $titulo,
                    ':nome_completo' => $nome,
                    ':email' => $email,
                    ':modelo_slug' => $modelo,
                    ':cor_tema' => $cor,
                    ':dados_json' => $dadosJson,
                    ':criado_em' => $record['criado_em'],
                    ':atualizado_em' => $agora
                ]);
            } catch (Exception $e) {}
        }

        // Salvar também no fallback
        $file = Database::getFallbackStoragePath('curriculos');
        $all = self::getAll();
        $found = false;
        foreach ($all as &$item) {
            if (($item['uuid'] ?? '') === $uuid) {
                $item = $record;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $all[] = $record;
        }
        file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $record;
    }
}
