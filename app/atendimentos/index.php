<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
        require '../php/global.php';
        require '../paciente/php/func.php';
        require 'php/func.php';
        
        $obj_atendimentos = new Atendimentos();
        

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FRC HOME</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="corpo">
    <header>
            <p><div id="empresa"><?php echo $obj_empresa->getRazao(); ?></div><div id="imgprofilecabecalho"></div> <div id="nomecabecalho"> <?php echo $obj_usuario->getNome(); ?></div></p>
            <p><div id="cnpj"><?php echo $obj_usuario->getCnpj(); ?></div><a href="../php/encerrar.php" id="sair">Sair</a></p>
        </header>
        <aside>
            <div class="menudiv">
                <p align="center"><div id="imgprofile"></div></p>
                <ul id="perfildados">
                    <li id="perfiledit"><button class="botaomenuperfil"></button></li>
                    <li id="mensagem"><button class="botaomenuperfil"></button></li>
                    <li id="system"><button class="botaomenuperfil"></button></li>
                </ul>
                <br><br>
            </div>
            <div id="home">
                <div class="menudiv">
                    <p align="center" class="titulomenu">HOME</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="dashb"><button class="botaomenulista" onclick="location.href='../home.php'"><span>INICIAL</span></button></li>
                        <li id="pac"><button class="botaomenulista" onclick="location.href='../paciente '"><span>PACIENTES</span></button></li>
                    </ul>
                </div>
            </div>
            <div id="atendimentos">
                <div class="menudiv">
                    <p align="center" class="titulomenu">ATENDIMENTOS</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="atend"><button class="botaomenulista" onclick="location.href='index.php'"><span>ATENDIMENTOS</span></button></li>
                        <li id="pront"><button class="botaomenulista"><span>PRONTUARIOS</span></button></li>
                        <li id="agenda"><button class="botaomenulista"><span>AGENDA</span></button></li>
                    </ul>
                </div>
            </div>
            <div id="leads">
                <div class="menudiv">
                    <p align="center" class="titulomenu">MAILING / LEADS</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="lead"><button class="botaomenulista"><span>LEADS ATIVOS</span></button></li>
                        <li id="leadsint"><button class="botaomenulista"><span>LEADS SEM INTERESSE</span></button></li>
                    </ul>
                </div>
            </div>
        </aside>
        <section>
        <div id="cab">Atendimentos</div>
            <div>
                <?php
                    $recebe_query = $obj_atendimentos->GeraListaAtend("2019-07-17");
                    while($listaAtend = $recebe_query->fetch()){
                        $nome_pac = $listaAtend['nome'];
                        $cpf_pac = $listaAtend['cpf'];
                ?>
                    <p>Nome: <?php echo $nome_pac;?>, CPF: <?php echo $cpf_pac; ?> </p>
                <?php 
                    }
                ?>
            </div>
        </section>
        <footer>
        </footer>
    </div>
    <script src="../js/global.js"></script>
</body>
</html>
<?php
}else{
    header("location:../../public/index.php");
}
