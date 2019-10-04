<?php

use Uspdev\Replicado\Bempatrimoniado;
use Uspdev\Replicado_ws\Auth;

Flight::route('/bempatrimoniado', function () {
    global $help;
    Flight::jsonf($help);
});

$help['dump'] = [
    'url' => DOMINIO . '/bempatrimoniado/dump/{numpat}',
    'descricao' => 'retorna todos campos da tabela bempatrimoniado',
];
Flight::route('/bempatrimoniado/dump/@numpat:[0-9]+', function ($numpat) {
    //Auth::auth();
    $res = Bempatrimoniado::dump($numpat);
    Flight::json($res);
});