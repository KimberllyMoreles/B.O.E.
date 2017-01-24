<?php		  
	
	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();  
	
	if (isset($_GET['login'])){
		$servidor = new Servidor();
		
		$servidor -> siape = $_POST["siape"];
		$servidor -> senha = sha1(md5($_POST["senha"]));
		
		$retorno = $dao->login($servidor);
		if ($retorno != null){
			// Se a sessão não existir, inicia uma
			if (!isset($_SESSION)) session_start();
			
			// Salva os dados encontrados na sessão
			$_SESSION['UsuarioID'] = $retorno['id_servidor'];
			$_SESSION['UsuarioNome'] = $retorno['nome'];
			$_SESSION['UsuarioCategoria'] = $retorno['id_categoria'];
				
			echo "<script language='Javascript'>
					location.href='index.php';
				</script>";	
		}
		else{
			echo "<script language='Javascript'>
					alert('Erro ao fazer login');
					location.href='Login.php';
				</script>";	
		}	
	}
?>

	<script type="text/javascript" language="javascript">	
		function validaLogin(){			
			if (formulario.siape.value == "" || formulario.senha.value == ""){
				alert("Insira o siape e a senha")
				return (false)
			}																		
			formulario.submit();		
		}
		
		
		
	</script>
		
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>B.O.E. - Boletim de ocorrências estudantis</title>

	<script type="text/javascript" src="js/jquery-1.12.2.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.js"></script>	
	<script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.min.js"></script>	
	
	 
	
	<!-- calendar stylesheet -->
	<link rel="stylesheet" type="text/css" media="all" href="js/jscalendar-1.0/skins/aqua/theme.css" title="win2k-cold-1" />

	<!-- main calendar program -->
	<script type="text/javascript" src="js/jscalendar-1.0/calendar.js"></script>

	<!-- language for the calendar -->
	<script type="text/javascript" src="js/jscalendar-1.0/lang/calendar-br.js"></script>

	<!-- the following script defines the Calendar.setup helper function, which makes
		adding a calendar a matter of 1 or 2 lines of code. -->
	<script type="text/javascript" src="js/jscalendar-1.0/calendar-setup.js"></script>	

	    <!-- Bootstrap Core CSS -->
	    <link href="outros/startbootstrap-sb-admin-1.0.4/css/bootstrap.min.css" rel="stylesheet">

	    <!-- Custom CSS -->
	    <link href="outros/startbootstrap-sb-admin-1.0.4/css/sb-admin.css" rel="stylesheet">

	    <!-- Custom Fonts -->
	    <link href="outros/startbootstrap-sb-admin-1.0.4/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	    <!-- Meus estilos -->
	    <link href="css/estilo.css" rel="stylesheet">

	    <!-- jQuery -->
	    <script src="outros/startbootstrap-sb-admin-1.0.4/js/jquery.js"></script>

	    <!-- Bootstrap Core JavaScript -->
	    <script src="outros/startbootstrap-sb-admin-1.0.4/js/bootstrap.min.js"></script>

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
    	<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" /> 
    	
    	<style>
    		.container-box-login
		{
			width: 300px;
			margin: 80px auto 0 auto;
			padding: 20px;
			border: 1px solid #eee;
			border-radius: 5px;
			background-color: #fff;
			min-height: 320px;
		}
    	</style>
</head>


<body>
		<div style="padding-top:80px;">
			<div class="container-box-login">
				<!-- Page Heading -->
				<div class="row text-center">
					<div class="col-lg-12">
						<h1>
						    Login
						</h1>
					</div>						    
				</div>
				<div>
					<form role="form" action="Login.php?login=true" method="POST" name='formulario' id="formLogin" onSubmit="return validaLogin()">
						<div class="form-group">
							<label>Siape</label>
							<input id="siape" name='siape' class="form-control" placeholder="Digite seu siape" maxlength="14" >
						</div>
						<div class="form-group">
								<label>Senha</label>
								<input id="senha" name='senha' class="form-control" type="password" placeholder="********"/>
						</div>	
						<div class="form-group">
							<button class="glyphicon glyphicon-check btn btn-primary form-control"> Login</button>
						</div>			    
					</form>
				</div>				
			</div>
		</div>
	</body>
</html>
