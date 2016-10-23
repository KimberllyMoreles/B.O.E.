<?php
	
	require_once '../dao/OcorrenciaDAO.class.php';
	require_once '../modelo/Ocorrencia.class.php';
	require_once '../dao/ComentarioDAO.class.php';
	require_once '../modelo/Comentario.class.php';

	//instanciar o objeto Ocorrencia
	
	//pego os campos do formulário e preencho a classe
	$ocorrencia = new Ocorrencia();
	$dao = new OcorrenciaDAO();
	
	$ocorrencia -> id_aluno = $_POST["aluno"];
	$ocorrencia -> id_solicitante = $_POST["solicitante"];
	$ocorrencia -> id_autuador = $_POST["autuador"];
	$ocorrencia -> data_cadastro_cadastro = $_POST["data_cadastro_cadastro"];
	$ocorrencia -> id_tipo_ocorrencia = $_POST["tipo_ocorrencia "];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
		$retornob = $dao->inserir($ocorrencia);
		$id = $retornob;
        	
        	/*
        	$aluno_ocorrencia = new Aluno_Ocorrencia();
        	$dao = new Aluno_OcorrenciaDAO();
        	
        	$aluno_ocorrencia -> id_aluno = $_POST["aluno"];
        	$aluno_ocorrencia -> id_ocorrencia = $Id;
        	
        	$retornoc = $dao -> inserir($aluno_ocorrencia);
        	*/
        	
		$comentario = new Comentario();
		$dao = new ComentarioDAO();

		$comentario -> id_ocorrencia = $id;
		$comentario -> id_usuario =  $_POST["usuario"];
		$comentario -> comentario = $_POST["comentario"];
		$comentario -> data_cadastro = $_POST["data_cadastro"];
	
		$retorno = $dao->inserir($comentario);	
	}
	
	else{		
		$ocorrencia -> id_ocorrencia = $_POST["id"];	
		$retorno = $dao->alterar($ocorrencia);		
	}
	
	echo json_encode($retorno);
?>        

