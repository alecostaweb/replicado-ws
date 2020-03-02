<?php

use Uspdev\Replicado_ws\Auth;

Flight::route('/pessoa', function () {
    global $help;
    Flight::jsonf($help);
});

/**
 * Dados básicos da Pessoa pelo número usp
 */
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

/**
 * Dados básicos da Pessoa pelo nome
 */
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

/**
 * Docentes ativos da unidade
 */
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

/**
 * Funcionários ativos na unidade
 */
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

/**
 * Estagiários ativos na unidade
 */
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
    
/**
 * E-mail principal de uma Pessoa
 * 
 * Uso no sistema de Reserva de Espaços da EESC
 */
$help['email'] = [
    'url' => DOMINIO . '/pessoa/email/{codpes}',
    'descricao' => 'recebe codpes e retorna o e-mail principal de uma Pessoa',
];
Flight::route('/pessoa/email/@codpes:[0-9]+', function ($codpes) {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Pessoa::email', $codpes);
    Flight::jsonf($res);
});

    