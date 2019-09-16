<?php

namespace Uspdev\Replicado_ws;

class Auth
{
    public static function auth()
    {
        global $users;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: authorization');

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            \Flight::requireAuth();
            exit;
        }

        if (!isset($users[$_SERVER['PHP_AUTH_USER']]) or $users[$_SERVER['PHP_AUTH_USER']] != md5($_SERVER['PHP_AUTH_PW'])) {
            \Flight::requireAuth();
            exit;
        }
    }

    public static function login()
    {
        global $users;

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: authorization');

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            echo 'OK';
            exit;
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('HTTP/1.0 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="use this hash key to encode"');
            echo 'Você deve digitar um login e senha válidos para acessar este recurso\n';
            exit;
        }

        if (!isset($users[$_SERVER['PHP_AUTH_USER']]) or $users[$_SERVER['PHP_AUTH_USER']] != md5($_SERVER['PHP_AUTH_PW'])) {
            header('HTTP/1.0 401 Unauthorized');
            echo 'Credenciais inválidas';
            exit();
        }

        echo 'Login success';
        exit;
    }

    public static function logout()
    {
        header('HTTP/1.0 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="use this hash key to encode"');
        die('logout');
    }
}
