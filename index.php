<?php
/**
 * Ponto de Entrada Principal (Front Controller) - Curriculo.online
 * Roteia requisições entre a API do backend (/api) e a SPA do frontend (/frontend/dist)
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 1. Roteamento de API -> backend/index.php
if (strpos($uri, '/api') === 0) {
    require __DIR__ . '/backend/index.php';
    exit();
}

// 2. Servir arquivos estáticos do frontend/dist
$frontendDist = __DIR__ . '/frontend/dist';
$staticFilePath = $frontendDist . $uri;

if ($uri !== '/' && file_exists($staticFilePath) && !is_dir($staticFilePath)) {
    // Determinar Content-Type
    $ext = pathinfo($staticFilePath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'js'   => 'application/javascript',
        'css'  => 'text/css',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'woff2'=> 'font/woff2',
        'woff' => 'font/woff',
        'ttf'  => 'font/ttf'
    ];
    if (isset($mimeTypes[$ext])) {
        header("Content-Type: {$mimeTypes[$ext]}");
    }
    readfile($staticFilePath);
    exit();
}

// 3. Servir frontend/dist/index.html para qualquer outra rota SPA
if (file_exists($frontendDist . '/index.html')) {
    header("Content-Type: text/html; charset=UTF-8");
    readfile($frontendDist . '/index.html');
    exit();
}

// Caso o build não exista, informa instruções amigáveis
echo "<h1>Curriculo.online</h1>";
echo "<p>Backend online. Para compilar o frontend, execute: <code>cd frontend && npm run build</code></p>";
