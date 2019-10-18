<?php

/**
 * Retorna os orientadores do programa de pós-graduação (codcur) dentro de suas áreas de atuação (codare)
 */

$codcur = filter_input(INPUT_GET, 'codcur', FILTER_VALIDATE_INT);
//$codcur = 44005;
define("DOMINIO", "http://dev.igc.usp.br/replicado-ws/www"); 

// obtém dados do programa
$endpoint = DOMINIO . '/posgraduacao/programas/' . $codcur;
$json = file_get_contents($endpoint);
$programa = json_decode($json, true);
?>
<h2><?php echo $programa[0]['nomcur']; ?></h2>

<?php
$endpoint = DOMINIO . '/posgraduacao/areasProgramas/' . $codcur; 
$json = file_get_contents($endpoint);
$areas = json_decode($json, true);

foreach ($areas[$codcur] as $area){

    $codare = $area['codare'];
    $nomare = $area['nomare'];
    
    $endpoint = DOMINIO . '/posgraduacao/orientadores/' . $codare;

    $json = file_get_contents($endpoint);
    $resource = json_decode($json, true);
    ?>

    <div class="orientadores_credenciados">
        <div><h3>Área <?php echo "$codare - $nomare" ?></h3></div>
        <table class="table" style="table-layout:auto;">
            <tr>
                <th>Nome</th>
                <th>Nível</th>
                <th>Validade</th>
            </tr>
            <?php foreach ($resource as $row) { ?>
            <tr>
                <td><?php echo  $row['nompes'] ?></td>
                <td class="orientador_nivel"><?php echo  $row['nivare'] ?></td>
                <td class="orientador_validade"><?php echo  date('d/m/Y', strtotime($row['dtavalfim'])) ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php
}
?>

<style>
    
    .orientador_nivel, .orientador_validade {
        text-align: center;
    }
</style>