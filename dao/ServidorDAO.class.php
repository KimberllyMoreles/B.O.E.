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

    public function fazerLogin($siape, $senha){
        $sql = "SELECT id_servidor, nome FROM servidor WHERE siape = '$siape' AND senha = '$senha'";
        $lista = array();
        $query = $this->pdo->prepare($sql);
<<<<<<< HEAD
        
        $query->execute();
        
        $dados =$query->rowCount();
=======

        
        $dados = pg_fetch_object($query);
>>>>>>> 96dad1dbbc0ad53738a20255a697dc6d1911f0b9
        $_SESSION['usuario']['id'] = $dados['id_servidor'];
        $_SESSION['usuario']['nome'] = $dados['nome'];

        echo $dados['id_servidor'];
        echo $dados['nome'];
<<<<<<< HEAD
=======
        $query->execute();
>>>>>>> 96dad1dbbc0ad53738a20255a697dc6d1911f0b9

        if($obj=$query->fetchObject()){
            return $obj;
        }
        else{
            return null;
        }
<<<<<<< HEAD
        
    }
    /*
	function deslogar(){
		session_destroy();
		header("Location: dirname(__FILE__)/../index.php");
	}*/
=======

        
    }
>>>>>>> 96dad1dbbc0ad53738a20255a697dc6d1911f0b9
}

