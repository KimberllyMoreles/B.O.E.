<?php
	require '../dao/ComentarioDAO.class.php';
	require '../model/Comentario.class.php';
	
	$dao = new ComentarioDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> listar($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
?>
