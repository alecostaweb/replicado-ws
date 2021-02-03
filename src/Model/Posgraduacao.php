<?php
namespace Uspdev\Replicado_ws\Model;

use \Uspdev\Replicado\Posgraduacao as UspdevPosgraduacao;

class Posgraduacao
{

    // o uspdev/replicado pega somente os dados básicos da disciplina no método catálogodisciplina.
    // vamos pegar todos os dados aqui
    public static function catalogoDisciplinas($codare)
    {
        $catalogo = UspdevPosgraduacao::catalogoDisciplinas($codare);
        for ($i = 0; $i < count($catalogo); $i++) {
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
    public static function disciplinasOferecimento($codare)
    {
        // com a pandemia as disciplinas ficaram atrasadas então vamos passar as datas de inicio e fim
        // para o método pois o calculo automático dá errado.
        // Tratando o 1o semestre de 2021
        $today = new \DateTime('now');
        $ini = new \DateTime('1-1-2021');
        $fim = new \DateTime('30-7-2021');
        if ($today >= $ini && $today <= $fim) {
            $disciplinas = UspdevPosgraduacao::disciplinasOferecimento($codare, '20210101', '20210730');
        } else {
            $disciplinas = UspdevPosgraduacao::disciplinasOferecimento($codare);
        }

        for ($i = 0; $i < count($disciplinas); $i++) {
            #vamos remover timestamps que dá problema em json
            $sgldis = $disciplinas[$i]['sgldis'];
            $numofe = $disciplinas[$i]['numofe'];
            $oferecimento = UspdevPosgraduacao::oferecimento($sgldis, $numofe);
            unset($oferecimento['timestamp']);
            unset($oferecimento['espacoturma'][0]['timestamp']);
            $disciplinas[$i] = array_merge($disciplinas[$i], $oferecimento);
        }
        return $disciplinas;
    }
}
