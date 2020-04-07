<?php
// vamos carregar DOMINIO, $codcur
require_once '../credentials.php';
?>


<?php
/**
 * Retorna os alunos do programa de pós-graduação (codcur) dentro de suas áreas de atuação (codare)
 * Site: https://github.com/uspdev/replicado-ws
 */

//$codcur = filter_input(INPUT_GET, 'codcur', FILTER_VALIDATE_INT);
//define("DOMINIO", "http://dev.igc.usp.br/replicado-ws/www"); 

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

$endpoint = DOMINIO . '/posgraduacao/alunosPrograma/' . $codcur;
$json = file_get_contents($endpoint);
$alunos = json_decode($json, true);

foreach ($areas[$codcur] as $area){

    $codare = $area['codare'];
    $nomare = $area['nomare'];
    ?>

    <div class="alunos_programa">
        <div><h3>Área <?php echo "$codare - $nomare" ?></h3></div>
        <table class="table" style="table-layout:auto;">
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
            
            <?php
            // get idLattes
            $endpoint = DOMINIO . '/lattes/idLattes/' . $row['codpes']; 
            $json = file_get_contents($endpoint);
            $resLattes = json_decode($json, true);
            $linkLattes = "http://lattes.cnpq.br/" . $resLattes['idLattes']; 
            ?>
            
            <tr>
                <td><?php echo  $row['nivpgm'] ?></td>
                <td><?php echo  $row['nompes'] ?></td>
                <td><?php echo  $row['codema'] ?></td>
                <td><?php echo "<a href=$linkLattes>lattes</a>"; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php
}
?>