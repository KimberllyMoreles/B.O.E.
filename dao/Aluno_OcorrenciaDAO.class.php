<?php

require_once 'Conexao.class.php';
class Aluno_OcorrenciaDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar($filtro=null,$ordenarPor=null){
        $parametros = array();
        $sql = "SELECT * FROM aluno_ocorrencia WHERE status <> 2";
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
    
    public function inserir($obj){
        //Monta os parâmetros
        $parametros = array(
		    ':id_aluno' => $obj->id_aluno,
		    ':id_ocorrencia' => $obj->id_ocorrencia
        );
    
        //prepara o sql
        $sql = "INSERT INTO aluno_ocorrencia(id_aluno, id_ocorrencia) VALUES(:id_aluno, :id_ocorrencia)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
                  
        return $retorno->rowCount();
    }
    
    public function excluir($idAluno, $idOcorrencia) {
        $sql = "DELETE FROM 
        		aluno_ocorrencia 
        	    WHERE 
        	    	id_aluno = $idAluno
        	    AND 
        	    	id_ocorrencia = $idOcorrencia";
        	    	
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    /*
    public function alterar($obj)
    {
        $parametros = array(
			':id_aluno_ocorrencia' => $obj->id_aluno_ocorrencia,
			':id_aluno' => $obj->id_aluno, 
			':id_ocorrencia' => $obj->id_ocorrencia
        );
        //tratar senha
        $sql = "UPDATE ocorrencia SET "
                . "id_aluno= :id_aluno,"
                . "id_ocorrencia= :id_ocorrencia"
                . " WHERE id_aluno_ocorrencia= :id_aluno_ocorrencia";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }*/
    
   public function buscarAlunoOcorrencia($chaveprimaria)
    {
    	$parametros = array();
        $sql = "SELECT 
        			ao.id_aluno, 
        			a.nome 
        		FROM 
        			aluno_ocorrencia ao, aluno a 
        		WHERE 
        			a.status <> 2
        		AND
        			ao.id_ocorrencia = $chaveprimaria
        		AND 
        			ao.id_aluno = a.id_aluno";
		
		$alunos = array();
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        while ($obj = $retorno->fetchObject()){
            $alunos[] = $obj;
        }
        
        return $alunos;
         
    }
    
    public function buscarAluno($idOcorrencia){
        $sql = "SELECT 
        			ao.id_aluno, 
        			a.nome 
        		FROM 
        			aluno_ocorrencia ao, aluno a 
        		WHERE 
        			a.status <> 2
        		AND
        			ao.id_ocorrencia = $idOcorrencia
        		AND 
        			ao.id_aluno = a.id_aluno";
		
		$alunos = array();
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute();
    
        
        return $retorno->rowCount();
         
    }
    
}
