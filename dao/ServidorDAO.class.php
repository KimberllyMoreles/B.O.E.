<?php
require_once 'Conexao.class.php';

class ServidorDAO {
    private $pdo;
    
    public function __construct(){
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    
    public function inserir($obj){ 
            $parametros = array(
            ':nome'=> $obj->nome,
            ':cpf'=> $obj->cpf,
            ':siape'=> $obj->siape,
            ':id_categoria'=> $obj->id_categoria,
            ':senha'=> $obj->senha
        );
 
        $sql = "INSERT INTO servidor (nome, cpf, siape, id_categoria, senha)"
                . "VALUES (:nome, :cpf, :siape, :id_categoria, :senha)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function excluir($chavePrimaria){
        $sql = "UPDATE servidor SET status=2 WHERE id_servidor = :id_servidor";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_servidor", $chavePrimaria);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    
    public function alterar($obj){
        $parametros = array(
            ':id_servidor'=> $obj->id_servidor,
            ':nome'=> $obj->nome,
            ':cpf'=> $obj->cpf,
            ':siape'=> $obj->siape,
            ':id_categoria'=> $obj->id_categoria,
            ':senha'=> $obj->senha
        );
        
        $sql = "UPDATE servidor SET "
                . "nome = :nome, "
                . "cpf = :cpf, "
                . "siape = :siape, "
                . "id_categoria = :id_categoria, "
                . "senha = :senha, "
                . " WHERE id_servidor = :id_servidor ";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function buscarPorChavePrimaria($chavePrimaria){
        $sql=("SELECT * FROM servidor WHERE id_servidor = :id_servidor AND status <> 2");
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_servidor", $chavePrimaria);
        $retorno->execute();
       
        if($obj=$retorno->fetchObject()){
            return $obj;
        }
        else{
            return null;
        }
    }
    
        public function buscarPorSiape($siape){
		$sql=("SELECT * FROM servidor WHERE siape = :siape AND status <> 2");
		$retorno = $this->pdo->prepare($sql);
		$retorno->bindParam(":siape", $siape);
		$retorno->execute();
	       
		if($obj=$retorno->fetchObject()){
		    return $obj;
		}
		else{
		    return null;
		}
	    }
	    
	     public function buscarPorCpf($cpf){
		$sql=("SELECT * FROM servidor s, aluno a, responsavel r WHERE s.cpf = :cpf OR a.cpf = :cpf OR r.cpf = :cpf");
		$retorno = $this->pdo->prepare($sql);
		$retorno->bindParam(":cpf", $cpf);
		$retorno->execute();
	       
		if($obj=$retorno->fetchObject()){
		    return $obj;
		}
		else{
		    return null;
		}
	    }
    
    public function listar($filtro=null,$ordenarPor=null){
        $parametros = array();
        $sql = "SELECT * FROM servidor WHERE status <> 2";
        if(isset($filtro)){
            $sql .= " AND nome ilike :filtro ";
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
    
    //método utilizado pelo autocomplete da página de 
    //ocorrencias para definir servidor solicitante da ocorrencia
    public function listarServidorAutocomplete($filtro){
        $parametros = array();
        $sql = "SELECT id_servidor, nome FROM servidor WHERE status <> 2 AND nome ilike :filtro ";
        $parametros[":filtro"] = "%".$filtro."%";
     
        $query = $this->pdo->prepare($sql);
        
        $query->execute($parametros);
        $json = Array();
        while ($obj = $query->fetchObject()){
		array_push($json, 
			Array(
				"label" => $obj->nome, 				
				"id_solicitante" =>$obj->id_servidor//recebe o id do servidor solicitante da ocorrencia
			)
		);
        }
       
        return $json;
    }
    
	public function login($obj){
		$parametros = array(
			':siape'=> $obj->siape,
			':senha'=> $obj->senha
		);
		$sql = ("SELECT id_servidor, nome, id_categoria FROM servidor WHERE siape = :siape AND senha = :senha AND status <> 2 LIMIT 1");
		$retorno = $this->pdo->prepare($sql);
        	$retorno->execute($parametros);
        	
		if($obj=$retorno->fetch()){
		    return $obj;
		}
		else{
		    return null;
		}
	} 
}

