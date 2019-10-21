<?php
// vamos carregar DOMINIO, $codcur
require_once '../credentials.php';
?>


<?php
/**
 * Retorna os orientadores do programa de pós-graduação (codcur) dentro de suas áreas de atuação (codare)
 * Site: https://github.com/uspdev/replicado-ws
 */

//define("DOMINIO", "http://dev.igc.usp.br/replicado-ws/www"); 
//$codcur = 44005;

// ----------------------------------------

$endpoint = DOMINIO . '/posgraduacao/areasProgramas/' . $codcur;

if (!($json = file_get_contents($endpoint))) {
    echo 'Erro ao ler ' . DOMINIO; exit;
}

$areas = json_decode($json, true);

foreach ($areas[$codcur] as $area) {

    $codare = $area['codare'];
    $nomare = $area['nomare'];

    $endpoint = DOMINIO . '/posgraduacao/orientadores/' . $codare;

    $json = file_get_contents($endpoint);
    $resource = json_decode($json, true);
    ?>

    <div class="orientadores_credenciados">
        <div>
            <h3>Área <?php echo "$codare - $nomare" ?></h3>
        </div>
        <table class="table">
            <tr>
                <th>Nome</th>
                <th>Nível</th>
                <th>Validade</th>
            </tr>
            <?php foreach ($resource as $row) {?>
            <tr>
                <td><?php echo $row['nompes'] ?></td>
                <td><?php echo $row['nivare'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['dtavalfim'])) ?></td>
            </tr>
            <?php }?>
        </table>
    </div>
<?php } ?>