<?php
	require '../dao/AlunoDAO.class.php';
	require '../model/Aluno.class.php';
	
	$dao = new AlunoDAO();
	$id = $_POST['id'];
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$retorno = $dao -> buscarAlunoPorResponsavel($id);
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
?>
