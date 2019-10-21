<?php
// vamos colocar as credenciais nesse arquivo separado para permitir rodar 
// mais facilmente os exemplos contidos no consumer.
// Assim cada um pode manter um credentials.php proprio e testar todos os consumers.
// Copie este arquivo para credentials.php e altere conforme necessário

// servidor que irá consultar
$srv = 'http://143.107.233.112/git/uspdev/replicado-ws/www';

define("DOMINIO", "http://dev.igc.usp.br/replicado-ws/www"); 

// parametros para PG
$codare = 00000;
$codcur = 00000;