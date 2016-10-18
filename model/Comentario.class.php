<?php


class Comentario
{

  private $id;
  private $id_projeto_pessoa_tarefa;
  private $id_usuario;
  private $nome_usuario;
  private $data;
  private $comentario;

  public function __construct() { }

  public function __get($chave) 
  {
    return $this->$chave;
  }

  public function __set($chave, $valor) 
  {
      $this->$chave = $valor;
  }

}

?>