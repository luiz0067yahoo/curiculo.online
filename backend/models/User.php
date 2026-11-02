<?php
require_once __DIR__ . '/../config/Database.php';

class UserModel {
    /**
     * Garante que a tabela users possui colunas auxiliares quando em modo MySQL
     */
    private static function ensureMysqlColumns(PDO $pdo): void {
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `username` BLOB NOT NULL,
                    `password` BLOB NOT NULL,
                    `e_mail` VARCHAR(255) DEFAULT NULL,
                    `e_mail_crypto` BLOB NOT NULL,
                    `google_id` VARCHAR(255) DEFAULT NULL,
                    `avatar` TEXT DEFAULT NULL,
                    `provider` VARCHAR(50) DEFAULT 'email',
                    `cell_phone` VARCHAR(20) DEFAULT NULL,
                    `telephone` VARCHAR(20) DEFAULT NULL,
                    `code` BLOB DEFAULT NULL,
                    `code_time` DATETIME DEFAULT NULL,
                    `attempts` INT(11) DEFAULT 0,
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `date_update` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        } catch (Throwable $e) {}
    }

    /**
     * Carrega todos os usuários do armazenamento fallback JSON
     */
    private static function getAllFallback(): array {
        $file = Database::getFallbackStoragePath('users');
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }

    /**
     * Salva lista de usuários no armazenamento fallback JSON
     */
    private static function saveAllFallback(array $users): void {
        $file = Database::getFallbackStoragePath('users');
        file_put_contents($file, json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Busca usuário por e-mail no MySQL ou no JSON fallback
     */
    public static function findByEmail(string $email): ?array {
        $normalizedEmail = strtolower(trim($email));
        if ($normalizedEmail === '') {
            return null;
        }

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                self::ensureMysqlColumns($pdo);
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE LOWER(`e_mail`) = :email LIMIT 1");
                $stmt->execute([':email' => $normalizedEmail]);
                $row = $stmt->fetch();
                if ($row) {
                    return [
                        'id' => (int)$row['id'],
                        'name' => $row['name'],
                        'email' => $row['e_mail'],
                        'password_hash' => (string)$row['password'],
                        'avatar' => $row['avatar'] ?? self::buildAvatar($row['name']),
                        'provider' => $row['provider'] ?? 'email',
                        'google_id' => $row['google_id'] ?? null,
                        'created_at' => $row['date_insert'] ?? date('Y-m-d H:i:s')
                    ];
                }
            } catch (Throwable $e) {}
        }

        $users = self::getAllFallback();
        foreach ($users as $u) {
            if (strtolower(trim($u['email'] ?? '')) === $normalizedEmail) {
                return $u;
            }
        }
        return null;
    }

    /**
     * Busca usuário por token de sessão
     */
    public static function findByToken(string $token): ?array {
        $token = trim($token);
        if ($token === '') {
            return null;
        }

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    SELECT u.* FROM `logs` l
                    INNER JOIN `users` u ON u.id = l.user_id
                    WHERE l.token = :token AND l.end_session IS NULL
                    ORDER BY l.id DESC LIMIT 1
                ");
                $stmt->execute([':token' => $token]);
                $row = $stmt->fetch();
                if ($row) {
                    return self::sanitizeUser([
                        'id' => (int)$row['id'],
                        'name' => $row['name'],
                        'email' => $row['e_mail'],
                        'password_hash' => (string)$row['password'],
                        'avatar' => $row['avatar'] ?? self::buildAvatar($row['name']),
                        'provider' => $row['provider'] ?? 'email',
                        'token' => $token
                    ]);
                }
            } catch (Throwable $e) {}
        }

        $users = self::getAllFallback();
        foreach ($users as $u) {
            if (($u['token'] ?? '') === $token) {
                return self::sanitizeUser($u);
            }
        }
        return null;
    }

    /**
     * Registra um novo usuário com login (e-mail) e senha
     */
    public static function register(array $payload): array {
        $name = trim($payload['name'] ?? ($payload['nome'] ?? ''));
        $email = strtolower(trim($payload['email'] ?? ''));
        $password = (string)($payload['password'] ?? ($payload['senha'] ?? ''));
        $provider = $payload['provider'] ?? 'email';
        $googleId = $payload['google_id'] ?? null;

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Informe um endereço de e-mail válido.');
        }
        if ($name === '') {
            $name = ucwords(str_replace(['.', '_', '-'], ' ', explode('@', $email)[0]));
        }
        if (strlen($password) < 4) {
            throw new InvalidArgumentException('A senha deve ter pelo menos 4 caracteres.');
        }

        $existing = self::findByEmail($email);
        if ($existing) {
            throw new InvalidArgumentException('Este e-mail já está cadastrado. Faça login com sua senha.');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $avatar = !empty($payload['avatar']) ? $payload['avatar'] : self::buildAvatar($name);
        $token = bin2hex(random_bytes(24));
        $now = date('Y-m-d H:i:s');

        $newId = null;
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                self::ensureMysqlColumns($pdo);
                $stmt = $pdo->prepare("
                    INSERT INTO `users` (`name`, `username`, `password`, `e_mail`, `e_mail_crypto`, `google_id`, `avatar`, `provider`, `date_insert`, `date_update`)
                    VALUES (:name, :username, :password, :email, :email_crypto, :google_id, :avatar, :provider, :now, :now)
                ");
                $stmt->execute([
                    ':name' => $name,
                    ':username' => $email,
                    ':password' => $passwordHash,
                    ':email' => $email,
                    ':email_crypto' => hash('sha256', $email),
                    ':google_id' => $googleId,
                    ':avatar' => $avatar,
                    ':provider' => $provider,
                    ':now' => $now
                ]);
                $newId = (int)$pdo->lastInsertId();
                self::recordMysqlSession($pdo, $newId, $email, $token);
            } catch (Throwable $e) {}
        }

        $users = self::getAllFallback();
        if (!$newId) {
            $maxId = 0;
            foreach ($users as $u) {
                if (($u['id'] ?? 0) > $maxId) {
                    $maxId = (int)$u['id'];
                }
            }
            $newId = $maxId + 1;
        }

        $record = [
            'id' => $newId,
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'avatar' => $avatar,
            'provider' => $provider,
            'google_id' => $googleId,
            'token' => $token,
            'created_at' => $now,
            'updated_at' => $now
        ];

        $users[] = $record;
        self::saveAllFallback($users);

        return self::sanitizeUser($record);
    }

    /**
     * Autentica um usuário existente por e-mail e senha
     */
    public static function login(string $email, string $password): array {
        $normalizedEmail = strtolower(trim($email));
        if ($normalizedEmail === '' || $password === '') {
            throw new InvalidArgumentException('Preencha o e-mail e a senha para entrar.');
        }

        $user = self::findByEmail($normalizedEmail);
        if (!$user) {
            throw new InvalidArgumentException('Conta não encontrada para este e-mail. Crie sua conta primeiro.');
        }

        $storedHash = $user['password_hash'] ?? '';
        if ($storedHash === '' || !password_verify($password, $storedHash)) {
            throw new InvalidArgumentException('E-mail ou senha incorretos.');
        }

        $token = bin2hex(random_bytes(24));
        $user['token'] = $token;
        $user['updated_at'] = date('Y-m-d H:i:s');

        $pdo = Database::getConnection();
        if ($pdo && !empty($user['id'])) {
            self::recordMysqlSession($pdo, (int)$user['id'], $normalizedEmail, $token);
        }

        // Atualizar token no fallback JSON
        $users = self::getAllFallback();
        $found = false;
        foreach ($users as &$u) {
            if (strtolower(trim($u['email'] ?? '')) === $normalizedEmail) {
                $u['token'] = $token;
                $u['updated_at'] = $user['updated_at'];
                $found = true;
                break;
            }
        }
        if (!$found) {
            $users[] = $user;
        }
        self::saveAllFallback($users);

        return self::sanitizeUser($user);
    }

    /**
     * Autentica ou cria conta via Google (com suporte a criação/validação de login e senha ou token Google JWT)
     */
    public static function googleAuth(array $payload): array {
        // Caso receba um JWT credential oficial do Google Identity Services, decodifica o payload
        if (!empty($payload['credential'])) {
            $jwtParts = explode('.', $payload['credential']);
            if (count($jwtParts) === 3) {
                $decoded = json_decode(base64_decode(strtr($jwtParts[1], '-_', '+/')), true);
                if (is_array($decoded) && !empty($decoded['email'])) {
                    $payload['email'] = $decoded['email'];
                    $payload['name'] = $decoded['name'] ?? ($payload['name'] ?? '');
                    $payload['avatar'] = $decoded['picture'] ?? ($payload['avatar'] ?? '');
                    $payload['google_id'] = $decoded['sub'] ?? null;
                }
            }
        }

        $email = strtolower(trim($payload['email'] ?? ''));
        $name = trim($payload['name'] ?? ($payload['nome'] ?? ''));
        $password = (string)($payload['password'] ?? ($payload['senha'] ?? ''));
        $googleId = $payload['google_id'] ?? ('google_' . md5($email));

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Informe um e-mail Google válido.');
        }
        if ($name === '') {
            $name = ucwords(str_replace(['.', '_', '-'], ' ', explode('@', $email)[0]));
        }

        $existing = self::findByEmail($email);
        $token = bin2hex(random_bytes(24));
        $now = date('Y-m-d H:i:s');

        if ($existing) {
            // Se o usuário forneceu uma senha:
            // - Se já havia senha cadastrada, verifica se confere (ou se está redefinindo via Google Auth)
            if ($password !== '') {
                if (strlen($password) < 4) {
                    throw new InvalidArgumentException('A senha deve ter pelo menos 4 caracteres.');
                }
                if (!empty($existing['password_hash']) && empty($payload['credential'])) {
                    if (!password_verify($password, $existing['password_hash'])) {
                        throw new InvalidArgumentException('Senha incorreta para esta conta Google.');
                    }
                } else {
                    $existing['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                }
            } elseif (!empty($existing['password_hash']) && empty($payload['credential'])) {
                throw new InvalidArgumentException('Esta conta Google possui senha cadastrada. Informe sua senha para entrar.');
            }

            if ($name !== '') {
                $existing['name'] = $name;
            }
            if (!empty($payload['avatar'])) {
                $existing['avatar'] = $payload['avatar'];
            }
            $existing['provider'] = 'google';
            $existing['google_id'] = $googleId;
            $existing['token'] = $token;
            $existing['updated_at'] = $now;

            $pdo = Database::getConnection();
            if ($pdo && !empty($existing['id'])) {
                try {
                    self::ensureMysqlColumns($pdo);
                    $stmt = $pdo->prepare("
                        UPDATE `users`
                        SET `name` = :name, `password` = :password, `google_id` = :google_id, `avatar` = :avatar, `provider` = 'google', `date_update` = :now
                        WHERE `id` = :id
                    ");
                    $stmt->execute([
                        ':name' => $existing['name'],
                        ':password' => $existing['password_hash'] ?? '',
                        ':google_id' => $googleId,
                        ':avatar' => $existing['avatar'],
                        ':now' => $now,
                        ':id' => $existing['id']
                    ]);
                    self::recordMysqlSession($pdo, (int)$existing['id'], $email, $token);
                } catch (Throwable $e) {}
            }

            $users = self::getAllFallback();
            $updated = false;
            foreach ($users as &$u) {
                if (strtolower(trim($u['email'] ?? '')) === $email) {
                    $u = array_merge($u, $existing);
                    $updated = true;
                    break;
                }
            }
            if (!$updated) {
                $users[] = $existing;
            }
            self::saveAllFallback($users);

            return self::sanitizeUser($existing);
        }

        // Nova conta via Google: exige senha (exceto se vier de token JWT OAuth assinado)
        if ($password === '' && empty($payload['credential'])) {
            throw new InvalidArgumentException('Defina uma senha (mínimo 4 caracteres) para criar sua conta com o Google.');
        }
        if ($password !== '' && strlen($password) < 4) {
            throw new InvalidArgumentException('A senha deve ter pelo menos 4 caracteres.');
        }

        $finalPassword = $password !== '' ? $password : bin2hex(random_bytes(8));
        return self::register([
            'name' => $name,
            'email' => $email,
            'password' => $finalPassword,
            'avatar' => $payload['avatar'] ?? self::buildAvatar($name),
            'provider' => 'google',
            'google_id' => $googleId
        ]);
    }

    /**
     * Encerra a sessão ativa correspondente ao token
     */
    public static function logout(string $token): bool {
        $token = trim($token);
        if ($token === '') {
            return true;
        }

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE `logs` SET `end_session` = :now WHERE `token` = :token");
                $stmt->execute([
                    ':now' => date('Y-m-d H:i:s'),
                    ':token' => $token
                ]);
            } catch (Throwable $e) {}
        }

        $users = self::getAllFallback();
        $changed = false;
        foreach ($users as &$u) {
            if (($u['token'] ?? '') === $token) {
                $u['token'] = null;
                $changed = true;
            }
        }
        if ($changed) {
            self::saveAllFallback($users);
        }
        return true;
    }

    private static function recordMysqlSession(PDO $pdo, int $userId, string $email, string $token): void {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO `logs` (`user_id`, `token`, `username`, `start_session`, `ip_address`)
                VALUES (:user_id, :token, :username, :start_session, :ip)
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':token' => $token,
                ':username' => $email,
                ':start_session' => date('Y-m-d H:i:s'),
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ]);
        } catch (Throwable $e) {}
    }

    private static function buildAvatar(string $name): string {
        return 'https://ui-avatars.com/api/?name=' . urlencode($name ?: 'U') . '&background=0f3a68&color=fff';
    }

    public static function sanitizeUser(array $user): array {
        return [
            'id' => $user['id'] ?? null,
            'name' => $user['name'] ?? '',
            'email' => $user['email'] ?? '',
            'avatar' => $user['avatar'] ?? self::buildAvatar($user['name'] ?? ''),
            'provider' => $user['provider'] ?? 'email',
            'token' => $user['token'] ?? null,
            'has_password' => !empty($user['password_hash'])
        ];
    }
}

