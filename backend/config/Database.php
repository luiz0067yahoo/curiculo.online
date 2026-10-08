<?php
/**
 * Conexão com o Banco de Dados MySQL (PDO)
 * Compatível com o padrão do backup (#bkp/0.3/server/connect.php)
 * Inclui fallback para persistência local JSON para garantir funcionamento imediato.
 */

class Database {
    private static ?PDO $instance = null;
    private static bool $fallbackMode = false;
    private static string $fallbackDir = __DIR__ . '/../data_storage';

    // Configurações do Banco MySQL (podem ser ajustadas via variáveis de ambiente ou aqui)
    private const DB_HOST = '127.0.0.1';
    private const DB_NAME = 'curriculo_online';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_PORT = '3306';

    public static function getConnection(): ?PDO {
        if (self::$fallbackMode) {
            return null;
        }

        if (self::$instance === null) {
            try {
                if (!extension_loaded('pdo_mysql')) {
                    self::$fallbackMode = true;
                    self::initFallbackStorage();
                    return null;
                }

                $host = getenv('DB_HOST') ?: self::DB_HOST;
                $db   = getenv('DB_NAME') ?: self::DB_NAME;
                $user = getenv('DB_USER') ?: self::DB_USER;
                $pass = getenv('DB_PASS') ?: self::DB_PASS;
                $port = getenv('DB_PORT') ?: self::DB_PORT;

                $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8mb4";
                }

                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (Throwable $e) {
                // Caso o MySQL não esteja em execução nesta máquina, ativa o modo de fallback transparente
                self::$fallbackMode = true;
                self::initFallbackStorage();
            }
        }

        return self::$instance;
    }

    public static function isFallback(): bool {
        if (self::$instance === null && !self::$fallbackMode) {
            self::getConnection();
        }
        return self::$fallbackMode;
    }

    public static function getFallbackStoragePath(string $entity): string {
        self::initFallbackStorage();
        return self::$fallbackDir . '/' . $entity . '.json';
    }

    private static function initFallbackStorage(): void {
        if (!is_dir(self::$fallbackDir)) {
            mkdir(self::$fallbackDir, 0777, true);
        }
    }
}
