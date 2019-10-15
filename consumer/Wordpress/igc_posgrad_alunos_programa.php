<?php

/**
 * Retorna os alunos do programa de pós-graduação (codcur) dentro de suas áreas de atuação (codare)
 */

$codcur = 44005;
define("DOMINIO", "http://dev.igc.usp.br/replicado-ws/www"); 

$endpoint = DOMINIO . '/posgraduacao/areasProgramas/' . $codcur; 
$json = file_get_contents($endpoint);
$areas = json_decode($json, true);

$endpoint = DOMINIO . '/posgraduacao/alunosPrograma/' . $codcur;
$json = file_get_contents($endpoint);
$alunos = json_decode($json, true);

foreach ($areas[$codcur] as $area){

    $codare = $area['codare'];
    $nomare = $area['nomare'];
    ?>

    <div class="alunos_programa">
        <div><h3>Área <?php echo "$codare - $nomare" ?></h3></div>
        <table class="table">
            <tr>
                <th>Nível</th>
                <th>Nome</th>
                <th>E-Mail</th>
            </tr>
            <?php foreach ($alunos as $row) { 
                if ($row['codare']!=$codare) {
                    continue;
                }
                ?>
            <tr>
                <td><?php echo  $row['nivpgm'] ?></td>
                <td><?php echo  $row['nompes'] ?></td>
                <td><?php echo  $row['codema'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php
}
?>