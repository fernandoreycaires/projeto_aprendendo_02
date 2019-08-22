<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
        require '../php/global.php';
        require 'php/func.php';

        $mostrar = "style='display:none'";

        if ($_POST){
            $cad_nome = isset($_POST['nome'])?$_POST['nome']:NULL;
            $cad_cpf = isset($_POST['cpf'])?$_POST['cpf']:NULL;
            $cad_rg = isset($_POST['rg'])?$_POST['rg']:NULL;
            $cad_nasc = isset($_POST['nasc'])?$_POST['nasc']:NULL;
            $cad_prof = isset($_POST['prof'])?$_POST['prof']:NULL;
            $cad_sexo = isset($_POST['sexo'])?$_POST['sexo']:NULL;
            $cad_civil = isset($_POST['civil'])?$_POST['civil']:NULL;
            $cad_tel = isset($_POST['tel'])?$_POST['tel']:NULL;
            $cad_cel = isset($_POST['cel'])?$_POST['cel']:NULL;
            $cad_mail = isset($_POST['mail'])?$_POST['mail']:NULL;   

            //VERIFICA SE O NOME, CPF E OU RG FOI DIGITADO
            if($cad_nome == ""){
                $msg = "NECESSÁRIO INFORMAR UM NOME"; 
            }else if($cad_cpf == "" && $cad_rg == ""){
                $msg = "NECESSÁRIO INFORMAR UM DOS DOCUMENTOS (RG OU CPF)"; 
            }else{
                if ($cad_rg != ""){
                    $buscacpfrg = $cad_rg;
                }else{
                    $buscacpfrg = $cad_cpf;
                }
                //FAZ UMA BUSCA PARA VERIFICAR SE O CADASTRO JÁ EXISTE
                $pacientes_dados = new Pacientes($buscacpfrg);
                if ($pacientes_dados->getPacNome() == ""){
                    //CASO NÃO EXISTIR, IRÁ EXECUTAR ESTE BLOCO
                    $pacientes_dados->CadNovoPaciente($cad_nome, $cad_cpf, $cad_rg, $cad_nasc, $cad_prof, $cad_sexo, $cad_civil, $cad_tel, $cad_cel, $cad_mail);
                    $msg = "CADASTRADO COM SUCESSO !";
                    $ocultar = "style='display:none'";
                    $mostrar = "style='display:block'";
                }else{
                    //CASO EXISTIR IRÁ MOSTRAR ESTA MENSAGEM E EXECUTAR ESTAS AÇÕES
                    $msg = "ESTE PACIENTE JÁ ESTA CADASTRADO NESTE SISTEMA !";
                    $ocultar = "style='display:none'";
                    $mostrar = "style='display:block'";
                }
            }
        }
        
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FRC</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<script src="../js/global.js"></script>
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
            
        </aside>
        <section>
            <div class="container-fluid">
                <div id="cab">Cadastro de Pacientes</div>
                <h5 align="center"><?php echo $msg?></h5>
                <div id="dados_pessoais" <?php echo $ocultar;?>>
                    <form action="" method="post">
                        <table>
                            <tr><td colspan="2"> Dados Pessoais </td></tr>
                            <tr><td class="col_dir">Nome: </td><td class="col_esq"><input type="text" name="nome" id="nome" placeholder="NOME COMPLETO" require></td></tr>
                            <tr><td class="col_dir">CPF:</td><td class="col_esq"><input type="text" onkeypress="return onlynumber();" name="cpf" id="cpf" placeholder="CPF - SOMENTE NUMEROS"></td></tr>
                            <tr><td class="col_dir">RG:</td><td class="col_esq"><input type="text" onkeypress="return onlynumber();" name="rg" id="rg" placeholder="RG - SOMENTE NUMEROS"></td></tr>
                            <tr><td class="col_dir">Sexo: </td><td class="col_esq"> <select name="sexo" id="sexo">
                                                        <option value="F">Feminino</option>
                                                        <option value="M">Masculino</option>
                                                    </select>
                                </td>
                            </tr>
                            <tr><td class="col_dir">Data de Nascimento: </td><td class="col_esq"><input type="date" name="nasc" id="nasc"></td></tr>
                            <tr><td class="col_dir">Profissão:</td><td class="col_esq"><input type="text" name="prof" id="prof" placeholder="PROFISSÃO"></td></tr>
                            <tr><td class="col_dir">Telefone Fixo:</td><td class="col_esq"><input type="text" onkeypress="return onlynumber();" name="tel" id="tel" placeholder="DDD + SOMENTE NUMEROS"></td></tr>
                            <tr><td class="col_dir">Celular:</td><td class="col_esq"><input type="text" onkeypress="return onlynumber();" name="cel" id="cel" placeholder="DDD + 9 + SOMENTE NUMEROS"></td></tr>
                            <tr><td class="col_dir">E-Mail:</td><td class="col_esq"><input type="mail" name="mail" id="mail" placeholder="E-MAIL"></td></tr>
                            <tr><td class="col_dir">Estado Civil:</td><td class="col_esq"><select name="civil" id="civil">
                                                                <option value="">Selecione</option>
                                                                <option value="Casado(a)">Casado(a)</option>
                                                                <option value="Uniao Estavel">União Estavel</option>
                                                                <option value="Solteiro(a)">Solteiro(a)</option>
                                                                <option value="Divorciado(a)">Divorciado(a)</option>
                                                                <option value="Viuvo(a)">Viúvo(a)</option>
                                                            </select>
                                </td> 
                            </tr>
                            <tr><td colspan="2"><button type="submit" class="btn-buscar-sm">Salvar</button> </td></tr>
                        </table>
                    </form>
                </div>
                <div id="pos_cadastro" <?php echo $mostrar;?>>
                    <p><?php echo $pacientes_dados->getPacNome();?></p>
                    <p><?php 
                        if ($pacientes_dados->getPacCpf() != ""){
                            echo $pacientes_dados->getPacCpf();
                        }else {
                            echo $pacientes_dados->getPacRg();
                        }
                        ?></p>
                    <p><form action="perfil.php" method="post">
                            <input type="hidden" name="id_pac" id="id_pac" value="<?php echo $pacientes_dados->getPacId();?>">
                            <input type="submit" value="Visualizar" class="btn-visualizar-sm">
                        </form></p>
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