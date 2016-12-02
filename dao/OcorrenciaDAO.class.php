<?php

require_once 'Conexao.class.php';
class OcorrenciaDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar($filtro=null,$ordenarPor=null){
        $parametros = array();
        $sql = "SELECT * FROM ocorrencia WHERE status <> 2";
        if(isset($filtro)){
            $sql .= " AND id_ocorrencia ilike :filtro ";
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
		    ':data_cadastro' => $obj->data_cadastro,
		    ':id_solicitante' => $obj->id_solicitante,
		    ':id_autuador' => $obj->id_autuador,
		    ':id_tipo_ocorrencia' => $obj->id_tipo_ocorrencia
        );
    
        //prepara o sql
        $sql = "INSERT INTO ocorrencia(data_cadastro, id_solicitante, id_autuador, id_tipo_ocorrencia) VALUES(:data_cadastro,  :id_solicitante, :id_autuador, :id_tipo_ocorrencia)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
                  
        return $this->pdo->lastInsertId('ocorrencia_id_ocorrencia_seq');
    }
    
    public function excluir($chaveprimaria) {
        $sql = "UPDATE 
        		ocorrencia 
        	    SET 
        	    	status = 2
        	    WHERE 
        	    	id_ocorrencia = :id_ocorrencia";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_ocorrencia", $chaveprimaria);
        $retorno->execute();
         
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
			':data_cadastro' => $obj->data_cadastro,
			'id' => $obj->id,
			':id_solicitante' => $obj->id_solicitante,
			':id_autuador' => $obj->id_autuador, 
			':id_tipo_ocorrencia' => $obj->id_tipo_ocorrencia
        );
        //tratar senha
        $sql = "UPDATE ocorrencia SET "
                . "data_cadastro = :data_cadastro, "
                . "id_ocorrencia= :id_ocorrencia,"
                . "id_solicitante= :id_solicitante,"
                . "id_autuador= :id_autuador,"
                . "id_tipo_ocorrencia= :id_tipo_ocorrencia"
                . " WHERE id_ocorrencia= :id";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }
    
   public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "SELECT 
        			id_ocorrencia,
        			data_cadastro,
        			id_tipo_ocorrencia,
        			id_solicitante
        		FROM 
        			ocorrencia 
        		WHERE 
        			id_ocorrencia = :id_ocorrencia";
			
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_ocorrencia",$chaveprimaria);
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
