<?php
	
	require '../dao/OcorrenciaDAO.class.php';
	require '../model/Ocorrencia.class.php';

	//instanciar o objeto Ocorrencia
	
	//pego os campos do formulário e preencho a classe
	$ocorrencia = new Ocorrencia();
	$dao = new OcorrenciaDAO();
	$ocorrencia -> data_cadastro = $_POST["data_cadastro"];
	$ocorrencia -> id_solicitante = $_POST["id_solicitante"];
	$ocorrencia -> id_autuador = $_POST["id_solicitante"];
	$ocorrencia -> id_tipo_ocorrencia = $_POST["tipo_ocorrencia"];

	//Chamo a DAO e mando inserir

	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){
			
		$retorno = $dao->inserir($ocorrencia);		
	}
	
	else{		
		$ocorrencia -> id_ocorrencia = $_POST["id"];
		$retorno = $dao->alterar($ocorrencia);		
	}
	
	echo json_encode($retorno);
?>        
    

