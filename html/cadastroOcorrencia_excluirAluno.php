<?php
	require '../dao/Aluno_OcorrenciaDAO.class.php';
	
	$dao = new Aluno_OcorrenciaDAO();
	$idAluno = $_POST['idAluno'];	
	$idOcorrencia = $_POST['idOcorrencia'];
	$retorno = "";
	
	if ((isset($_POST['idAluno'])) && ($_POST['idAluno'] != '')&&(isset($_POST['idOcorrencia'])) && ($_POST['idOcorrencia'] != '')&&($dao -> buscarAluno($idOcorrencia) > 1)) {
		$retorno = $dao -> excluir($idAluno, $idOcorrencia);		
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
