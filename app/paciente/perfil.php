<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
        require '../php/global.php';
        require 'php/func.php';

        if ($_POST){
            $id = $_POST['id_pac'];
            $pacientes_dados = new Pacientes(0);
            $pacientes_dados->setPacId($id);
            $paclogradouro = $pacientes_dados->getPacLogradouroSimples();
            
            $pacientes_convenio = new Convenio();

            $buscandoendereco = new BuscaEndereco();
            $buscandoendereco->BuscaCep($_POST['PacCepBusca']);
            
            $paclogradouro = isset($_POST['PacCepBusca'])?$buscandoendereco->getLogradouro():$pacientes_dados->getPacLogradouroSimples();
            $numerolog = isset($_POST['PacCepBusca'])?"":$pacientes_dados->getPacNumeroLog();
            $complemento = isset($_POST['PacCepBusca'])?"":$pacientes_dados->getPacComplementoSimples();
            $pacbairro = isset($_POST['PacCepBusca'])?$buscandoendereco->getBairro():$pacientes_dados->getPacBairroSimples();
            $paccidade = isset($_POST['PacCepBusca'])?$buscandoendereco->getCidade():$pacientes_dados->getPacCidadeSimples();
            $pacuf = isset($_POST['PacCepBusca'])?$buscandoendereco->getEstado():$pacientes_dados->getPacEstadoSimples();
            $paccep = isset($_POST['PacCepBusca'])?$_POST['PacCepBusca']:$pacientes_dados->getPacCepSemPonto();
        }

        /* 
        *****************************************
        HABILITAR E DESBILITAR EDIÇÃO DOS CARDS
        *****************************************
        */

        //CARTÃO DADOS PESSOAIS
        $mostrar_d_p = isset($_POST['mostrarDadosPessoal'])?$_POST['mostrarDadosPessoal']:"style='display:none'";
        $ocultar_d_p = isset($_POST['ocDadosPessoal'])?$_POST['ocDadosPessoal']:"";
        //CARTÃO DADOS CONTATO
        $mostrar_cont = isset($_POST['mostrarContato'])?$_POST['mostrarContato']:"style='display:none'";
        $ocultar_cont = isset($_POST['ocContato'])?$_POST['ocContato']:"";
        //CARTÃO DADOS ENDEREÇO
        $mostrar_end = isset($_POST['mostrarEndereco'])?$_POST['mostrarEndereco']:"style='display:none'";
        $ocultar_end = isset($_POST['ocEndereco'])?$_POST['ocEndereco']:"";
        //CARTÃO DADOS RESPONSAVEIS
        $mostrar_resp = isset($_POST['mostrarResp'])?$_POST['mostrarResp']:"style='display:none'";
        $ocultar_resp = isset($_POST['ocResp'])?$_POST['ocResp']:"";
        //CARTÃO DADOS CONVENIOS
        $mostrar_conv = isset($_POST['mostrarConv'])?$_POST['mostrarConv']:"style='display:none'";
        $ocultar_conv = isset($_POST['ocConv'])?$_POST['ocConv']:"";

        /* 
        ********************************************
        FIM HABILITAR E DESBILITAR EDIÇÃO DOS CARDS
        ********************************************
        */

        //EDIÇÃO DO NOME
        $PacNome = isset($_POST['pacNome'])?$_POST['pacNome']:NULL;
        isset($_POST['pacNome'])?$pacientes_dados->setPacNome($id, $PacNome):"";
        
        //EDIÇÃO DOS DOCUMENTOS
        $PacCpf = isset($_POST['pacCpf'])?$_POST['pacCpf']:NULL;
        $PacRg = isset($_POST['pacRg'])?$_POST['pacRg']:NULL;
        isset($_POST['pacCpf'])?$pacientes_dados->setPacDocumentos($id, $PacRg, $PacCpf):"";
        
        //EDIÇÃO DOS DADOS PARA CONTATO
        $PacTel = isset($_POST['pacTel'])?$_POST['pacTel']:NULL;
        isset($_POST['pacTel'])?$pacientes_dados->setPacTel($id, $PacTel):"";

        $PacCel = isset($_POST['pacCel'])?$_POST['pacCel']:NULL;
        isset($_POST['pacTel'])?$pacientes_dados->setPacCel($id, $PacCel):"";

        $PacCelOpt = isset($_POST['pacCelOpt'])?$_POST['pacCelOpt']:NULL;
        isset($_POST['pacTel'])?$pacientes_dados->setPacCelOpt($id, $PacCelOpt):"";

        $PacMail = isset($_POST['pacMail'])?$_POST['pacMail']:NULL;
        isset($_POST['pacTel'])?$pacientes_dados->setPacMail($id, $PacMail):"";
        
        //EDIÇÃO DOS DADOS DO ENDEREÇO
        $PacCepEdit = isset($_POST['PacCep'])?$_POST['PacCep']:NULL;
        isset($_POST['PacCep'])?$pacientes_dados->setPacCep($id, $PacCepEdit):"";

        $PacLogEdit = isset($_POST['PacLog'])?$_POST['PacLog']:NULL;
        isset($_POST['PacLog'])?$pacientes_dados->setPacLogradouro($id, $PacLogEdit):"";

        $PacNumLogEdit = isset($_POST['PacNumLog'])?$_POST['PacNumLog']:NULL;
        isset($_POST['PacNumLog'])?$pacientes_dados->setPacNumLogradouro($id, $PacNumLogEdit):"";

        $PacComplementoEdit = isset($_POST['PacComp'])?$_POST['PacComp']:NULL;
        isset($_POST['PacComp'])?$pacientes_dados->setPacComplemento($id, $PacComplementoEdit):"";

        $PacBairroEdit = isset($_POST['PacBai'])?$_POST['PacBai']:NULL;
        isset($_POST['PacBai'])?$pacientes_dados->setPacBairro($id, $PacBairroEdit):"";

        $PacCidadeEdit = isset($_POST['PacCidade'])?$_POST['PacCidade']:NULL;
        isset($_POST['PacCidade'])?$pacientes_dados->setPacCidade($id, $PacCidadeEdit):"";

        $PacEstadoEdit = isset($_POST['PacUf'])?$_POST['PacUf']:NULL;
        isset($_POST['PacUf'])?$pacientes_dados->setPacEstado($id, $PacEstadoEdit):"";


        //EDIÇÃO DOS DADOS DOS RESPONSAVEIS
        $PacPai = isset($_POST['pacNomePai'])?$_POST['pacNomePai']:NULL;
        isset($_POST['pacNomePai'])?$pacientes_dados->setPacNomePai($id, $PacPai):"";

        $PacCpfPai = isset($_POST['pacCpfPai'])?$_POST['pacCpfPai']:NULL;
        isset($_POST['pacCpfPai'])?$pacientes_dados->setPacCpfPai($id, $PacCpfPai):"";

        $PacMae = isset($_POST['pacNomeMae'])?$_POST['pacNomeMae']:NULL;
        isset($_POST['pacNomeMae'])?$pacientes_dados->setPacNomeMae($id, $PacMae):"";

        $PacCpfMae = isset($_POST['pacCpfMae'])?$_POST['pacCpfMae']:NULL;
        isset($_POST['pacCpfMae'])?$pacientes_dados->setPacCpfMae($id, $PacCpfMae):"";
        

        //EDIÇÃO DA DATA DE NASCIMENTO
        $PacIdade = isset($_POST['pacIdade'])?$_POST['pacIdade']:NULL;
        $PacSexo = isset($_POST['pacSexo'])?$_POST['pacSexo']:NULL;

        

        //ADICIONAR CONVENIO
        $convEmpresa = isset($_POST['ConvEmpresa'])?$_POST['ConvEmpresa']:NULL; 
        $convTipo = isset($_POST['ConvTipo'])?$_POST['ConvTipo']:NULL; 
        $convNumCart = isset($_POST['ConvNumCart'])?$_POST['ConvNumCart']:NULL;
        if($convNumCart != "" && $convEmpresa != ""){
            $pacientes_convenio->AddConvenio($id, $convEmpresa, $convTipo, $convNumCart);
        }
        //DELETAR CONVENIO
        $convIdDel = isset($_POST['del_id_conv'])?$_POST['del_id_conv']:NULL;
        if ($convIdDel != ""){
            $pacientes_convenio->DelConvenio($convIdDel);
        }
        


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
                <div id="cab">Dados do Pacientes</div>
                <h5 align="center"><?php echo $msg?></h5>
                <div id="cards">
                    <!-- DADOS PESSOAIS -->
                    <div id="dados" class = "perfil" <?php echo $ocultar_d_p;?>>
                        <h5>Dados Pessoais </h5>
                        <p><?php echo $pacientes_dados->getPacNome();?></p>
                        <p><?php echo $pacientes_dados->getPacCpf();?></p>
                        <p><?php echo $pacientes_dados->getPacRg();?></p>
                        <p><?php echo $pacientes_dados->getPacIdade();?></p>
                        <p><?php echo $pacientes_dados->getPacSexo();?></p>
                        <form action="" method="post">
                            <input type="hidden" name="ocDadosPessoal" value="style='display:none'">
                            <input type="hidden" name="mostrarDadosPessoal" value="">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="submit" value="Editar" id="editar_perfil" class="btn-visualizar-sm">
                        </form>
                    </div>
                    <div id="dados_edit" class="perfil" <?php echo $mostrar_d_p;?>>
                        <h5>Dados Pessoais </h5>
                        <form action="" method="post">
                            <p><input type="text" name="pacNome" id="pacNome" value="<?php echo $pacientes_dados->getPacNomeSimples();?>" placeholder="NOME COMPLETO"></p>
                            <p><input type="text" name="pacCpf" id="pacCpf" value="<?php echo $pacientes_dados->getPacCpfSemPonto();?>" onkeypress="return onlynumber();" placeholder="CPF - SOMENTE NUMEROS"></p>
                            <p><input type="text" name="pacRg" id="pacRg" value="<?php echo $pacientes_dados->getPacRgSemPonto();?>" onkeypress="return onlynumber();" placeholder="RG - SOMENTE NUMEROS"></p>
                            <p><input type="date" name="pacNasc" id="pacNasc" value="<?php echo $pacientes_dados->getPacIdadeData();?>"></p>
                            <p><select name="pacSexo" id="pacSexo">
                                <option value="<?php echo $pacientes_dados->getPacSexoSemModificar();?>"><?php echo $pacientes_dados->getPacSexo();?></option>
                                <option value="F">Feminino</option>
                                <option value="M">Masculino</option>
                            </select> </p>
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <button type="submit" id="editar_perfil" class="btn-visualizar-sm">Salvar</button>
                        </form>
                    </div>
                    <!-- CONTATO  -->
                    <div id="contato" class = "perfil" <?php echo $ocultar_cont;?>>
                        <h5>Contato</h5>
                        <p><?php echo $pacientes_dados->getPacTel();?></p>
                        <p><?php echo $pacientes_dados->getPacCel();?></p>
                        <p><?php echo $pacientes_dados->getPacCelOpt();?></p>
                        <p><?php echo $pacientes_dados->getPacMail();?></p>
                        <form action="" method="post">
                            <input type="hidden" name="ocContato" value="style='display:none'">
                            <input type="hidden" name="mostrarContato" value="">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="submit" value="Editar" id="editar_perfil" class="btn-visualizar-sm">
                        </form>
                    </div>
                    <div id="dados_edit" class = "perfil" <?php echo $mostrar_cont;?>>
                        <h5>Contato</h5>
                        <form action="" method="post">
                            <p><input type="text" name="pacTel" id="" value="<?php echo $pacientes_dados->getPacTelSemPonto();?>" onkeypress="return onlynumber();" placeholder="DDD + TELEFONE FIXO - APENAS NUMEROS"></p>
                            <p><input type="text" name="pacCel" id="" value="<?php echo $pacientes_dados->getPacCelSemPonto();?>" onkeypress="return onlynumber();" placeholder="DDD + 9 + CELULAR - APENAS NUMEROS"></p>
                            <p><input type="text" name="pacCelOpt" id="" value="<?php echo $pacientes_dados->getPacCelOptSemPonto();?>" onkeypress="return onlynumber();" placeholder="DDD + 9 + CELULAR - APENAS NUMEROS"></p>
                            <p><input type="text" name="pacMail" id="" value="<?php echo $pacientes_dados->getPacMailSimples();?>"></p>
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <button type="submit" id="editar_perfil" class="btn-visualizar-sm">Salvar</button>
                        </form>
                    </div>
                    <!-- ENDEREÇO  -->
                    <div id=endereco class = "perfil" <?php echo $ocultar_end;?>>
                        <h5>Endereço</h5>
                        <p><?php echo $pacientes_dados->getPacCep();?></p>
                        <p><?php echo "{$pacientes_dados->getPacLogradouro()} {$pacientes_dados->getPacNumeroLog()}";?></p>
                        <p><?php echo $pacientes_dados->getPacComplemento();?></p>
                        <p><?php echo $pacientes_dados->getPacBairro();?></p>
                        <p><?php echo $pacientes_dados->getPacCidade();?></p>
                        <p><?php echo $pacientes_dados->getPacEstado();?></p>
                        <form action="" method="post">
                            <input type="hidden" name="ocEndereco" value="style='display:none'">
                            <input type="hidden" name="mostrarEndereco" value="">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="submit" value="Editar" id="editar_perfil" class="btn-visualizar-sm">
                        </form>
                    </div>
                    <div id="dados_edit" class = "perfil" <?php echo $mostrar_end;?>>
                        <h5>Endereço</h5>
                        <form action="" method="post">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="hidden" name="ocEndereco" value="style='display:none'">
                            <input type="hidden" name="mostrarEndereco" value="">
                            <p><input type="text" name="PacCepBusca" id="" value="<?php echo $paccep;?>" onkeypress="return onlynumber();" placeholder="CEP - APENAS NUMEROS">&nbsp;<button type="submit" class="btn-buscar-sm">Buscar</button></p>
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="PacCep" value="<?php echo $paccep;?>">
                            <p><input type="text" name="PacLog" id="" value="<?php echo $paclogradouro;?>" placeholder="NOME DA RUA OU AVENIDA SEM O NUMERO"></p>
                            <p><input type="text" name="PacNumLog" id="" value="<?php echo $numerolog;?>" placeholder="NÚMERO"></p>
                            <p><input type="text" name="PacComp" id="" value="<?php echo $complemento;?>" placeholder="COMPLEMENTO (OPCIONAL)"></p>
                            <p><input type="text" name="PacBai" id="" value="<?php echo $pacbairro;?>" placeholder="BAIRRO"></p>
                            <p><input type="text" name="PacCidade" id="" value="<?php echo $paccidade;?>" placeholder="CIDADE"></p>
                            <p> <select name="PacUf" id="">
                                    <option><?php echo $pacuf;?></option>
                                    <option>AC</option>
                                    <option>AL</option>
                                    <option>AP</option>
                                    <option>AM</option>
                                    <option>BA</option>
                                    <option>CE</option>
                                    <option>DF</option>
                                    <option>ES</option>
                                    <option>GO</option>
                                    <option>MA</option>
                                    <option>MT</option>
                                    <option>MS</option>
                                    <option>MG</option>
                                    <option>PA</option>
                                    <option>PB</option>
                                    <option>PR</option>
                                    <option>PE</option>
                                    <option>PI</option>
                                    <option>RJ</option>
                                    <option>RN</option>
                                    <option>RS</option>
                                    <option>RO</option>
                                    <option>RR</option>
                                    <option>SC</option>
                                    <option>SP</option>
                                    <option>SE</option>
                                    <option>TO</option>
                                </select>
                            </p>
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <button type="submit" id="editar_perfil" class="btn-visualizar-sm">Salvar</button>
                        </form>
                    </div>
                    <!-- RESPONSAVEL  -->
                    <div id="responsavel" class = "perfil" <?php echo $ocultar_resp;?>>
                        <h5>Responsáveis</h5>
                        <p><?php echo $pacientes_dados->getNomePai();?></p>
                        <p><?php echo $pacientes_dados->getCpfPai();?></p>
                        <p><?php echo $pacientes_dados->getNomeMae();?></p>
                        <p><?php echo $pacientes_dados->getCpfMae();?></p>
                        <form action="" method="post">
                            <input type="hidden" name="ocResp" value="style='display:none'">
                            <input type="hidden" name="mostrarResp" value="">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="submit" value="Editar" id="editar_perfil" class="btn-visualizar-sm">
                        </form>
                    </div>
                    <div id="dados_edit" class = "perfil" <?php echo $mostrar_resp;?>>
                        <h5>Responsáveis</h5>
                        <form action="" method="post">
                            <p><input type="text" name="pacNomePai" value="<?php echo $pacientes_dados->getNomePaiSimples();?>" placeholder="NOME DO PAI"></p>
                            <p><input type="text" name="pacCpfPai" value="<?php echo $pacientes_dados->getCpfPaiSemPonto();?>" placeholder="CPF DO PAI" onkeypress="return onlynumber();"></p>
                            <p><input type="text" name="pacNomeMae" value="<?php echo $pacientes_dados->getNomeMaeSimples();?>" placeholder="NOME DA MÃE"></p>
                            <p><input type="text" name="pacCpfMae" value="<?php echo $pacientes_dados->getCpfMaeSemPonto();?>" placeholder="CPF DA MÃE" onkeypress="return onlynumber();"></p>
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <button type="submit" class="btn-visualizar-sm">Salvar</button>
                        </form>
                    </div>
                    <!-- CONVENIOS -->
                    <div id="convenio" class = "perfil" <?php echo $ocultar_conv;?>>
                        <h5>Convênio</h5>
                        <table>
                            <tr>
                                <td><strong>Empresa</strong></td>
                                <td><strong>Carteirinha</strong></td>
                                <td><strong>Ação</strong></td>
                            </tr>
                                <?php 
                                    //ENVIA ID PARA O OBJETO CONVENIO  
                                    $queryconv = $pacientes_convenio->ListaConv($id);

                                    while ($dadosid = $queryconv->fetch()) {
                                        $idconv = $dadosid['id_conv'];
                                        $id_cli = $dadosid['id_cli'];
                                        $empresa = $dadosid['empresa'];
                                        $tipo = $dadosid['tipo'];
                                        $num_cart = $dadosid['num_cart'];
                                ?>
                            <form action="" method="post">
                                <tr>
                                    <input type="hidden" name="del_id_conv" value="<?php echo $idconv; //ENVIA ID PARA DELETAR O CONVENIO LISTADO ?>">
                                    <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                                    <td class='col_esq'><?php echo $empresa;?></td>
                                    <td class='col_esq'><?php echo $num_cart;?></td>
                                    <td style="text-align:center"><input type="submit" value="Remover" class="btn-vermelho-sm"></td>
                                </tr>
                            </form>                  
                                <?php 
                                    }
                                ?>
                        </table>
                        <form action="" method="post">
                            <input type="hidden" name="ocConv" value="style='display:none'">
                            <input type="hidden" name="mostrarConv" value="">
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <input type="submit" value="Adicionar" id="editar_perfil" class="btn-visualizar-sm">
                        </form>
                    </div>
                    <div id="dados_edit" class = "perfil" <?php echo $mostrar_conv;?>>
                        <h5>Convênio</h5>
                        <form action="" method="post">
                            <p><input type="text" name="ConvEmpresa" id="" value="<?php echo $pacientes_dados->getNomePaiSimples();?>" placeholder="EMPRESA (Obrigatório)"></p>
                            <p><input type="text" name="ConvTipo" id="" value="<?php echo $pacientes_dados->getCpfPaiSemPonto();?>" placeholder="TIPO DO CONTRATO"></p>
                            <p><input type="text" name="ConvNumCart" id="" value="<?php echo $pacientes_dados->getNomeMaeSimples();?>" placeholder="NUMERO CARTEIRINHA (Obrigatório)"></p>
                            <input type="hidden" name="id_pac" value="<?php echo $id;?>">
                            <button type="submit" class="btn-visualizar-sm">Salvar</button>
                        </form>
                    </div>
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