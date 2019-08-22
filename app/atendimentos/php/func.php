<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){

        class Atendimentos{
            private $id_atend;
            private $nome;
            private $id_pac;
            private $convenio;
            private $crm;
            private $doutor;
            private $cnpj;
            private $retorno;
            private $ini_data;
            private $ini_hora;
            private $fim_data;
            private $fim_hora;
            private $obs;

            private $lista_atend;

            public function GeraListaAtend($busca_data){
                $this->ini_data = $busca_data;
                require '../php/cx.php';
                $sql_busca = "SELECT * FROM atendimento WHERE ini_data = '".$this->ini_data."' AND cnpj = '".$_SESSION['cnpj_session']."'";
                return $this->lista_atend = $cx->query($sql_busca);
            }

            public function getIniData(){
                return $this->ini_data;
            }

            public function getCnpj(){
                return $this->cnpj;
            }

        }

    }else{
        header("location:../../../public/index.php");
    }
