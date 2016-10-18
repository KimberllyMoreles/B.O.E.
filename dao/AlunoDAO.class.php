<?php

require_once 'Conexao.class.php';
class AlunoDAO {
    private $pdo;
    
    public function __construct(){
        //AQUI é feita a conexão com o Banco
        $conexao = new Conexao();
        $this->pdo = $conexao->getPDO();
    }
    //Listar
    public function listar($filtro=null,$ordenarPor=null){
        $parametros = array();
        $sql = "SELECT * FROM aluno WHERE status <> 2";
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
    
    public function inserir($obj)
    {
        //Monta os parâmetros
        $parametros = array(
        ':cpf' => $obj->cpf,
        'nome' => $obj->nome,
        ':matricula' => $obj->matricula,
        ':senha' => $obj->senha,
        ':curso' => $obj->curso,
        ':responsavel1' => $obj->responsavel1,
        ':responsavel2' => $obj->responsavel2,
        ':data_nasc' => $obj->data_nasc
        );
    
        //prepara o sql
        $sql = "INSERT INTO aluno(cpf, nome, matricula, senha, id_curso, id_responsavel1, id_responsavel2, data_nasc) VALUES(:cpf, :nome, :matricula, :senha, :curso, :responsavel1, :responsavel2, :data_nasc)";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);
                  
        return $retorno->rowCount();
    }
    
    public function excluir($chaveprimaria) {
        $sql = "UPDATE 
        		aluno 
        	    SET 
        	    	status = 2
        	    WHERE 
        	    	id_aluno = :id_aluno";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_aluno", $chaveprimaria);
        $retorno->execute();
         
        return $retorno->rowCount();
    }
    
    public function alterar($obj)
    {
        $parametros = array(
         ':cpf' => $obj->cpf,
        'nome' => $obj->nome,
        ':matricula' => $obj->matricula,
        'senha' => $obj->senha,
        ':id_curso' => $obj->curso, 
        ':id_responsavel1' => $obj->responsavel1,
        ':id_responsavel2' => $obj->responsavel2,
        ':data_nasc' => $obj->data_nasc
        );
        //tratar senha
        $sql = "UPDATE aluno SET "
                . "cpf = :cpf, "
                . "nome= :nome,"
                . "matricula= :matricula"
                . "senha= :senha,"
                . "curso= :curso"
                . "responsavel1= :responsavel1,"
                . "responsavel2= :responsavel2,"                
                . "data_nasc= :data_nasc "
                . " WHERE id_aluno= :id_aluno";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }
    
    public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "SELECT * FROM aluno WHERE id_aluno = :id_aluno";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_aluno",$chaveprimaria);
        $retorno->execute();
        
        if($obj = $retorno->fetchObject()){
            return $obj;
        }
        else{
            return null;
        }
         
    }
    
    //função que realiza a busca de alunos relacionados a determinado responsável
    public function buscarAlunoPorResponsavel($chaveprimaria)
    {
        $sql = "SELECT * FROM aluno WHERE id_responsavel1 = :id_responsavel OR id_responsavel2 = id_responsavel";
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_responsavel",$chaveprimaria);
        $retorno->execute();
        
        if($obj = $retorno->fetchObject()){
            return $obj;
        }
        else{
            return null;
        }
         
    }
}
