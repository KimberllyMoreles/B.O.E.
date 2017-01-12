<?php

class Aluno_Ocorrencia {
	private $id_aluno_ocorrencia;
	private $id_ocorrencia;
	private $id_aluno;
    
    //método de captura de valores para o objeto
    public function __get($key){
        return $this->$key;
    }
    
    //método de retorno de valores do objeto
    public function __set($key, $value){
        $this->$key = $value;
    }
}
