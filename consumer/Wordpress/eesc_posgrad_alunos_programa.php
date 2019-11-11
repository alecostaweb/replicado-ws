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
//$srv = 'https://api.eesc.usp.br/replicado';

$endpoint = $srv . '/posgraduacao/areasProgramas/' . $codcur; 
$json = file_get_contents($endpoint);
$areas = json_decode($json, true);

$endpoint = $srv . '/posgraduacao/alunosPrograma/' . $codcur;
$json = file_get_contents($endpoint);
$alunos = json_decode($json, true);

function nivel($nivpgm)
{
    switch ($nivpgm) {
        case 'DO': return 'Doutorado'; break;
        case 'ME': return 'Mestrado'; break;
        case 'DD': return 'Doutorado direto'; break;
        default: return $nivpgm;
    }
}

foreach ($areas[$codcur] as $area){

    $codare = $area['codare'];
    $nomare = $area['nomare'];
    ?>

    <div class="alunos_programa">

    <input type="text" id="myTableFilterInput" onkeyup="myTableFilter()" placeholder="Filtrar ..">

        <table class="table" id="myTableFilter" style="table-layout:auto;">
            <tr>
                <th>Nome</th>
                <th>Nível</th>
                <th>Ano de ingresso</th>
            </tr>
            <?php foreach ($alunos as $row) { ?>
            <tr>
                <td><?php echo  $row['nompes'] ?></td>
                <td><?php echo  nivel($row['nivpgm']) ?></td>
                <td><?php echo  substr($row['dtainivin'],0,4) ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>

<script type="text/javascript">
// https://stackoverflow.com/questions/51187477/how-to-filter-a-html-table-using-simple-javascript

function myTableFilter() {
  const filter = document.querySelector('#myTableFilterInput').value.toUpperCase();
  const trs = document.querySelectorAll('#myTableFilter tr:not(.header)');
  trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
}
</script>