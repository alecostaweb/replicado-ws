<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// nao sei se os locales são necessários, copiado de outra aplicacao, mas de qualquer forma mal não faz
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// caminho raiz do projeto. Não precisa ser mudado
define('DIR', __DIR__ . '/..');

// isso é usado para informar na API os endpoints disponíveis
// sem barra no final
define("DOMINIO", "http://dominio/caminho"); 

// se for usar rotas locais tem de definir aqui
//define('ROTAS_LOCAIS', DIR . '/local/rotas/rota_local.php');


// vamos deixar generico para qualquer unidade poder usar
define('UNIDADE', 18);

// configuracoes para usar o uspdev/replicado
putenv('REPLICADO_HOST=192.168.100.89');
putenv('REPLICADO_PORT=1498');
putenv('REPLICADO_DATABASE=rep_dbc');
putenv('REPLICADO_USERNAME=dbmaint_read');
putenv('REPLICADO_PASSWORD=secret');
putenv('REPLICADO_PATHLOG=' . DIR . '/local/replicado.log'); // se não pusermos nada vai para default do replicado que é /tmp/log.log

// Usuários da API
// por enquanto ficamos aqui no config, depois podemos pensar em usar DB
$users = [
    'masaki' => md5('masaki'),
    'andre' => md5('andre'),
    'aplicacao' => md5('senha_da_aplicacao'),
];