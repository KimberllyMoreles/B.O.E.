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
        $sql = "SELECT o.data_cadastro, s.nome, o.id_tipo_ocorrencia, o.id_ocorrencia FROM ocorrencia o, servidor s WHERE s.id_servidor = o.id_autuador";
        if(isset($filtro)){
            $sql .= " AND o.id_ocorrencia IN (SELECT oa.id_ocorrencia
            		FROM aluno_ocorrencia oa
            		INNER JOIN aluno a ON a.id_aluno = oa.id_aluno
            		AND a.nome ilike :filtro) ";
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
			':id_ocorrencia' => $obj->id_ocorrencia,
			':id_solicitante' => $obj->id_solicitante,
			':id_autuador' => $obj->id_autuador, 
			':id_tipo_ocorrencia' => $obj->id_tipo_ocorrencia
        );
        //tratar senha
        $sql = "UPDATE ocorrencia SET "
                . "data_cadastro = :data_cadastro, "
                . "id_solicitante= :id_solicitante,"
                . "id_autuador= :id_autuador,"
                . "id_tipo_ocorrencia= :id_tipo_ocorrencia"
                . " WHERE id_ocorrencia= :id_ocorrencia";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }
    
   public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "SELECT 
        			o.id_ocorrencia,
        			o.data_cadastro,
        			o.id_tipo_ocorrencia,
        			o.id_solicitante,
        			s.nome AS solicitante
        		FROM 
        			ocorrencia o, servidor s
        		WHERE 
        			o.id_ocorrencia = :id_ocorrencia
        		AND 
        			o.id_solicitante = s.id_servidor";
			
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
    
	public function buscarAlunoOcorrencia($id){
		$sql = "SELECT a.nome FROM aluno a, aluno_ocorrencia ao WHERE a.id_aluno = ao.id_aluno AND ao.id_ocorrencia = :id_ocorrencia";

		$lista = array();
		
		$retorno = $this->pdo->prepare($sql);
		$retorno->bindParam(":id_ocorrencia",$id);
		$retorno->execute();

		 while ($obj = $retorno->fetchObject()){
		    $lista[] = $obj;
		}
		
		return $lista;
	}    
}
