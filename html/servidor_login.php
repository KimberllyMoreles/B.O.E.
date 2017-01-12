<?php
	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();
	$siape = $_POST['siape'];
	$senha = $_POST['senha'];
	
	if ((isset($_POST['siape'])) && ($_POST['siape'] != '') && (isset($_POST['senha'])) && ($_POST['senha'] != '')) {
		$retorno = $dao -> fazerLogin($siape, $senha);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
