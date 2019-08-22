<?php
session_start();
if(!isset($_SESSION['cnpj_session']) and !isset($_SESSION['user_session']) and !isset($_SESSION['pass_session']) ){
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FRC</title>
    <link rel="stylesheet" href="index.css">
</head>
<body onload="momento()">
    <header>
        <p id="msg"></p>
    </header>
    
    <section>
        <div>
            <div id="logo" ></div>
            <p>Insira o CNPJ, Usuario e senha. </p>
            <form action="../app/php/session.php" method="POST">
                <input type="text" name="tCNPJ" id="cnpj" placeholder="CNPJ" required >
                <input type="text" name="tUser" id="user" placeholder="Usuário" required >
                <input type="password" name="tPass" id="pass" placeholder="Senha" required >
                <br>
                <button id="entrar">Entrar</button>
            </form>
        </div>
    </section>
    
    <footer>
        <p>&copy; FRC System </p>
    </footer>
    <script src="index.js"></script>
</body>
</html>
<?php 
}else{
    header("location:../app/home.php");
}
