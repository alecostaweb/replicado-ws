<!-- O jquery é necessário para testar aqui mas dentro do WP ele já está carregado -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<?php
/* este código permite consumir as disciplinas em oferecimento de determinada área de concentração da pós
 * e colocar o conteúdo numa página do wordpress
 * foi testado usando o plugin PHP Everywhere do Wordpress 5.2.2
 * os dados do webservice vem em json.
 * depois é formatado em lista clicavel para mostrar os detalhes de cada disciplina
 * 
 * para teste pode rodar diretamente num navegador
 *
 * o estilo está organizado de forma a facilitar algum ajuste bem como as principais variáveis a serem configuradas
 *
 * Site: https://github.com/uspdev/replicado-ws
 * 13/9/2019
 */

$codare = '18134'; // eng estruturas
$sort = ''; // default: nomdis - que vem do endpoint. Coloque o nome do campo que quiser ordenar. ex. sgldis
$offset = 100; // offset ao rolar para cima por conta do menu fixo utilizado no template. Sem menu fixo o offset é 0

// producao ou testes
//$endpoint = 'http://servidor/replicado/posgraduacao/catalogodisciplinas/' . $codare . '?l=completo';
$endpoint = 'http://143.107.233.112/git/uspdev/replicado-ws/www/posgraduacao/disciplinas_oferecimento/'.$codare.'?l=completo';

// ------------------------------------------------
$json = file_get_contents($endpoint);
$resource = json_decode($json, true);

if ($sort) {
    usort($resource, function ($a, $b) {
        global $sort;
        return strcmp($a[$sort], $b[$sort]);
    });
}

$num_rows = count($resource);

function ministrante($ministrante) {
    $ret = '';
    foreach($ministrante as $m) {
        $ret .= $m['nompes'].'<br>';
    }
    $ret = substr($ret,0, -4);
    return $ret;
}

function horariolocal($espacoturma) {
    $ret = '';
    foreach($espacoturma as $e) {
        $ret .= $e['diasmnofe'].', '.$e['horiniofe'].' - '.$e['horfimofe'].', '.$e['locofe'].'<br>';
    }
    $ret = substr($ret,0, -4);
    return $ret;
}

?>

<div class="oferecimentos">
    <div class="count">Foram encontradas <?php echo $num_rows ?> disciplinas.</div>
    <ul>
        <?php foreach ($resource as $row) {?>
        <li id="<?php echo $row['sgldis'] ?>">
            <div>
                <a href class="detalhes_btn"><?php echo $row['sgldis'] ?> - <?php echo $row['nomdis'] ?></a>
            </div>
            <div class="detalhes_div" style="display:none;">

                <div><b>Número de vagas</b><br>
                <b>Alunos regulares</b>: <?php echo $row['numvagofe'] ?> &nbsp;
                <b>Alunos especiais</b>: <?php echo $row['numvagespofe'] ?> &nbsp;
                <b>Total</b>: <?php echo $row['numvagofetot'] ?></div>

                <div><b>Número mínimo de alunos</b>: <?php echo $row['numminins'] ?></div>
                <div><b>Data inicial</b>: <?php echo $row['dtainiofe'] ?> &nbsp; <b>Data final</b>: <?php echo nl2br($row['dtafimofe']) ?></div>
                <div><b>Data limite de cancelamento</b>: <?php echo $row['dtalimcan'] ?></div>
                <div><b>Número de créditos</b>: <?php echo $row['numcretotdis'] ?></div>
                <div><b>Docente(s) ministrante(s)</b><br><?php echo ministrante($row['ministrante']) ?></div>
                <div><b>Horário/Local</b><br><?php echo horariolocal($row['espacoturma']) ?></div>
                <div><b>Critério de seleção</b><br><?php echo nl2br($row['criselofe']) ?></div>
                <div><b>Idioma</b>: <?php echo nl2br($row['codlinofe']) ?></div>
            </div>
        </li>
        <?php }?>
    </ul>
</div>

<style>
/* aumentando um pouco o tamanho da fonte */
.oferecimentos {
    font-size: 14px;
}

.oferecimentos ul,
li {
    list-style-type: none;
    padding: 0;
}

/* ajustando a cor da linha da disciplina */
.oferecimentos a {
    color: black;
    text-decoration: none;
}

/* acrescentando um espaço entre os elementos dos detalhes e edentando um pouco o detalhamento */
.oferecimentos .detalhes_div div {
    padding: 4px;
    padding-left: 8px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    // ao clicar na disciplina ele esconde os detalhes de outra disciplina e
    // mostra os detalhes da qual clicou. Clicando novamente ele esconde tudo.
    var offset = <?php echo $offset; ?>;
    $(".detalhes_btn").click(function(e) {
        e.preventDefault();
        var detalhes = $(this).parent().parent().find(".detalhes_div");
        var visible = detalhes.is(":visible");

        $(".detalhes_div").hide();

        if (!visible) {
            detalhes.slideDown();
            location.hash = "#" + $(this).parent().parent().attr("id");
            $([document.documentElement, document.body]).animate({
                scrollTop: $(location.hash).offset().top - offset
            }, 500);
        }
    });
});
</script>