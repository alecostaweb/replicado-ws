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

    // o uspdev/replicado pega somente os dados básicos da disciplina no método disciplinasOferecimento.
    // vamos pegar todos os dados aqui recursivamente
    public static function disciplinasOferecimento($codare) {
        $disciplinas = UspdevPosgraduacao::disciplinasOferecimento($codare);
        for ($i=0;$i<count($disciplinas); $i++) {
            $sgldis = $disciplinas[$i]['sgldis'];
            $numofe = $disciplinas[$i]['numofe'];
            $oferecimento = UspdevPosgraduacao::oferecimento($sgldis, $numofe);
            $disciplinas[$i] = array_merge($disciplinas[$i], $oferecimento);
        }
        return $disciplinas;
    }
}