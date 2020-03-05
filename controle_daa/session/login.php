<?php
require_once('../banco/conexao.php');
require_once('../banco/funcaobanco.php');

require_once('../util/funcaocaracter.php');
require_once('../util/funcaodata.php');

require_once('../classe/log.php');
require_once('../geral/classe/usuario.php');

//https://www.melhorhospedagemdesites.com/dicas-e-ferramentas/mostrar-erros-php/
// Desativa toda exibição de erros no php.ini 
//opcao error_reporting= colocar este valor E_ERROR & ~E_DEPRECATED & ~E_STRICT
//opcao date.timezone= colocar este valor date.timezone=America/Maceio
//error_reporting(0);
// Exibe erros simples
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Inicia a sessão
session_start();

//Limpando as variaveis da sessao
unset ($_SESSION["id"]);
unset ($_SESSION['login']);
unset ($_SESSION['password']);
unset ($_SESSION['user_name']);
unset ($_SESSION['user_email']);
unset ($_SESSION['user_acess']);
unset ($_SESSION["dir_base_html"]);
unset ($_SESSION["dir_modulo"]);
unset ($_SESSION['tempo_session']);
unset ($_SESSION['tipo_user']);
unset ($_SESSION['versao']);


//verificando o modo de edicao ou exclusao
$login = NULL;
$senha = NULL;
$mensagem = NULL;

if (!empty($_POST['login'])) {
    $login = $_POST['login'];
}

if (!empty($_POST['senha'])) {
    $senha = FuncaoBanco::encriptaMD5($_POST['senha']);
}

//verifica usuario e senha 
if (!empty($login) && !empty($senha)) {
    //co
    $user = new Usuario();
    $result = $user->loginUsuario($login, $senha);
    //var_dump($result);
    
    if (strlen($result['nome'])) {
        $_SESSION["id"] = $result['id_usuario'];
        $_SESSION["login"] = $login;
        $_SESSION["password"] = $senha;
        $_SESSION["user_name"] = $result['nome'];
        $_SESSION["user_email"] = $result['email'];
        $_SESSION["user_acess"] = $result['ultacesso'];
        $_SESSION["dir_base_html"] = 'http://'.$_SERVER['HTTP_HOST'].'/controle_daa/';
        $_SESSION["dir_modulo"] = 'geral/';
        //$_SESSION["dir_modulo"] = 'freq_docentes/';
        //$_SESSION["dir_base_html"] = 'http://'.$_SERVER['HTTP_HOST'].'/freq_docentes/';
        $_SESSION['tempo_session'] = mktime(date("H"), date("i"), date("s"));
        $_SESSION['tipo_user'] = $result['tipo'];
        $_SESSION['versao'] = 'v 1.02.116.512';
        
        header("Location: ".$_SESSION["dir_base_html"]."index.php");
    } else {
        $mensagem = '<h6><font sizi=2 color=red>'.FuncaoCaracter::acentoTexto('Usuário e/ou Senha inválido!').'</font></h6>';
        //$mensagem .= '<br>Senha criptografada:'.$senha.'<br>';
        //$mensagem .= '<br>'.FuncaoBanco::encriptaMD5('teste').'<br>'; 
    }
} else {
    if (!empty($login) || !empty($senha)) {
       $mensagem = '<h6><font sizi=2 color=red>'.FuncaoCaracter::acentoTexto('Usuário e Senha obrigatórios!').'</font></h6>';       
    }
}

echo '<html><head>';
echo '<meta charset="ISO-8859-1">';
echo '<title>Controle D.A.A.</title>';

echo '<link rel="stylesheet" type="text/css" href="../form/formulario.css" />';
echo '</head>';
echo '<body>';

echo '<form id="form_login" name="form_login" method="post" action="'.$_SERVER['PHP_SELF'].'">';
echo '<table background="../imagem_fundo.png" border=0 width="600px" cellspacing="0" cellpadding="0">';
echo '<tr><td colspan="2">';
     require_once('../cabecalho.php');
echo '<br><br><br><br> </td></tr>';
echo '<tr><td align="center" colspan="2"><div id="dvCadUsuario">';
echo '<table border=0 cellspacing="0" cellpadding="0"><tr><td align="center" colspan="2">';
echo '<h4>'.FuncaoCaracter::acentoTexto('IDENTIFICAÇÃO DO USUÁRIO').'<br><br></h4></td></tr>';
echo '<tr><td align="right" width="30%">'.FuncaoCaracter::acentoTexto('Usuário:').'&nbsp&nbsp</td>';
echo '    <td align="left" width="70%"><input type="text" class="campo" id="login" name="login" size=20 value="'.$login.'" required /></td>';
echo '</tr>';
echo '<tr><td colspan="2">&nbsp</td></tr>';
echo '<tr><td align="right">Senha:&nbsp&nbsp</td>';
echo '    <td align="left"><input type="password" class="campo" id="senha" name="senha" size=20 value="" required/></td></tr>';
echo '<tr><td colspan="2" align="center">&nbsp'.$mensagem.'<br></td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" class="btn" id="enviar" name="enviar" form="form_login" value="Entrar" /></td></tr>';
echo '</table></td></tr><tr><td><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr></table>';
echo '</form>';
echo '</body></html>';
?>
