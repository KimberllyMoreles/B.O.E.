<?php
	require '../dao/ResponsavelDAO.class.php';
	require '../model/Responsavel.class.php';
	
	$dao = new ResponsavelDAO();
	$responsavel = $_POST['responsavel1'];
	
	if ((isset( $_POST['responsavel1'])) && ( $_POST['responsavel1'] != '')) {
		$retorno = $dao -> listar($responsavel);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
