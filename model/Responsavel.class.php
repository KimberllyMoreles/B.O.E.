<?php

class Responsavel{
    
    private $id_responsavel;
    private $nome;
    private $cpf;
    private $email;
    private $telefone1;
    private $telefone2;
    private $telefone3;
       
    public function __get($key){
        return $this->$key;
    }
     
    public function __set($key, $value){
        $this->$key = $value;
    }
}
