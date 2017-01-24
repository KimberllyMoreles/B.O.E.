<?php
	require '../dao/AlunoOcorrenciaDAO.class.php';
	
	$dao = new AlunoOcorrenciaDAO();
	$idAluno = $_POST['idAluno'];	
	$idOcorrencia = $_POST['idOcorrencia'];
	$retorno = "";
	
	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		if($dao -> buscarAluno($idAluno, $idOcorrencia) > 1){
			$retorno1 = $dao -> excluir($idAluno, $idOcorrencia);
			$retorno = "Aluno excluído com sucesso da ocorrência";
		}
		else{
			$retorno = "Impossível excluir. Há apenas um aluno na ocorrência.";
		}
	}

	else{
		$retorno ="Erro";
	}
	echo json_encode($retorno);
 
?>
