<?php

use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado_ws\Auth;

Flight::route('/posgraduacao', function () {
    global $help;
    Flight::jsonf($help);
});

$help['verifica'] = [
    'url' => DOMINIO . '/posgraduacao/verifica/{codpes}',
    'descricao' => 'verifica se aluno (codpes) tem matrícula ativa na pós-graduação da unidade',
];
Flight::route('/posgraduacao/verifica/@codpes:[0-9]+', function ($codpes) {
    Auth::auth();
    $res = Posgraduacao::verifica($codpes, UNIDADE);
    Flight::json($res);
});

$help['ativos'] = [
    'url' => DOMINIO . '/posgraduacao/ativos/',
    'descricao' => 'retorna todos os alunos de pós-graduação ativos na unidade',
];
Flight::route('/posgraduacao/ativos', function () {
    global $c;
    Auth::auth();
    $res = $c->getCached('\Uspdev\Replicado\Posgraduacao::ativos', UNIDADE);
    Flight::json($res);
});

$help['programas'] = [
    'url' => DOMINIO . '/posgraduacao/programas/{codcur}',
    'descricao' => 'retorna todos os programas de pós-graduação da unidade ou quando informado o código do curso/programa retorna somente os dados do programa solicitado',
];
Flight::route('/posgraduacao/programas(/@codcur:[0-9]+)', function ($codcur) {
    global $c;
    $res = Posgraduacao::programas(UNIDADE, $codcur);
    Flight::json($res);
});

// em uso no site da PG do SET, 9/2019
$help['orientadores'] = [
    'url' => DOMINIO . '/posgraduacao/orientadores/{codare}',
    'descricao' => 'retorna os orientadores credenciados na área de concentração (codare) do programa de pós graduação correspondente',
];
Flight::route('/posgraduacao/orientadores/@codare:[0-9]+', function ($codare) {
    global $c;
    $res = $c->getCached('\Uspdev\Replicado\Posgraduacao::orientadores', $codare);
    Flight::json($res);
});

// em uso no site da PG do SET, 9/2019
$help['catalogodisciplinas'] = [
    'url' => DOMINIO . '/posgraduacao/catalogodisciplinas/{codare}(?l=completo)',
    'descricao' => 'retorna o catálogo das disciplinas pertencentes à área de concentração',
];
Flight::route('/posgraduacao/catalogodisciplinas/@codare:[0-9]+', function ($codare) {
    $l = Flight::request()->query['l'];
    global $c;
    if ($l == 'completo') {
        // como o replicado não tem essa consulta vamos usar uma classe própria para isso
        $res = $c->getCached('\Uspdev\Replicado_ws\Model\Posgraduacao::catalogoDisciplinas', $codare);
    } else {
        $res = $c->getCached('\Uspdev\Replicado\Posgraduacao::catalogoDisciplinas', $codare);
    }
    Flight::json($res);

});
