<?php


class Comentario
{

  private $id_comentario;
  private $id_ocorrencia;
  private $id_usuario;
  private $data_cadastro;
  private $comentario;
  private $tipo_comentario;

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
