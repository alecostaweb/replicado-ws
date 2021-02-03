<?php

// vamos ajustar os caminhos baseados no arquivo de configuracao
// dessa forma não precisamos recorrer ao RewriteBase do apache
// e podemos usar um .htaccess que não depende do deploy
Flight::request()->base = parse_url(DOMINIO, PHP_URL_PATH);
Flight::request()->url = str_replace(Flight::request()->base, '', Flight::request()->url);

function recursive_unset(&$array, $unwanted_key)
{
    unset($array[$unwanted_key]);
    foreach ($array as &$value) {
        if (is_array($value)) {
            recursive_unset($value, $unwanted_key);
        }
    }
}

// vamos imprimir saída no formato texto
Flight::map('text', function (array $array_rows) {
    foreach ($array_rows as $k => $v) {
        echo $k . ',' . $v . PHP_EOL;
    }
    return true;
});

// vamos imprimir o json formatado para humanos lerem
Flight::map('jsonf', function ($data) {
    if (is_array($data)) {
        recursive_unset($data, 'timestamp');
    }
    Flight::json($data, 200, true, 'utf-8', JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
});

// quando o endpoint é protegido e não houver dados de autenticação
// vamos mostrar uma mensagem indicando como enviar as credenciais
Flight::map('requireAuth', function () {
    $data['message'] = 'Requires Authentication';
    $data['documentation_url'] = DOMINIO . '/';
    Flight::jsonf($data);
});

// vamos sobrescrever a mensagem de not found para ficar mais compatível com a API
// retorna 404 mas com mensagem personalizada opcional ou mensagem padrão
Flight::map('notFound', function ($msg = null) {
    $data['message'] = empty($msg) ? 'Not Found' : $msg;
    $data['documentation_url'] = DOMINIO . '/';
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    Flight::halt(404, $json);
});

// Interrompe a execução com 403 - Forbidden
// usado quando negado acesso por IP
Flight::map('forbidden', function ($msg = null) {
    $data['message'] = empty($msg) ? 'Forbidden' : $msg;
    $data['documentation_url'] = DOMINIO . '/';
    $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    Flight::halt(403, $json);
});
