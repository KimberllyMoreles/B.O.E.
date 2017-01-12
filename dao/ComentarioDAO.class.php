<?php

require_once 'Conexao.class.php';
class ComentarioDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar($filtro=null,$ordenarPor=null){
        $parametros = array();
        $sql = "SELECT * FROM comentario WHERE status <> 2";
        if(isset($filtro)){
            $sql .= " AND id_comentario ilike :filtro ";
            $parametros[":filtro"] = "%".$filtro."%";
        }
        $lista = array();
        $query = $this->pdo->prepare($sql);
        
        $query->execute($parametros);
        
        while ($obj = $query->fetchObject()){
            $lista[] = $obj;
        }
        
        return $lista;
    }
    
    public function inserir($obj)
    {
        //Monta os parâmetros
        $parametros = array(
		    ':id_ocorrencia' => $obj->id_ocorrencia,
		    ':id_usuario' => $obj->id_usuario,
		    ':data_cadastro' => $obj->data_cadastro,
		    ':comentario' => $obj->comentario,
		    ':tipo_comentario' => $obj->tipo_comentario
        );
    
        //prepara o sql
        $sql = "INSERT INTO comentario(id_ocorrencia, id_usuario, data_cadastro, comentario, tipo_comentario) VALUES(:id_ocorrencia, :id_usuario, :data_cadastro, :comentario, :tipo_comentario)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
                  
        return $retorno->rowCount();
    }
    
    public function excluir($chaveprimaria) {
        $sql = "UPDATE 
        			comentario 
        	    SET 
        	    	status = 2
        	    WHERE 
        	    	id_comentario = :id_comentario";
        	    	
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    /*
    public function alterar($obj)
    {
        $parametros = array(
			':id_comentario' => $obj->id_comentario,
			':id_ocorrencia' => $obj->id_ocorrencia, 
			':id_comentario' => $obj->id_comentario
        );
        //tratar senha
        $sql = "UPDATE ocorrencia SET "
                . "id_ocorrencia= :id_ocorrencia,"
                . "id_comentario= :id_comentario"
                . " WHERE id_comentario= :id_comentario";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }*/
    
   public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "";
			
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_comentario",$chaveprimaria);
        $retorno->execute();
        
        if($obj = $retorno->fetchObject())
        {
            return $obj;
        }
        else
        {
            return null;
        }
         
    }
    
    
}
