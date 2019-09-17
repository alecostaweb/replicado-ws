<?php

use Uspdev\Replicado_ws\Auth;

Flight::route('/pessoa', function () {
    global $help;
    Flight::jsonf($help);
});

$help['dump'] = [
    'url' => DOMINIO . '/pessoa/dump/{codpes}',
    'descricao' => 'recebe codpes e retorna todos campos da tabela Pessoa para o codpes em questão',
];
Flight::route('/pessoa/dump/@codpes:[0-9]+', function ($codpes) {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::dump', $codpes);
    Flight::jsonf($res);
});

$help['nome'] = [
    'url' => DOMINIO . '/pessoa/nome/?q={nome}',
    'descricao' => 'recebe uma string nome e retorna os resultados para a tabela Pessoa',
];
Flight::route('/pessoa/nome', function () {
    global $c;
    $request = Flight::request();

    // se q é vazio vamos passar para a próxima rota (geralmente vai ser 'not found')
    if (empty($request->query['q'])) {
        return true;
    }
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::nome', $request->query['q']);
    Flight::jsonf($res);
});

$help['docentes'] = [
    'url' => DOMINIO . '/pessoa/docentes',
    'descricao' => 'retorna todos os docentes ativos na unidade',
];
Flight::route('/pessoa/docentes', function () {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::docentes', UNIDADE);
    Flight::json($res);
});

$help['servidores'] = [
    'url' => DOMINIO . '/pessoa/servidores',
    'descricao' => 'retorna todos os funcionários ativos na unidade',
];
Flight::route('/pessoa/servidores', function () {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::servidores', UNIDADE);
    Flight::jsonf($res);
});

$help['estagiarios'] = [
    'url' => DOMINIO . '/pessoa/estagiarios',
    'descricao' => 'retorna todos os estagiários ativos na unidade',
];
Flight::route('/pessoa/estagiarios', function () {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::estagiarios', UNIDADE);
    Flight::jsonf($res);
});
