<!-- O jquery é necessário para testar aqui mas dentro do WP ele já está carregado -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<br><br><br><br>

<?php
/* este código permite consumir o catálogo de disciplinas de determinada área de concentração da pós
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
$endpoint = 'http://servidor/replicado/posgraduacao/catalogodisciplinas/' . $codare . '?l=completo';

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
?>
<div class="catalogo_disciplinas">
    <div class="count">Foram encontradas <?php echo $num_rows ?> disciplinas.</div>
    <ul>
        <?php foreach ($resource as $row) {?>
        <li id="<?php echo $row['sgldis'] ?>">
            <div>
                <a href class="detalhes_btn"><?php echo $row['sgldis'] ?> - <?php echo $row['nomdis'] ?></a>
            </div>
            <div class="detalhes_div" style="display:none;">
                <div><b>Créditos </b> <br><?php echo $row['numcretotdis'] ?></div>
                <div><b>Objetivos</b><br><?php echo nl2br($row['objdis']) ?></div>
                <div><b>Justificativa</b><br><?php echo nl2br($row['jusdis']) ?></div>
                <div><b>Conteúdo</b><br><?php echo nl2br($row['ctudis']) ?></div>
                <div><b>Forma de avaliação</b><br><?php echo $row['tipavldis'] ?></div>
                <div><b>Observação</b><br><?php echo nl2br($row['obsdis']) ?></div>
                <div><b>Bibliografia</b><br><?php echo nl2br($row['ctubbgdis']) ?></div>
            </div>
        </li>
        <?php }?>
    </ul>
</div>

<style>
/* aumentando um pouco o tamanho da fonte */
.catalogo_disciplinas {
    font-size: 14px;
}

.catalogo_disciplinas ul,
li {
    list-style-type: none;
    padding: 0;
}

/* ajustando a cor da linha da disciplina */
.catalogo_disciplinas a {
    color: black;
    text-decoration: none;
}

/* acrescentando um espaço entre os elementos dos detalhes e edentando um pouco o detalhamento das disciplinas */
.catalogo_disciplinas .detalhes_div div {
    padding: 4px;
    padding-left: 8px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    // ao clicar na disciplina ele esconde os detalhes de outra disciplina e
    // mostra os detalhes da qual clicou. Clicando novamente ele esconde tudo.
    var offset = <?php echo $offset; ?>;
    $(".catalogo_disciplinas .detalhes_btn").click(function(e) {
        e.preventDefault();
        var app = $(this).parent().parent();
        var detalhes = app.find(".detalhes_div");
        var visible = detalhes.is(":visible");

        $(".detalhes_div").hide();

        if (!visible) {
            detalhes.slideDown(100);
            location.hash = "#" + app.attr("id");
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#" + app.attr("id")).offset().top - offset
            }, 100);
        }
    });
});
</script>