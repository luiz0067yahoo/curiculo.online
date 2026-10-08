<?php
require_once __DIR__ . '/../config/Database.php';

class CurriculoModel {
    public static function getAll(): array {
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT id, uuid, titulo, nome_completo, email, modelo_slug, cor_tema, criado_em, atualizado_em FROM curriculos ORDER BY atualizado_em DESC");
                return $stmt->fetchAll();
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

    public static function save(array $payload): array {
        $uuid = !empty($payload['uuid']) ? $payload['uuid'] : bin2hex(random_bytes(16));
        $titulo = $payload['titulo'] ?? 'Meu Currículo Lattes';
        $nome = $payload['nome_completo'] ?? ($payload['dados']['dados_basicos']['nome'] ?? 'Sem Nome');
        $email = $payload['email'] ?? ($payload['dados']['dados_basicos']['email'] ?? '');
        $modelo = $payload['modelo_slug'] ?? 'lattes-tradicional';
        $cor = $payload['cor_tema'] ?? '#0f3a68';
        $dadosJson = json_encode($payload['dados'] ?? [], JSON_UNESCAPED_UNICODE);
        $agora = date('Y-m-d H:i:s');

        $record = [
            'uuid' => $uuid,
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
                $stmt = $pdo->prepare("INSERT INTO curriculos (uuid, titulo, nome_completo, email, modelo_slug, cor_tema, dados_json, criado_em, atualizado_em)
                    VALUES (:uuid, :titulo, :nome_completo, :email, :modelo_slug, :cor_tema, :dados_json, :criado_em, :atualizado_em)
                    ON DUPLICATE KEY UPDATE 
                    titulo=:titulo, nome_completo=:nome_completo, email=:email, modelo_slug=:modelo_slug, cor_tema=:cor_tema, dados_json=:dados_json, atualizado_em=:atualizado_em");
                $stmt->execute([
                    ':uuid' => $uuid,
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
