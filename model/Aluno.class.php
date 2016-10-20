<?php

class Aluno {
    private $id_aluno;
    private $cpf;
    private $nome;
    private $matricula;
    private $status;
    private $curso;
    private $responsavel1;
    private $responsavel2;
    private $data_nasc;
    
    //método de captura de valores para o objeto
    public function __get($key){
        return $this->$key;
    }
    
    //método de retorno de valores do objeto
    public function __set($key, $value){
        $this->$key = $value;
    }
}
