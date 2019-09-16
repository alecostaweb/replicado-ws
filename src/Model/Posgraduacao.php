<?php
namespace Uspdev\Replicado_ws\Model;
use \Uspdev\Replicado\Posgraduacao as UspdevPosgraduacao;

class Posgraduacao {

    // o uspdev/replicado pega somente os dados básicos da disciplina no método catálogodisciplina.
    // vamos pegar todos os dados aqui
    public static function catalogoDisciplinas($codare) {
        $catalogo = UspdevPosgraduacao::catalogoDisciplinas($codare);
        for ($i=0;$i<count($catalogo); $i++) {
            $sgldis = $catalogo[$i]['sgldis'];
            $disciplina = UspdevPosgraduacao::disciplina($sgldis);
            $catalogo[$i] = array_merge($catalogo[$i], $disciplina);

            // vamos omitir alguns campos
            unset($catalogo[$i]['codpesalt']);
            unset($catalogo[$i]['dtaultalt']);
            unset($catalogo[$i]['dtadtvdis']);
            unset($catalogo[$i]['timestamp']);
        }
        return $catalogo;
    }
}