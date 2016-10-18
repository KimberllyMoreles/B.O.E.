<?php
require_once 'Conexao.class.php';

class ResponsavelDAO {
    private $pdo;
    
    public function __construct(){
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    
    public function inserir($obj){ 
            $parametros = array(
            ':nome'=> $obj->nome,
            ':cpf'=> $obj->cpf,
            ':email'=> $obj->email,
            ':telefone1'=> $obj->telefone1,
            ':telefone2'=> $obj->telefone2,
            ':telefone3'=> $obj->telefone3,    
            ':senha'=> $obj->senha
        );
 
        $sql = "INSERT INTO responsavel (nome, cpf, email, telefone1, telefone2, telefone3, senha)"
                . "VALUES (:nome, :cpf, :email, :telefone1, :telefone2, :telefone3, :senha)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function excluir($chavePrimaria){
        $sql = "UPDATE responsavel SET status=2 WHERE id_responsavel = :id";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id", $chavePrimaria);
        $retorno->execute();
        
        return $retorno->rowCount();
    }
    
    public function alterar($obj){
        $parametros = array(
            ':id'=> $obj->id,
            ':nome'=> $obj->nome,
            ':cpf'=> $obj->cpf,
            ':email'=> $obj->email,
            ':telefone1'=> $obj->telefone1,
            ':telefone2'=> $obj->telefone2,
            ':telefone3'=> $obj->telefone3,    
            ':senha'=> $obj->senha
        );
        
        $sql = "UPDATE responsavel SET "
                . "nome = :nome, "
                . "cpf = :cpf, "
                . "email = :email, "
                . "telefone1 = :telefone1, "
                . "telefone2 = :telefone2, "
                . "telefone3 = :telefone3, "
                . "senha = :senha "
                . " WHERE id_responsavel = :id ";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
        
        return $retorno->rowCount();
    }
    
    public function buscarPorChavePrimaria($chavePrimaria){
        $sql=("SELECT * FROM responsavel WHERE id_responsavel = :id AND status <> 2");
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id", $chavePrimaria);
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
        $sql = "SELECT * FROM responsavel WHERE status <> 2";
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
}

