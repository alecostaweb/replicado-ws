<?php

use Uspdev\Replicado\Posgraduacao;
use Uspdev\Replicado_ws\Auth;

Flight::route('/graduacao', function () {
    global $help;
    Flight::jsonf($help);
});
