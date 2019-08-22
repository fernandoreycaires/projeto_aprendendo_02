<?php 
session_start();

if(!isset($_SESSION['cnpj_session']) and !isset($_SESSION['user_session']) and !isset($_SESSION['pass_session']) ){
    //SE AS INFORMAÇÕES NÃO ESTIVERAM VALIDADAS NO BANCO, A PAGINA SERÁ REDIRECIONADA PARA A INDEX
    header("location:../../public/index.php");
}else{
    //CASO FOR VALIDADO NO BANCO, SERÁ REDIRECIONADA PARA O HOME
    header("location:../home.php");
}

//PEGUA INFORMAÇÃO DE ACESSO DO INDEX VIA POST
$cnpj = isset($_POST["tCNPJ"])?$_POST["tCNPJ"]:'';
$user = isset($_POST["tUser"])?$_POST["tUser"]:'';
$pass = isset($_POST["tPass"])?$_POST["tPass"]:'';

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
include 'cx.php';
$acesso = "SELECT usuario , pass , cnpj_vinc FROM cnpj_user WHERE cnpj_vinc = '".$cnpj."' AND pass='".$pass."' AND usuario='".$user."'";
$query = $cx->query ($acesso);

while ($acesso_user = $query->fetch()){
$cnpjbanco = $acesso_user['cnpj_vinc'];
$usuariobanco = $acesso_user['usuario'];
$senhabanco = $acesso_user['pass'];
}

//VALIDAÇÃO DE DADOS PARA INICIAR A SESSÃO DENTRO DO WHILE
if ($cnpjbanco != '' and $usuariobanco != '' and $senhabanco != ''){
    $_SESSION['cnpj_session']=$cnpjbanco;
    $_SESSION['user_session']=$usuariobanco;
    $_SESSION['pass_session']=$senhabanco;
    header("location:../home.php"); 
}

