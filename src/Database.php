<?php
declare(strict_types=1);
if (!defined('BLOG_APP')) { http_response_code(403); exit; }
final class Database
{
    public static function connect(): PDO
    {
        $path = dirname(__DIR__) . '/db.local.php';
        if (!is_file($path)) {
            throw new RuntimeException('Не настроено подключение к базе данных');
        }
        $config = require $path;
        if (($config['driver'] ?? 'mysql') === 'sqlite') {
            $dsn = 'sqlite:' . $config['path'];
            return new PDO($dsn, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        }
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'] . ';charset=utf8mb4';
        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
