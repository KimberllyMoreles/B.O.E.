<?php

	  // A sessão precisa ser iniciada em cada página diferente
	  if (!isset($_SESSION)) session_start();
	  $_SESSION['UsuarioID'] = 0;
	  // Verifica se não há a variável da sessão que identifica o usuário
	  if (!isset($_SESSION['UsuarioID'])) {
	      // Destrói a sessão por segurança
	      session_destroy();
	  }

	require '../dao/ServidorDAO.class.php';
	require '../model/Servidor.class.php';
	
	$dao = new ServidorDAO();  
	
	if (isset($_GET['login'])){
		$servidor = new Servidor();
		
		$servidor -> siape = $_POST["siape"];
		$servidor -> senha = $_POST["senha"];
		
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
		
				<div>
					<div class="container-fluid">
						<!-- Page Heading -->
					<div class="row">
					    <div class="col-lg-12">
						<h1>
						    Login
						</h1>
					    </div>
					    
					</div><br><br>
					<form role="form" action="Login.php?login=true" method="POST" name='formulario' id="formLogin" onSubmit="return validaLogin()">
						<div class="form-group row" style="margin-left: 15px;">
						    <div class="col-lg-2">
							<label>Siape</label>
							<input id="siape" name='siape' style="width: 150px;" class="form-control" placeholder="1234567" maxlength="14" >
						    </div>
						    
						</div>
						<div class="form-group row" style="margin-left: 15px;">
						    <div class="col-lg-3">
							<label>Senha</label>
							<input id="senha" name='senha' style="width: 240px;" class="form-control" type="password" />
						    </div>						   
						</div>	
						<div class="form-group row col-lg-12" style="margin-left: 15px;">
							<button class="glyphicon glyphicon-check btn btn-primary pull-right" style="margin-right: 60px"> Salvar</button>
						</div>			    
					</form>
					
			</div>
		</div>
	</body>
</html>
