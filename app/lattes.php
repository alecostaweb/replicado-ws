<?php

use Uspdev\Replicado\Lattes;
use Uspdev\Replicado_ws\Auth;

Flight::route('/lattes', function () {
    global $help;
    Flight::jsonf($help);
});

$help['idLattes'] = [
    'url' => DOMINIO . '/lattes/idLattes/{codpes}',
    'descricao' => 'retorna o idLattes de uma pessoa (codpes)',
];
Flight::route('/lattes/idLattes/@codpes:[0-9]+', function ($codpes) {
    $res = Lattes::idLattes($codpes);
    Flight::json($res);
});