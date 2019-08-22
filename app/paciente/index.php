<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
       require '../php/global.php';
       require 'php/func.php';
       
       $buscacpfrg = isset($_POST['busca'])?$_POST['busca']:"";
       
       $pacientes_dados = new Pacientes($buscacpfrg);
       
       if ($pacientes_dados->getPacNome() == ""){
            $tipo_var = "hidden";
       }else{
            $tipo_var = "submit";
       }

       //INICIA OBJETO LISTA AGENDAMENTO 
       $lista_agendamentos = new ListaAgendaPaciente();
       $lista_agendamentos->setBusca("{$pacientes_dados->getPacCpfSemPonto()}");

       //INICIA OBJETO DE LISTA CHECK-INS
       $lista_checkins = new ListaCheckinsPaciente();
       $lista_checkins->setBuscaCheckLista("{$_POST['busca']}")

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
                        <li id="pac"><button class="botaomenulista" onclick="location.href='index.php'"><span>PACIENTES</span></button></li>
                    </ul>
                </div>
            </div>
            <div id="atendimentos">
                <div class="menudiv">
                    <p align="center" class="titulomenu">ATENDIMENTOS</p>
                </div>
                <div class="menudiv">
                    <ul id="listamenu">
                        <li id="atend"><button class="botaomenulista" onclick="location.href='../atendimentos'"><span>ATENDIMENTOS</span></button></li>
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
            <div class="container-fluid">
                <div id="cab">Pacientes</div>
                <div id="busca">    
                    <form action="" method="post">
                        <input type="text" name="busca" id="busca" placeholder="BUSQUE POR CPF OU RG">
                        <button type="submit" class="btn-buscar">Buscar</button>
                        <button type="button" class="btn-visualizar" onclick="location.href='cadastrar.php'">Novo</button>
                    </form>
                </div>
                <div id="res">
                    <?php echo $pacientes_dados->getPacNome();?>
                    <br><?php echo $pacientes_dados->getPacCpf();?>
                        <?php echo $pacientes_dados->getPacRg();?>
                    <br><?php echo $pacientes_dados->getPacIdade();?>
                    <br><form action="perfil.php" method="post">
                            <input type="hidden" name="id_pac" id="id_pac" value="<?php echo $pacientes_dados->getPacId();?>">
                            <input type="<?php echo $tipo_var;?>" value="Visualizar" class="btn-visualizar-sm">
                        </form>
                </div>
                <div id="hist">
                    <h5>Histórico de agendamentos</h5>
                    <p><?php 
                        $lista_agenda = $lista_agendamentos->Lista(); 
                        while ($lista = $lista_agenda->fetch()){
                            $dataini = $lista['inicio'];
                            //SEPARA A DATA DA HORA
                            list($datafull, $hora ) = explode(' ', $dataini);
                            //SEPARA EM DIA MES E ANO
                            list($ano, $mes, $dia ) = explode('-', $datafull);
                            //JUNTA O DIA MES E ANO NO FORMATO BRASIL, COM AS BARRAS "/"
                            $datafull = $dia."/".$mes."/".$ano;

                            //SEPARA EM HORA MINUTO SEGUNDO
                            list($h, $m, $s ) = explode(':', $hora);
                            //JUNTA EM HORA E MINUTO
                            $hora_min = $h.":".$m;

                            //LISTA PARA QUAL DOUTORES FOI FEITO O AGENDAMENTO
                            $doutor = $lista['doutor'];
                        ?>
                        <p><?php echo "$datafull $hora_min $doutor"; ?></p>
                        <?php
                            
                        }    
                        ?>
                    </p>
                </div>
                <div id="hist">
                    <h5>Historico de check-in</h5>
                    <p>
                        <?php
                        $lista_agenda = $lista_checkins->ListaCheckins(); 
                        while ($lista = $lista_agenda->fetch()){
                            $hora_ini = $lista['ini_hora'];
                            $dataini = $lista['ini_data'];
                            //SEPARA EM DIA MES E ANO
                            list($ano, $mes, $dia ) = explode('-', $dataini);
                            //JUNTA O DIA MES E ANO NO FORMATO BRASIL, COM AS BARRAS "/"
                            $datafull = $dia."/".$mes."/".$ano;

                            //SEPARA EM HORA MINUTO SEGUNDO
                            list($h, $m, $s ) = explode(':', $hora_ini);
                            //JUNTA EM HORA E MINUTO
                            $hora_min = $h.":".$m;

                            //LISTA PARA QUAL DOUTORES FOI FEITO O ATENDIMENTO
                            $doutor = $lista['doutor'];
                        ?>
                        <p><?php echo "$datafull $hora_min $doutor"; ?></p>
                        <?php
                        }
                        ?>
                    </p> 
                </div>
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