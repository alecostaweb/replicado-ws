<?php
require_once __DIR__ . '/config/config.php';

// endpoints a serem testados. Deve prgar automaticamente de outro lugar no futuro.
$endpoints = [
    '/posgraduacao',
    '/pessoa',
    '/bempatrimoniado',
    '/lattes'
];

echo 'Gerador ed documentação dos endpoints. Deve ser rodado toda vez que os endpoints são modificados!'.PHP_EOL;

$doc = '## Endpoints' . PHP_EOL . PHP_EOL;

$doc .= 'Este documento foi gerado automaticamente a partir da documentação de cada endpoint.\\' . PHP_EOL;
$doc .= 'Data da geração: '.date('d/m/Y h:i:s') . PHP_EOL;
$doc .= PHP_EOL;

foreach ($endpoints as $endpoint) {
    $res = file_get_contents(DOMINIO . $endpoint);
    $arr = json_decode($res, true);

    $doc .= '### ' . $endpoint . PHP_EOL . PHP_EOL;

    foreach ($arr as $key => $val) {
        foreach ($val as $k => $v) {
            if ($k == 'url') {
                // vamos limpar parte da URl que é repetido
                $doc .= '  * ' . str_replace(DOMINIO . $endpoint, '', $v) . PHP_EOL;
            } else {
                $doc .= '    * ' . $k . ': ' . $v . PHP_EOL;
            }
        }
    }
    $doc .= PHP_EOL;
}
file_put_contents(__DIR__ . '/doc/endpoints.md', $doc);
echo 'doc/endpoints.md gerado com sucesso.' . PHP_EOL;
