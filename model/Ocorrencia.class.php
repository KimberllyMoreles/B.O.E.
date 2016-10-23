<?php

class Ocorrencia {
	private $id_ocorrencia;
	private $id_aluno;
	private $id_solicitante;
	private $id_autuador;
	private $data_cadastro;
	private $id_tipo_ocorrencia;
    
    //método de captura de valores para o objeto
    public function __get($key){
        return $this->$key;
    }
    
    //método de retorno de valores do objeto
    public function __set($key, $value){
        $this->$key = $value;
    }
}
