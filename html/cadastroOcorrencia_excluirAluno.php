<?php
	require '../dao/Aluno_OcorrenciaDAO.class.php';
	
	$dao = new Aluno_OcorrenciaDAO();
	$idAluno = $_POST['idAluno'];	
	$idOcorrencia = $_POST['idOcorrencia'];
	$retorno = "";
	
	if ((isset($_POST['idAluno'])) && ($_POST['idAluno'] != '')&&(isset($_POST['idOcorrencia'])) && ($_POST['idOcorrencia'] != '')) {
		$testeAlunos = $dao -> buscarAluno($idOcorrencia);
		echo $testeAlunos;
		if($testeAlunos > 1){
			$retorno1 = $dao -> excluir($idAluno, $idOcorrencia);
			$retorno = 1;
		}
		else{
			$retorno = 0;
		}
	}

	else{
		$retorno = 2;
	}
	echo json_encode($retorno);
 
?>
