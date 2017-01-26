<?php
	require '../dao/OcorrenciaDAO.class.php';
	require '../model/Ocorrencia.class.php';
	
	$dao = new OcorrenciaDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
?>
