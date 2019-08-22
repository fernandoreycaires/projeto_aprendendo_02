<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        //TRAZ DADOS REFERENTE AOS PACIENTES
        class Pacientes{
            private $busca;
            private $id;
            private $sexo;
            private $nome;
            private $rg;
            private $cpf;
            private $cpfsemponto;
            private $idade;
            private $nasc;
            private $prof;
            private $civil;
            private $tel;
            private $cel;
            private $cel2;
            private $mail;
            private $nomepai;
            private $cpfpai;
            private $nomemae;
            private $cpfmae;
            private $cep;
            private $logradouro;
            private $numerolog;
            private $complemento;
            private $bairro;
            private $cidade;
            private $estado;

            public function __construct($busca){
                require '../php/cx.php';
                
                $this->busca = $busca;
                $mostra_sql = "SELECT id, sexo, nome, cpf, rg, nascimento FROM clientes WHERE nome = '".$this->busca."' or cpf = '".$this->busca."' or rg = '".$this->busca."' order by nome";
                $mostra = $cx->query($mostra_sql);
                while ($dados = $mostra->fetch()) {
                    $this->id = $dados['id'];
                    $this->sexo = $dados['sexo'];
                    $this->nome = $dados['nome'];
                    $this->cpf = $dados['cpf'];
                    $this->rg = $dados['rg'];
                    $this->idade= $dados['nascimento'];
                }
            }

            //BUSCA DOS DADOS DO PACIENTE USANDO EXCLUSIVAMENTE O ID
            public function setPacId($i){
                $this->id = $i;
                require '../php/cx.php';
                $mostra_sqlid = "SELECT * FROM clientes WHERE id = '".$this->id."' LIMIT 1";
                $mostraid = $cx->query($mostra_sqlid);
                while ($dadosid = $mostraid->fetch()) {
                    $this->id = $dadosid['id'];
                    $this->sexo = $dadosid['sexo'];
                    $this->nome = $dadosid['nome'];
                    $this->cpf = $dadosid['cpf'];
                    $this->rg = $dadosid['rg'];
                    $this->idade = $dadosid['nascimento'];
                    $this->prof = $dadosid['prof'];
                    $this->civil = $dadosid['estadocivil'];
                    $this->tel = $dadosid['tel'];
                    $this->cel = $dadosid['cel1'];
                    $this->cel2 = $dadosid['cel2'];
                    $this->mail = $dadosid['email'];
                    $this->nomepai = $dadosid['nome_pai'];
                    $this->cpfpai = $dadosid['cpf_pai'];
                    $this->nomemae = $dadosid['nome_mae'];
                    $this->cpfmae = $dadosid['cpf_mae'];
                    $this->cep = $dadosid['cep'];
                    $this->logradouro = $dadosid['logradouro'];
                    $this->numerolog = $dadosid['numerolog'];
                    $this->complemento = $dadosid['complemento'];
                    $this->bairro = $dadosid['bairro'];
                    $this->cidade = $dadosid['cidade'];
                    $this->estado = $dadosid['estado'];
                }
            }

            public function getPacNomeSimples(){
                return $this->nome;
            }

            public function getPacNome(){
                if ($this->nome == ""){
                    return "";
                }else{
                return "<strong>Nome: </strong>".$this->nome;
                }
            }

            public function getPacId(){
                return $this->id;
            }

            public function getPacIdadeData(){
                return $this->idade;
            }

            public function getPacIdade(){
                    if($this->idade == ""){
                        return "";
                    }else{
                        // CALCULAR A IDADE 
                        $data_nasc = $this->idade;
                        // Separa em dia, mês e ano
                        list($ano, $mes, $dia ) = explode('-', $data_nasc);
                        // Descobre que dia é hoje e retorna a unix timestamp
                        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                        // Descobre a unix timestamp da data de nascimento do fulano
                        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

                        // Depois apenas fazemos o cálculo já citado :)
                        $anosdevida = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                        return "<strong>Idade: </strong>".$anosdevida." Anos de Idade " ;
                        //FIM DO CALCULO DE IDADE
                    }
            }

            public function getPacCpfSemPonto(){
                return $this->cpf;
            }

            public function getPacCpf(){
                if($this->cpf == ""){
                    return "";
                }else{
                    $cpf1 = substr_replace($this->cpf, '.', 3, 0);
                    $cpf2 = substr_replace($cpf1, '.', 7, 0);
                    $cpf3 = substr_replace($cpf2, '-', 11, 0);
                    return "<strong>CPF: </strong>".$cpf3;
                }
                
            }
            
            public function getPacRgSemPonto(){
                return $this->rg;
            }

            public function getPacRg(){
                if($this->rg == ""){
                    return "";
                }else{
                    $rg1 = substr_replace($this->rg, '.', 2, 0);
                    $rg2 = substr_replace($rg1, '.', 6, 0);
                    $rg3 = substr_replace($rg2, '-', 10, 0);
                    return "<strong>RG: </strong>".$rg3;
                }
            }

            public function getPacTelSemPonto(){
                return $this->tel;
            }

            public function getPacTel(){
                if($this->tel == ""){
                    return "";
                }else{
                    $fixo1 = substr_replace($this->tel, '(', 0, 0);
                    $fixo2 = substr_replace($fixo1, ')', 3, 0);
                    $fixo3 = substr_replace($fixo2, '-', 8, 0);
                    $fixo = substr_replace($fixo3, ' ', 4, 0);
                    return "<strong>Telefone:</strong> ".$fixo;
                }
            }

            public function getPacCelSemPonto(){
                return $this->cel;
            }

            public function getPacCel(){
                if($this->cel == ""){
                    return "";
                }else{
                    $cel1n = substr_replace($this->cel, '(', 0, 0);
                    $cel2n = substr_replace($cel1n, ')', 3, 0);
                    $cel3n = substr_replace($cel2n, '-', 9, 0);
                    $cel4n = substr_replace($cel3n, ' ', 4, 0);
                    $celCP = substr_replace($cel4n, ' ', 6, 0);
                    return "<strong>Celular: </strong>".$celCP;
                }
            }

            public function getPacCelOptSemPonto(){
                return $this->cel2;
            }

            public function getPacCelOpt(){
                if($this->cel2 == ""){
                    return "";
                }else{
                    $cel1opt = substr_replace($this->cel2, '(', 0, 0);
                    $cel2opt = substr_replace($cel1opt, ')', 3, 0);
                    $cel3opt = substr_replace($cel2opt, '-', 9, 0);
                    $cel4opt = substr_replace($cel3opt, ' ', 4, 0);
                    $celoptCP = substr_replace($cel4opt, ' ', 6, 0);
                    return "<strong>Celular (Opt): </strong>".$celoptCP;
                }
            }

            public function getPacMailSimples(){
                return $this->mail;
            }

            public function getPacMail(){
                if($this->mail == ""){
                    return "";
                }else{
                    return "<strong>E-Mail : </strong>".$this->mail;
                }
            }

            public function getPacSexoSemModificar(){
                return $this->sexo;
            }

            public function getPacSexo(){
                if($this->sexo == "M"){
                    return "<strong>Sexo: </strong> Masculino";
                }else{
                    return "<strong>Sexo: </strong> Feminino";
                }
            }

            public function getPacCepSemPonto(){
                return $this->cep;
            }

            public function getPacCep(){
                if($this->cep == ""){
                    return "";
                }else{
                    return "<strong>Cep: </strong>".substr_replace($this->cep, '-', 5, 0);
                }
            }

            public function getPacLogradouroSimples(){
                return $this->logradouro;
            }

            public function getPacLogradouro(){
                if($this->logradouro == ""){
                    return "";
                }else{
                    return "<strong>Logradouro: </strong>".$this->logradouro;
                }
            }

            public function getPacNumeroLog(){
                if($this->numerolog == ""){
                    return "";
                }else{
                    return $this->numerolog;
                }
            }

            public function getPacComplementoSimples(){
                return $this->complemento;
            }

            public function getPacComplemento(){
                if($this->complemento == ""){
                    return "";
                }else{
                    return "<strong>Complemento: </strong>".$this->complemento;
                }
            }

            public function getPacBairroSimples(){
                return $this->bairro;
            }

            public function getPacBairro(){
                if($this->bairro == ""){
                    return "";
                }else{
                    return "<strong>Bairro: </strong>".$this->bairro;
                }
            }

            public function getPacCidadeSimples(){
                return $this->cidade;
            }

            public function getPacCidade(){
                if($this->cidade == ""){
                    return "";
                }else{
                    return "<strong>Cidade: </strong>".$this->cidade;
                }
            }

            public function getPacEstadoSimples(){
                return $this->estado;
            }

            public function getPacEstado(){
                if($this->estado == ""){
                    return "";
                }else{
                    return "<strong>Estado: </strong>".$this->estado;
                }
            }

            public function getNomePaiSimples(){
                return $this->nomepai;
            }

            public function getNomePai(){
                if($this->nomepai == ""){
                    return "Dados do pai não informado";
                }else{
                    return "<strong>Nome Pai: </strong>".$this->nomepai;
                }
                
            }

            public function getCpfPaiSemPonto(){
                return $this->cpfpai;
            }

            public function getCpfPai(){
                if ($this->cpfpai == ""){
                    return "";
                }else{
                    $cpfpai1 = substr_replace($this->cpfpai, '.', 3, 0);
                    $cpfpai2 = substr_replace($cpfpai1, '.', 7, 0);
                    $cpfpai3 = substr_replace($cpfpai2, '-', 11, 0);
                    return "<strong>Cpf Pai: </strong>".$cpfpai3;
                }
                
            }

            public function getNomeMaeSimples(){
                return $this->nomemae;
            }

            public function getNomeMae(){
                if ($this->nomemae == ""){
                    return "Dados da mãe não informado";
                }else{
                    return "<strong>Nome Mae: </strong>".$this->nomemae;
                }
            }

            public function getCpfMaeSemPonto(){
                return $this->cpfmae;
            }

            public function getCpfMae(){
                if ($this->cpfmae == ""){
                    return "";
                }else{
                    $cpfmae1 = substr_replace($this->cpfmae, '.', 3, 0);
                    $cpfmae2 = substr_replace($cpfmae1, '.', 7, 0);
                    $cpfmae3 = substr_replace($cpfmae2, '-', 11, 0);
                    return "<strong>Cpf Mae: </strong>".$cpfmae3;    
                }
            }

            public function CadNovoPaciente($cad_nome, $cad_cpf, $cad_rg, $cad_nasc, $cad_prof, $cad_sexo, $cad_civil, $cad_tel, $cad_cel, $cad_mail){
                $this->nome = $cad_nome;
                $this->cpf = isset($cad_cpf)?$cad_cpf:NULL;
                $this->rg = isset($cad_rg)?$cad_rg:NULL;
                $this->nasc = $cad_nasc;
                $this->prof = $cad_prof;
                $this->sexo = $cad_sexo;
                $this->civil = $cad_civil;
                $this->tel = $cad_tel;
                $this->cel = $cad_cel;
                $this->mail = $cad_mail;

                //ISTO AQUI É UMA GAMBIARRA, PARA MANTER O ESPAÇO EM BRANCO DO BANCO COMO null QUANDO NÃO FOR INFORMADO ALGUM DOCUMENTO
                if($this->cpf != "" && $this->rg != ""){
                    $documentosbd = "cpf, rg ";
                    $documentosrecebido = "$this->cpf ',' $this->rg";
                }else if ($this->cpf != "" && $this->rg == ""){
                    $documentosbd = "cpf";
                    $documentosrecebido = "$this->cpf";
                }else if ($this->cpf == "" && $this->rg != ""){
                    $documentosbd = "rg";
                    $documentosrecebido = "$this->rg";
                }
                
                require '../php/cx.php';
                $query_sql = "INSERT INTO clientes (nome , $documentosbd , nascimento , sexo , estadocivil , prof , cel1 , tel , email) VALUES ('".$this->nome."','$documentosrecebido','".$this->nasc."','".$this->sexo."','".$this->civil."','".$this->prof."','".$this->cel."','".$this->tel."','".$this->mail."')";
                $cx->query ($query_sql);
            }
        
            public function setPacNome($id, $PacNome){
                $this->id = $id;
                $this->nome = $PacNome;
                require '../php/cx.php';
                $up_nome_sql = "UPDATE clientes SET nome='".$this->nome."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_nome_sql);
            }
            
            public function setPacDocumentos($id, $PacRg, $PacCpf){
                $this->id = $id;
                $this->cpf = $PacCpf;
                $this->rg = $PacRg;

                //ISTO AQUI É UMA GAMBIARRA, PARA MANTER O ESPAÇO EM BRANCO DO BANCO COMO null QUANDO NÃO FOR INFORMADO ALGUM DOCUMENTO
                if($this->cpf != "" && $this->rg != ""){
                    $documentos = "cpf='".$this->cpf."', rg='".$this->rg."'";
                }else if ($this->cpf != "" && $this->rg == ""){
                    $documentos = "cpf='".$this->cpf."'";
                }else if ($this->cpf == "" && $this->rg != ""){
                    $documentos = "rg='".$this->rg."'";
                }
                require '../php/cx.php';
                $up_nome_sql = "UPDATE clientes SET $documentos WHERE id='".$this->id."' limit 1";
                $cx->query($up_nome_sql);
            }

            public function setPacTel($id, $PacTel){
                $this->id = $id;
                $this->tel = $PacTel;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET tel ='".$this->tel."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCel($id, $PacCel){
                $this->id = $id;
                $this->cel = $PacCel;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cel1 ='".$this->cel."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCelOpt($id, $PacCelOpt){
                $this->id = $id;
                $this->cel2 = $PacCelOpt;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cel2 ='".$this->cel2."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacMail($id, $PacMail){
                $this->id = $id;
                $this->mail = $PacMail;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET email ='".$this->mail."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }
            public function setPacNomePai($id, $PacPai){
                $this->id = $id;
                $this->nomepai = $PacPai;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET nome_pai ='".$this->nomepai."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCpfPai($id, $PacCpfPai){
                $this->id = $id;
                $this->cpfpai = $PacCpfPai;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cpf_pai ='".$this->cpfpai."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacNomeMae($id, $PacMae){
                $this->id = $id;
                $this->nomemae = $PacMae;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET nome_mae ='".$this->nomemae."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCpfMae($id, $PacCpfMae){
                $this->id = $id;
                $this->cpfmae = $PacCpfMae;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cpf_mae ='".$this->cpfmae."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCep($id, $PacCep){
                $this->id = $id;
                $this->cep = $PacCep;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cep ='".$this->cep."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacLogradouro($id, $PacLogradouro){
                $this->id = $id;
                $this->logradouro = $PacLogradouro;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET logradouro ='".$this->logradouro."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacNumLogradouro($id, $PacNumLogradouro){
                $this->id = $id;
                $this->numerolog = $PacNumLogradouro;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET numerolog ='".$this->numerolog."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacComplemento($id, $PacComplemento){
                $this->id = $id;
                $this->complemento = $PacComplemento;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET complemento ='".$this->complemento."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacBairro($id, $PacBairro){
                $this->id = $id;
                $this->bairro = $PacBairro;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET bairro ='".$this->bairro."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacCidade($id, $PacCidade){
                $this->id = $id;
                $this->cidade = $PacCidade;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET cidade ='".$this->cidade."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }

            public function setPacEstado($id, $PacEstado){
                $this->id = $id;
                $this->estado = $PacEstado;
                require '../php/cx.php';
                $up_sql = "UPDATE clientes SET estado ='".$this->estado."' WHERE id='".$this->id."' limit 1";
                $cx->query($up_sql);
            }
        }

        class Convenio{
            private $idconv;
            private $id_cli;
            private $empresa;
            private $tipo;
            private $num_cart;
            private $queryconv;

            public function ListaConv($i){
                $this->id_cli = $i;
                require '../php/cx.php';
                $mostra_sqlid = "SELECT * FROM convenio WHERE id_cli = '".$this->id_cli."'";
                return $this->queryconv = $cx->query($mostra_sqlid);
            }

            public function AddConvenio($id_cli, $empresa, $tipo, $num_cart){
                $this->id_cli = $id_cli;
                $this->empresa = $empresa;
                $this->tipo = $tipo;
                $this->num_cart = $num_cart;
                require '../php/cx.php';
                $query_sql_conv = "INSERT INTO convenio (id_cli, empresa, tipo, num_cart) VALUES ('".$this->id_cli."', '".$this->empresa."', '".$this->tipo."', '".$this->num_cart."')";
                $cx->query($query_sql_conv);
            }

            public function DelConvenio($id_conv){
                $this->idconv = $id_conv;
                require '../php/cx.php';
                $query_sql_del_conv = "DELETE FROM convenio WHERE id_conv = '".$this->idconv."' limit 1 ";
                $cx->query($query_sql_del_conv);
            }

            public function getIdConv(){
                return $this->idconv;
            }

            public function getConvEmpresa(){
                return $this->empresa;
            }

            public function getConvTipo(){
                return $this->num_cart;
            }
        }

        class ListaAgendaPaciente{
            private $buscalista;
            private $data_ini;
            private $doutor;
            private $lista_agenda;

            public function Lista(){
                require '../php/cx.php';
                $mostraagenda = "SELECT * FROM agenda WHERE cpf = '".$this->buscalista."' AND cnpj = '".$_SESSION['cnpj_session']."' ORDER BY id_data DESC";
                if ($this->lista_agenda = ''){
                    return "";
                }else{
                    return $this->lista_agenda = $cx->query($mostraagenda);
                }
            }

            public function setBusca($bl){
                if ($bl == ""){
                    $this->buscalista = "-1";    
                }else{
                    $this->buscalista = $bl;
                }
            }

        }

        

        class ListaCheckinsPaciente{
            private $buscachecklist;
            private $ini_data;
            private $doutor;

            public function ListaCheckins(){
                require '../php/cx.php';
                $sql_atendimento = "SELECT * FROM atendimento WHERE cnpj = '".$_SESSION['cnpj_session']."' AND cpf = '".$this->buscachecklist."' OR cnpj = '".$_SESSION['cnpj_session']."' AND  rg = '".$this->buscachecklist."' ORDER BY id_atend DESC ";
                if ($this->lista_checkin = ""){
                    return "";
                }else{
                    return $this->lista_checkin = $cx->query($sql_atendimento);
                }
            }

            public function setBuscaCheckLista($bc){
                if ($bc == ""){
                    $this->buscachecklist = "-1";
                }else{
                    $this->buscachecklist = $bc;
                }
            }
        }
        

    }else{
        header("location:../../../public/index.php");
    }