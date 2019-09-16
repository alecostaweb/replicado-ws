<?php
require_once __DIR__ . '/../config/config.php';

// endpoints a serem testados
$endpoints = [
    '/posgraduacao/ativos',
    '/posgraduacao/verifica/123456789',
];

// ---------------------------------------------------------

// mensagem de necessidade de autenticação
$message = '{
    "message": "Requires Authentication",
    "documentation_url": "' . DOMINIO . '/"
}';

foreach ($endpoints as $endpoint) {
    $res = file_get_contents(DOMINIO . $endpoint);
    if ($res == $message) {
        echo $endpoint . ' => OK' . PHP_EOL;
    } else {
        echo $endpoint . ' => falha' . PHP_EOL;
        echo 'Retornou: ' . $res . PHP_EOL;
    }
}
