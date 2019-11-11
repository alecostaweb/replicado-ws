<?php
// esta parte é somente para os testes direto no navegador.
// Vamos incluir no Wp somente a  partir da próxima tah PHP
// vamos carregar $srv, $codare e outros dados específicos
require_once '../credentials.php';
?>

<?php
/**
 * Retorna os alunos egressos da área de concentração (codare)
 * Site: https://github.com/uspdev/replicado-ws
 */

//$codare = 18134;
//$srv = 'https://api.eesc.usp.br/replicado';
//$auth_user = '';
//$auth_pwd = '';

$context = stream_context_create([
    'http' => [
        'header' => 'Authorization: Basic ' . base64_encode($auth_user . ':' . $auth_pwd),
    ],
]);

$endpoint = $srv . '/posgraduacao/egressosArea/' . $codare;

if (!($json = file_get_contents($endpoint, false, $context))) {
    echo 'Erro ao ler ' . $srv;exit;
}

$resource = json_decode($json, true);

$num_rows = count($resource);

function nivel($nivpgm)
{
    switch ($nivpgm) {
        case 'DO':
            return 'Doutorado';
            break;
        case 'ME':
            return 'Mestrado';
            break;
        case 'DD':
            return 'Doutorado direto';
            break;
        default:
            return $nivpgm;
    }
}

?>
<style>
.alunos_egressos {
    font-size: 14px;
    color: black;
    font-family: verdana;
}
</style>
<div class="alunos_egressos">

    <input type="text" id="myTableFilterInput" onkeyup="myTableFilter()" placeholder="Filtrar ..">

    <table class="table" id="myTableFilter" style="table-layout:auto;">
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th>Ano de conclusão</th>
        </tr>
        <?php foreach ($resource as $row) {?>
        <tr>
            <td><?php echo $row['nompes'] ?></td>
            <td><?php echo nivel($row['nivpgm']) ?></td>
            <td><?php echo substr($row['dtadfapgm'], 0, 4) ?></td>
        </tr>
        <?php }?>
    </table>
</div>

<script type="text/javascript">
// https://stackoverflow.com/questions/51187477/how-to-filter-a-html-table-using-simple-javascript

function myTableFilter() {
  const filter = document.querySelector('#myTableFilterInput').value.toUpperCase();
  const trs = document.querySelectorAll('#myTableFilter tr:not(.header)');
  trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
}
</script>