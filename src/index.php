<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$checks = [
    'postgresql' => static function (): void {
        $pdo = new PDO(
            sprintf(
                'pgsql:host=%s;port=%s;dbname=%s;connect_timeout=3',
                getenv('POSTGRES_HOST'),
                getenv('POSTGRES_PORT'),
                getenv('POSTGRES_DB'),
            ),
            getenv('POSTGRES_USER'),
            getenv('POSTGRES_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
        $pdo->query('SELECT 1');
    },
    'mysql' => static function (): void {
        $pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                getenv('MYSQL_HOST'),
                getenv('MYSQL_PORT'),
                getenv('MYSQL_DATABASE'),
            ),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_TIMEOUT => 3],
        );
        $pdo->query('SELECT 1');
    },
    'redis' => static function (): void {
        $redis = new Redis();
        $redis->connect((string) getenv('REDIS_HOST'), (int) getenv('REDIS_PORT'), 3.0);
        $redis->setOption(Redis::OPT_READ_TIMEOUT, 3.0);
        if (!$redis->auth((string) getenv('REDIS_PASSWORD')) || $redis->ping() === false) {
            throw new RuntimeException('Redis check failed');
        }
        $redis->close();
    },
];

$result = ['php' => PHP_VERSION, 'services' => []];
foreach ($checks as $name => $check) {
    try {
        $check();
        $result['services'][$name] = 'ok';
    } catch (Throwable $exception) {
        http_response_code(503);
        $result['services'][$name] = 'unavailable';
        error_log(sprintf('%s connection check failed (%s)', $name, $exception::class));
    }
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), PHP_EOL;
