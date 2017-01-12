<?php
	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();
	$filtro = $_GET['term'];
	
	$retorno = $dao -> listarServidorAutocomplete($filtro);
	
	echo json_encode($retorno);
?>
