<?php
	require '../dao/OcorrenciaDAO.class.php';
	require '../model/Ocorrencia.class.php';
	
	function retorna($id_ocorrencia){

	$dao = new OcorrenciaDAO();

		$retorno = $dao->buscarChavePrimaria($id_ocorrencia);
	
	echo json_encode($retorno);
 }
?>
