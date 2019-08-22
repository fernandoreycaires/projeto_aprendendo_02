<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        //BUSCA DADOS DO USUARIO DA SESSÃO ATUAL
        class Usuario{
            //ATRIBUTOS DO OBJETO
            private $id;
            private $nome;
            private $usuario;
            private $cpf;
            private $cnpj;
            private $crm;
            private $estado_crm;
            private $cor;
            private $referencia;
            private $cli;
            private $dtr;
            private $cal;
            private $con;
            private $dp;
            private $adm;
            private $fin;
            private $com;
            private $sys;
            private $atend;
            private $caixa;
            private $mai;

            //MÉTODOS DO OBJETO (O MÉTODO CONSTRUTOR PODE SER FEITO COM O PROPRIO NOME DA CLASSE TAMBEM)
            public function __construct(){
                require_once 'cx.php';
                $acesso = "SELECT * FROM cnpj_user WHERE cnpj_vinc = '".$_SESSION['cnpj_session']."' AND pass='".$_SESSION['pass_session']."' AND usuario='".$_SESSION['user_session']."'";
                $acesso_user = $cx->query ($acesso);

                while ($perfil = $acesso_user->fetch()){
                    $this->id = $perfil['id_u_cnpj'];
                    $this->nome = $perfil['nome_u'];
                    $this->usuario = $perfil['usuario'];
                    $this->cpf = $perfil['cpf_vinc'];
                    $this->cnpj = $perfil['cnpj_vinc'];
                    $this->crm = $perfil['crm'];
                    $this->estado_crm = $perfil['estado_crm'];
                    $this->cor = $perfil['cor'];
                    $this->referencia = $perfil['referencia'];
                    $this->cli = $perfil['cli'];
                    $this->dtr = $perfil['dtr'];
                    $this->cal = $perfil['cal'];
                    $this->con = $perfil['con'];
                    $this->dp = $perfil['dp'];
                    $this->adm = $perfil['adm'];
                    $this->fin = $perfil['fin'];
                    $this->com = $perfil['com'];
                    $this->sys = $perfil['sys'];
                    $this->atend = $perfil['atend'];
                    $this->caixa = $perfil['caixa'];
                    $this->mai = $perfil['mai'];
                }
            }

            public function getNome(){
                return $this->nome;
            }

            public function getCrm(){
                return $this->crm;
            }

            public function getCnpj(){
                $cnpj1 = substr_replace($this->cnpj, '.', 2, 0);
                $cnpj2 = substr_replace($cnpj1, '.', 6, 0);
                $cnpj3 = substr_replace($cnpj2, '/', 10, 0);
                return $cnpj4 = substr_replace($cnpj3, '-', 15, 0);
            }

            public function getCnpjSemPonto(){
                return $this->cnpj;
            }

        }
        $obj_usuario = new Usuario();

        //BUSCA DADOS DA EMPRESA QUE ESTA LOGANDO
        class Empresa{
            private $cnpj;
            private $razao;
            private $n_fantasia;

            public function __construct($cnpj){
                require 'cx.php';
                $this->cnpj = $cnpj;
                $sql_cnpj = "SELECT * FROM cnpj WHERE cnpj_c = '".$this->cnpj."'";
                $cnpj_query = $cx->query($sql_cnpj);
                while($cnpj_busca = $cnpj_query->fetch()){
                    $this->razao = $cnpj_busca['razao_c'];
                    $this->n_fantasia = $cnpj_busca['nfantazia_c'];
                }
            }

            public function getRazao(){
                return $this->razao;
            }

            public function getFantasia(){
                return $this->n_fantasia;
            }
        }
        $obj_empresa = new Empresa($_SESSION['cnpj_session']);


        //BUSCA QUANTIDADE DE AGENDAMENTOS DO DOUTOR NO DIA DA SESSÃO ATUAL
        class QtdAgendados{
            
            private $qtdagenda;
            private $crmm;
            
            public function QtdAgendadoGeral(){
                require 'cx.php';
                $data_atual = date('Y-m-d');
                $agenda = "SELECT COUNT(*) FROM agenda WHERE cnpj = '".$_SESSION['cnpj_session']."' AND inicio LIKE '".$data_atual."%' GROUP BY inicio LIKE '".$data_atual."%'";
                $recebe_sql = $cx->query ($agenda);
                while ($agendamento = $recebe_sql->fetch()){
                    $this->qtdagenda = $agendamento['COUNT(*)'];
                }
                if ($this->qtdagenda == ''){
                    return $this->qtdagenda = "0";
                } else {
                    return $this->qtdagenda;
                }
            }

            public function QtdAgendadoDtr(){
                require 'cx.php';
                $data_atual = date('Y-m-d');
                $agenda = "SELECT COUNT(*) FROM agenda WHERE cnpj = '".$_SESSION['cnpj_session']."' AND crm = '".$this->crmm."' AND inicio LIKE '".$data_atual."%' GROUP BY inicio LIKE '".$data_atual."%'";
                $recebe_sql = $cx->query($agenda);
                while ($agendamento = $recebe_sql->fetch()){
                    $this->qtdagenda = $agendamento['COUNT(*)'];
                }
                if ($this->qtdagenda == ''){
                    return $this->qtdagenda = "0";
                } else {
                    return $this->qtdagenda;
                }
            }
            
            public function setCrmm($c){
                $this->crmm = $c;
            }
            
        }
        $obj_dtrqtdagendado = new QtdAgendados();
        $obj_dtrqtdagendado->setCrmm("{$obj_usuario->getCrm()}");

        //OBJETO QUE BUSCA SOMENTE QUANTIDADE DE ATENDIMENTOS
        class QtdAtendimentos{

            private $qtdcheckinsg;
            private $qtdcheckoutsg;
            private $qtdcheckinsdtr;
            private $qtdcheckoutsdtr;
            private $cnpj;
            private $crm;
            private $doutor;

            public function ContadorCheckinGeral(){
                require 'cx.php';
                $data_atual = date('Y-m-d');
                $sql_contadorchecking = "SELECT COUNT(*) FROM atendimento WHERE cnpj = '".$_SESSION['cnpj_session']."' AND ini_data LIKE '".$data_atual."' GROUP BY ini_data LIKE '".$data_atual."'";
                $query_contadorchecking = $cx->query($sql_contadorchecking);
                while($qtdcheckg = $query_contadorchecking->fetch()){
                    $this->qtdcheckinsg = $qtdcheckg['COUNT(*)'];
                }
                if ($this->qtdcheckinsg == ""){
                    return $this->qtdcheckinsg = "0";
                }else{
                    return $this->qtdcheckinsg;
                }
            }

            public function ContadorCheckinDoc(){
                require 'cx.php';
                $data_atual = date('Y-m-d');
                $sql_contadorcheckind = "SELECT COUNT(*) FROM atendimento WHERE cnpj = '".$_SESSION['cnpj_session']."' AND crm = '".$this->crm."' AND ini_data LIKE '".$data_atual."' GROUP BY ini_data LIKE '".$data_atual."'";
                $query_contadorcheckind = $cx->query($sql_contadorcheckind);
                while($qtdcheckd = $query_contadorcheckind->fetch()){
                    $this->qtdcheckinsdtr = $qtdcheckd['COUNT(*)'];
                }
                if ($this->qtdcheckinsdtr == ""){
                    return $this->qtdcheckinsdtr = "0";
                }else{
                    return $this->qtdcheckinsdtr;
                }
            }
            
            public function setCrm($crm){
                $this->crm = $crm;
            }
        }
        $obj_atend = new QtdAtendimentos;
        $obj_atend->setCrm("{$obj_usuario->getCrm()}");

        //OBJETO LEADS
        class Leads{
            
            private $qtdlead;

            public function getQtdLeadsAtivos(){
                require 'cx.php';
                $leads = "SELECT COUNT(*) FROM `lead` WHERE cnpj = '".$_SESSION['cnpj_session']."' AND interesse = 'S' GROUP BY interesse = 'S'";
                $leads_sql = $cx->query ($leads);
                while ($leads_ativo = $leads_sql->fetch()){
                    $this->qtdlead = $leads_ativo['COUNT(*)'];
                }
                if ($this->qtdlead == ''){
                    return $this->qtdlead = "0";
                }else{
                    return $this->qtdlead;
                }
            }

            public function getQtdLeadSemInteresse(){
                require 'cx.php';
                $leadn = "SELECT COUNT(*) FROM `lead` WHERE cnpj = '".$_SESSION['cnpj_session']."' AND interesse = 'N' GROUP BY interesse = 'N'";
                $leadn_sql = $cx->query ($leadn);
                while ($leadn_s_int = $leadn_sql->fetch()){
                    $this->qtdlead = $leadn_s_int['COUNT(*)'];
                }
                if ($this->qtdlead == ''){
                    return $this->qtdlead = "0";
                }else{
                    return $this->qtdlead;
                }
            }

        }
        $obj_lead = new Leads();

        class BuscaEndereco{
            private $cep;
            private $logradouro;
            private $bairro;
            private $cidade;
            private $estado;

            private $retorno;

            //FUNÇÃO BUSCA CEP
            public function buscaCep($cep){
                $this->cep = $cep;
                global $retorno;
                $resultado = @file_get_contents("http://republicavirtual.com.br/web_cep.php?cep=".$this->cep."&formato=query_string");
                $resultado = urldecode($resultado);
                $resultado = utf8_encode($resultado);
        
                $resultado = parse_str($resultado,$this->retorno);
                return $this->retorno;
            }

            public function getCep(){
                return $this->cep;
            }

            public function getLogradouro(){
                return $this->logradouro = $this->retorno['tipo_logradouro']." ".$this->retorno['logradouro'];
            }

            public function getBairro(){
                return $this->bairro = $this->retorno['bairro'];
            }

            public function getCidade(){
                return $this->cidade = $this->retorno['cidade'];
            }

            public function getEstado(){
                return $this->estado = $this->retorno['uf'];
            }
            
        }
        


}else{
    header("location:../public/index.php");
}



    