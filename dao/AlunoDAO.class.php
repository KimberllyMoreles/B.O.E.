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
        ':nome' => $obj->nome,
        ':matricula' => $obj->matricula,
        ':curso' => $obj->curso,
        ':responsavel1' => $obj->responsavel1,
        ':responsavel2' => $obj->responsavel2,
        ':data_nasc' => $obj->data_nasc,
        ':observacao'=> $obj->observacao
        );
    
        //prepara o sql
        $sql = "INSERT INTO aluno(cpf, nome, matricula, id_curso, id_responsavel1, id_responsavel2, data_nasc, observacao) VALUES(:cpf, :nome, :matricula, :curso, :responsavel1, :responsavel2, :data_nasc, :observacao)";
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
		':id'=> $obj->id,
		':cpf' => $obj->cpf,
		':nome' => $obj->nome,
		':matricula' => $obj->matricula,
		':id_curso' => $obj->curso, 
		':id_responsavel1' => $obj->responsavel1,
		':id_responsavel2' => $obj->responsavel2,
		':data_nasc' => $obj->data_nasc,
		':observacao'=> $obj->observacao
        );
        //tratar senha
        $sql = "UPDATE aluno SET "
                . "cpf = :cpf, "
                . "nome= :nome,"
                . "matricula= :matricula,"
                . "id_curso= :id_curso,"
                . "id_responsavel1= :id_responsavel1,"
                . "id_responsavel2= :id_responsavel2,"                
                . "data_nasc= :data_nasc,"                               
                . "observacao= :observacao "
                . " WHERE id_aluno= :id";
        $retorno = $this->pdo->prepare($sql);
        $retorno->execute($parametros);        
     	
        return $retorno->rowCount();
    }
    
   public function buscarChavePrimaria($chaveprimaria)
    {
        $sql = "
		SELECT 
			a.*,
			r1.nome AS responsavel1,
			r2.nome AS responsavel2
		FROM 
			aluno a
		LEFT JOIN 
				responsavel r1
			ON
				a.id_responsavel1 = r1.id_responsavel
		LEFT JOIN responsavel r2
			ON
				a.id_responsavel2 = r2.id_responsavel
		WHERE
			id_aluno = :id_aluno
		AND 
			a.status <> 2";
			
        $retorno = $this->pdo->prepare($sql);
        $retorno->bindParam(":id_aluno",$chaveprimaria);
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
    
    //função que realiza a busca de alunos relacionados a determinado responsável
    public function buscarAlunoPorResponsavel($chaveprimaria)
    {
       $parametros = Array();
        $sql = "SELECT * FROM aluno WHERE id_responsavel1 = $chaveprimaria OR id_responsavel2 = $chaveprimaria";
        $lista = array();
        $query = $this->pdo->prepare($sql);
        
        $query->execute($parametros);
        //percorrer meus registros
        //tratando-os como objeto
        while($obj = $query->fetchObject()){
            $lista[] = $obj;
        }
          return $lista;
         
    }
    
    public function listarAlunoAutocomplete($filtro){
        $parametros = array();
        $sql = "SELECT id_aluno, nome FROM aluno WHERE status <> 2 AND nome ilike :filtro ";
        $parametros[":filtro"] = "%".$filtro."%";
     
        $query = $this->pdo->prepare($sql);
        
        $query->execute($parametros);
        $json = Array();
        while ($obj = $query->fetchObject()){
		array_push($json, 
			Array(
				"label" => $obj->nome, 				
				"id_aluno" =>$obj->id_aluno
			)
		);
        }
       
        return $json;
    }
}
