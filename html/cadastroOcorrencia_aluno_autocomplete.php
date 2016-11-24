<?php
	require '../dao/AlunoDAO.class.php';
	require '../model/Aluno.class.php';
	
	$dao = new AlunoDAO();
	$filtro = $_GET['term'];
	
	$retorno = $dao -> listarAlunoAutocomplete($filtro);
	
	echo json_encode($retorno);
?>
