<?php

use Uspdev\Replicado_ws\Auth;
use Uspdev\Replicado\Posgraduacao;

Flight::route('/posgraduacao', function () {
    global $help;

    Flight::jsonf($help);
});

$help['verifica']['url'] = DOMINIO . '/posgraduacao/verifica/{codpes}';
$help['verifica']['descricao'] = 'verifica se aluno (codpes) tem matrícula ativa na pós-graduação da unidade';
Flight::route('/posgraduacao/verifica/@codpes:[0-9]+', function ($codpes) {
    Auth::auth();
    Flight::json(Posgraduacao::verifica($codpes, UNIDADE));
});

$help['ativos']['url'] = DOMINIO . '/posgraduacao/ativos/';
$help['ativos']['descricao'] = 'retorna todos os alunos de pós-graduação ativos na unicade';
Flight::route('/posgraduacao/ativos', function () {
    Auth::auth();
    Flight::json(Posgraduacao::ativos(UNIDADE));
});

$help['programas']['url'] = DOMINIO . '/posgraduacao/programas/{codcur}';
$help['programas']['descricao'] = 'retorna todos os programas de pós-graduação da unidade ou quando informado o código do curso/programa retorna somente os dados do programa solicitado';
Flight::route('/posgraduacao/programas(/@codcur:[0-9]+)', function ($codcur) {
    Flight::json(Posgraduacao::programas(UNIDADE, $codcur));
});

// em uso no site da PG do SET, 9/2019
$help['orientadores'] = [
    'url' => DOMINIO . '/posgraduacao/orientadores/{codare}',
    'descricao' => 'retorna os orientadores credenciados na área de concentração (codare) do programa de pós graduação correspondente',
];
Flight::route('/posgraduacao/orientadores/@codare:[0-9]+', function ($codare) {
    Flight::json(Posgraduacao::orientadores($codare));
});

// em uso no site da PG do SET, 9/2019
$help['catalogodisciplinas'] = [
    'url' => DOMINIO . '/posgraduacao/catalogodisciplinas/{codare}(?l=completo)',
    'descricao' => 'retorna o catálogo das disciplinas pertencentes à área de concentração',
];
Flight::route('/posgraduacao/catalogodisciplinas/@codare:[0-9]+', function ($codare) {
    $l = Flight::request()->query['l'];
    if ($l == 'completo') {
        // como o replicado não tem essa consulta vamos usar uma classe própria para isso
        Flight::json(\Uspdev\Replicado_ws\Model\Posgraduacao::catalogoDisciplinas($codare));
    } else {
        Flight::json(Posgraduacao::catalogoDisciplinas($codare));
    }
});
