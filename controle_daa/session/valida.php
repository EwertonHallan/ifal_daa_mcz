<?php 
define('TEMPO_LOGADO',3600);  // tempo de duracao em segundos = 3600

session_start(); 
$expirou = false;

//validando tempo de duracao da sessao
// pegamos o tempo atual em que estamos:
$agora = mktime(date("H"), date("i"), date("s"));

// subtraimos o tempo em que o usuário entrou, do tempo atual "a diferença é em segundos"
$segundos = (is_numeric($_SESSION['tempo_session']) and is_numeric($agora)) ? ($agora-$_SESSION['tempo_session']):false;

if($segundos > TEMPO_LOGADO) {
    $expirou = true;
}

if ((!isset($_SESSION['login']) && !isset($_SESSION['password'])) || ($expirou)) {
    session_destroy();
    header("Location: session/login.php");
}

?>
