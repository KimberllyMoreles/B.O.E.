<?php
	require '../dao/ResponsavelDAO.class.php';
	require '../model/Responsavel.class.php';
	
	$dao = new ResponsavelDAO();
	$filtro = $_GET['term'];
	
	$retorno = $dao -> listarResponsavelAutocomplete($filtro);
	
	echo json_encode($retorno);
?>
