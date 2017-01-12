<?php

class Servidor{
    
    private $id_servidor;
    private $nome;
    private $cpf;
    private $siape;
    private $id_categoria;
    private $senha;
    private $status;
       
    public function __get($key){
        return $this->$key;
    }
     
    public function __set($key, $value){
        $this->$key = $value;
    }
}
