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

    // Implementa controle de acesso por IP
    // Se definido IP_ACCESS_LIST, usará essa lista de ip/prefixo para
    // autorizar o acesso a todos os endpoints
    // Para desativar não defina a constante IP_ACCESS_LIST
    public static function ip_control()
    {
        if (defined('IP_ACCESS_LIST')) {
            foreach (IP_ACCESS_LIST as $ip_list) {
                // https://stackoverflow.com/questions/2869893/block-specific-ip-block-from-my-website-in-php
                $network = ip2long($ip_list[0]);
                $prefix = $ip_list[1];
                $ip = ip2long($_SERVER['REMOTE_ADDR']);

                if ($network >> (32 - $prefix) == $ip >> (32 - $prefix)) {
                    return true;
                }
            }
            \Flight::forbidden();
        }
        return true;
    }
}
