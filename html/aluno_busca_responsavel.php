<?php
	require '../dao/ResponsavelDAO.class.php';
	require '../model/Responsavel.class.php';
	
	$dao = new ResponsavelDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> listar($filtro);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
	return $id;
?>
