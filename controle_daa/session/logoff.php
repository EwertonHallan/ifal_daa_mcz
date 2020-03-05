<?php
require_once('../banco/conexao.php');
require_once('../banco/funcaobanco.php');
require_once('../util/funcaocaracter.php');
require_once('../classe/log.php');
require_once('../geral/classe/usuario.php');

session_start();


session_destroy();

$user = new Usuario();
$user->UltimoAcesso ($_SESSION["id"]);


header("Location: ".$_SESSION["dir_base_html"]."session/login.php");
?>