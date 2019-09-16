<?php
require_once __DIR__ . '/../config/config.php';

// endpoints a serem testados
$endpoints = [
    '/nulo',
    '/posgraduacao/nulo',
    '/posgraduacao/nulo/nulo_de_novo',
    '/posgraduacao/orientadores/string_nao_serve',
    '/posgraduacao/verifica/string_nao_serve',
];

// ---------------------------------------------------------

// mensagem de comparacao
$message = '{
    "message": "Not Found",
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
