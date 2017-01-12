<?php
	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarPorChavePrimaria($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
