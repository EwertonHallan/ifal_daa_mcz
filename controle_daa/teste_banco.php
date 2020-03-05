<?php
/*
 * Melhor prática usando Prepared Statements
 *
 */

$user = "root";
$senha = "";
$banco = "controle_daa";
//$servidor = "localhost";
//$servidor = "172.16.5.244";  // claudia
$servidor = "172.16.26.146";   // ewerton

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$banco", $user , $senha);
    //$conn = new PDO("mysql:host=".$servidor.";dbname=".$banco."", $user, $senha);
    //$conn = new PDO('mysql:host=localhost;dbname=controle_daa', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $conn->prepare('SELECT * FROM coordenacao order by id_coordenacao');
    
    while($row = $stmt->fetch()) {
        print_r($row);
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>