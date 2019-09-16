<?php

use Uspdev\Replicado_ws\Auth;
use Uspdev\Replicado\Pessoa;

Flight::route('/pessoa', function () {
    global $help;
    Flight::jsonf($help);
});

$help['dump']['url'] = DOMINIO . '/pessoa/dump/{codpes}';
$help['dump']['description'] = 'recebe codpes e retorna todos campos da tabela Pessoa para o codpes em questão';
Flight::route('/pessoa/dump/@codpes:[0-9]+', function ($codpes) {
    Auth::auth();
    Flight::jsonf(Pessoa::dump($codpes));
});

$help['nome']['url'] = DOMINIO . '/pessoa/nome/?q={nome}';
$help['nome']['description'] = 'recebe uma string nome e retorna os resultados para a tabela Pessoa';
Flight::route('/pessoa/nome', function () {
    $request = Flight::request();
    // se q é vazio vamos passar para a próxima rota (geralmente vai ser 'not found')
    if (empty($request->query['q'])) {
        return true;
    }
    Auth::auth();
    Flight::jsonf(Pessoa::nome($request->query['q']));
});

$help['docentes']['url'] = DOMINIO . '/pessoa/docentes';
$help['docentes']['description'] = 'retorna array de todos os docentes ativos na unidade';
Flight::route('/pessoa/docentes', function () {
    Auth::auth();
    Flight::jsonf(Pessoa::docentes(UNIDADE));
});

$help['servidores']['url'] = DOMINIO . '/pessoa/servidores';
$help['servidores']['description'] = 'retorna array de todos os funcionários ativos na unidade';
Flight::route('/pessoa/servidores', function () {
    Auth::auth();
    Flight::jsonf(Pessoa::servidores(UNIDADE));
});

$help['estagiarios']['url'] = DOMINIO . '/pessoa/estagiarios';
$help['estagiarios']['description'] = 'retorna array de todos os estagiários ativos na unidade';
Flight::route('/pessoa/estagiarios', function () {
    Auth::auth();
    Flight::jsonf(Pessoa::estagiarios(UNIDADE));
});
