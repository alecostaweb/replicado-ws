<?php
/* este código permite consumir os orientadores credenciados em determinada área de concentração da pós
 * e colocar o conteúdo numa página do wordpress
 * foi testado usando o plugin PHP Everywhere do Wordpress 5.2.2
 * os dados do webservice vem em json.
 * 
 * para teste pode rodar diretamente num navegador
 *
 * Site: https://github.com/uspdev/replicado-ws
 * 13/9/2019
 */

$codare = '18134'; // eng estruturas

// producao ou testes
$endpoint = 'http://servidor/replicado/posgraduacao/orientadores/' . $codare;
//$endpoint = 'http://143.107.233.112/git/replicadoservice/www/posgraduacao/orientadores/'.$codare;

// ------------------------------------------------
$json = file_get_contents($endpoint);
$resource = json_decode($json, true);

$num_rows = count($resource);
?>
<div class="orientadores_credenciados">
    <div><?php echo $num_rows ?> orientadores credenciados na área <?php echo $codare ?></div>
    <table class="table">
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th>Validade</th>
        </tr>
        <?php foreach ($resource as $row) { ?>
        <tr>
            <td><?php echo  $row['nompes'] ?></td>
            <td><?php echo  $row['nivare'] ?></td>
            <td><?php echo  date('d/m/Y', strtotime($row['dtavalfim'])) ?></td>
        </tr>
        <?php } ?>
    </table>
</div>