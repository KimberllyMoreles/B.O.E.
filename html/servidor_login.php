<?php
	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();
	$siape = $_POST['siape'];
	$senha = $_POST['senha'];
	
	if ((isset($_POST['siape'])) && ($_POST['siape'] != '') && (isset($_POST['senha'])) && ($_POST['senha'] != '')) {
		$retorno = $dao -> fazerLogin($siape, $senha);
<<<<<<< HEAD
		
		if($retorno == null){
			echo"<script language='javascript' type='text/javascript'>alert('Usuário ou senha não encontrado!');window.location.href='../html/index.php';</script>";
	 
	   		exit(1);
		}
		else{
			header("Location: dirname(__FILE__)/../index2.php");
		}
=======
>>>>>>> 96dad1dbbc0ad53738a20255a697dc6d1911f0b9
	}

	else{
		$retorno = array("success" => false);
	}
	echo json_encode($retorno);
 
?>
