<?php
	include 'index2.php';
	require '../model/Servidor.class.php';
	require '../dao/ServidorDAO.class.php';
	
	$dao = new ServidorDAO();  
		
	if(isset($_POST["txtFiltro"])){
        	$lista = $dao->listar($_POST["txtFiltro"]); 
     	}     	
     	else{
        	$lista = $dao->listar(); 
     	}
     	
	if (isset($_GET['acao'])=='excluir'){
		$dao = new ServidorDAO();
		$chaveprimaria = $_GET['id'];
		$retorno = $dao -> excluir($chaveprimaria);
		echo '<script language="Javascript">
				    location.href="Servidor.php";
			 </script>';
	}

	if (isset($_GET['salvar'])){
		$servidor = new Servidor();
		
		$servidor -> nome = $_POST["nome"];
		$servidor -> cpf = $_POST["cpf"];
		$servidor -> siape = $_POST["siape"];
		$servidor -> id_categoria = $_POST["categoria"];
		$servidor -> senha = $_POST["senha"];

		//Chamo a DAO e mando inserir

		if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
			$retorno = $dao->inserir($servidor);
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
						alert('Servidor adicionado com sucesso');
						location.href='Servidor.php';
					</script>";	
			}
			else{
				echo "<script language='Javascript'>
						alert('Erro ao adicionar servidor');
						location.href='Servidor.php';
					</script>";	
			}	
		}
	
		else{				
			$servidor -> id = $_POST["id"];	
			$retorno = $dao->alterar($servidor);	
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
					alert('Servidor alterado com sucesso');
					location.href='Servidor.php';
				</script>";
			}	
			
			else{
				echo "<script language='Javascript'>
						alert('Erro ao alterar servidor');
						location.href='Servidor.php';
					</script>";	
			}	
		}	
		
		/*echo '<script type="text/javascript" language="javascript">
					$("input[name=id]").val('');
					$("input[name=nome]").val('');
					$("input[name=cpf").val('');
					$("input[name=siape]").val('');
					$("input[name=categoria]").val(''); 
					$("input[name=senha]").val('');
					$("input[name=senha1]").val('');  
				</script>';	
			*/
	}

?>

	<script type="text/javascript" language="javascript">
		function SomenteNumero(e){ type="text" 
		    var tecla=(window.event)?event.keyCode:e.which;   
		    
		    if((tecla>47 && tecla<58)){
		    	return true;
		    }
		    else{
		    	if (tecla==8 || tecla==0) return true;
			else  return false;
		    }
		}
		
		function TestaCPF(strCPF) {
		    var Soma;
		    var Resto;
		    Soma = 0;
			if (strCPF == "00000000000") return false;
		    
			for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
			Resto = (Soma * 10) % 11;
	
		    if ((Resto == 10) || (Resto == 11))  Resto = 0;
		    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
	
			Soma = 0;
		    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
		    Resto = (Soma * 10) % 11;
	
		    if ((Resto == 10) || (Resto == 11))  Resto = 0;
		    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
		    return true;
		}
		
		function fillForm(valor){		
			if (valor != null) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'servidor_busca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						$("input[name=id]").val(valor);
						$("input[name=nome]").val(response.nome);	
						$("input[name=cpf").val(response.cpf);
						$("input[name=siape]").val(response.siape);
						$("select[name=categoria]").val(response.id_categoria);     
						$("input[name=senha]").prop('disabled', true);       
						$("input[name=senha1]").prop('disabled', true);     
					}
				});				
			}
		}		
		function valida(){
			if (formulario.nome.value == ""){
					alert("Digite o nome")
				return (false)
			}
			//validar cpf
			if (formulario.cpf.value == ""){
				alert("Digite o CPF")
				return (false)
			}
			
			if(TestaCPF(formulario.cpf.value)==false){
				alert("CPF inválido")
				return (false)
			}
			
			if (formulario.siape.value == ""){
					alert("Digite o siape")
				return (false)
			}
			
			if (formulario.categoria.value == ""){
				alert("Escolha uma categoria")
				return (false)
			}
						
			if (formulario.senha.value != "" || formulario.senha2.value != ""){
				//verificar se senha do segundo campo é a mesma do primeiro
				if (formulario.senha.value != formulario.senha2.value){
					alert("Preencha ambos os campos de senha com o mesmo valor")				
					return (false)
				}
			}						
			formulario.submit();
		}		
	</script>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Listagem de Servidores
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="glyphicon glyphicon-check"></i> Novo cadastro</button>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-lg-offset-6">
                                <div class="form-group input-group row">
			        <form method="post">
                                    <input type="text" class="form-control" name="txtFiltro">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" onClick='filtro();' ><i class="glyphicon glyphicon-search"></i></button></span>
                                </form>
                               	<!--<form method="post">
                                    <input type="text" class="form-control">
                                        <span class="input-group-btn">
                                       		<button class="btn btn-default" onClick='filtro()' type="button"><i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                 </form>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Siape</th>
                                        <th>CPF</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                        	 	$cont = 0;
				 	if($lista != 0){
						foreach($lista as $obj){
							$id = $obj -> id_servidor;
							$nome = $obj -> nome;
							$siape = $obj -> siape;
							$cpf = $obj -> cpf;
							$cont += 1;	
				echo "							
					<tr>
						<th>$cont</th>
						<td>$nome</td>	
						<td>$siape</td>	
						<td>$cpf</td>	
						<td><input type='checkbox' name='ativo'></td>                             
		                                <td>
		                                    <div class='pull-right'>
		                                        <a type='button' class='btn btn-success' name='editar' data-toggle='modal'  data-target='#myModal' onClick='fillForm($id)' rel='modal' id='salvar' name='salvar' title='Editar'>
		                                            <i class='glyphicon glyphicon-edit'></i> Editar</a>&nbsp&nbsp&nbsp&nbsp
		                                "; ?> <a type='button' class='btn btn-danger' name='Deletar' href='Servidor.php?acao="excluir"&&id=<?php echo  $id?>'> 
		                                            <i class='glyphicon glyphicon-edit'></i> Deletar</a>
		                                    </div>
		                                </td>
                                    </tr><?php
                                    		}
                                    	}
                                    ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                    <div class="row" style="display:none;">
                        <div class="col-lg-offset-8 ">
                          <ul class="pagination">
                              <li tabindex="0" aria-controls="dataTables-example" class="paginate_button active"><a href="#">1</a></li>
                              <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">2</a></li>
                              <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">3</a></li><li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">4</a></li>
                              <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">5</a></li>
                              <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">6</a></li>
                              <li id="dataTables-example_next" tabindex="0" aria-controls="dataTables-example" class="paginate_button next"><a href="#">Next</a></li>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Modal -->

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <h2><p style="text-align: center; font-weight: bold;">Cadastro de Servidor</p></h2>
                         <form role="form" action="Servidor.php?salvar=true" method="POST" name='formulario' onSubmit="return valida()">
                           <input type="hidden" id="id" name="id">
                            <div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-6">
                                    <label>Nome</label>
                                    <input type="text" style="width: 350px;" class="form-control" placeholder="Fulano de tal" id="nome" name="nome">
                                </div>
                                <div class="col-lg-4">
                                    <label>CPF</label>
                                    <input style="width: 250px;" class="form-control" placeholder="12312312312" id="cpf" name="cpf">
                                </div>
                            </div>
                            <!--<div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-5">
                                    <label>Siape</label>
                                    <input style="width: 305px;" class="form-control" placeholder="1234567890987654321" id="siape" name="siape">
                                </div>
                                <div class="col-lg-5" style="margin-left:20px">
                                    <label>Categoria</label>
                                    <select name='categoria'>
										<option value="">Selecione a categoria: </option>
										<option value="1">Assistente de Alunos</option>
										<option value="2">Assistente Social</option>
										<option value="3">Orientador(a) Educacional</option>
										<option value="4">Supervisor(a) Pedagógico(a)</option>						
										<option value="5">Professor(a)</option>					
										<option value="6">Psicólogo(a)</option>
								    </select> 
                                </div>
                            </div>-->
							<div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-5">
                                    <label>Siape</label>
                                    <input style="width: 210px;" class="form-control" placeholder="1234567" id="siape" name="siape" onkeypress='return SomenteNumero(event)'>
                                </div>
                                <div class="col-lg-4" style="margin-left: 70px">
                                    <label>Categoria</label>
                                    <select name='categoria'>
										<option value="">Selecione a categoria: </option>
										<option value="1">Assistente de Alunos</option>
										<option value="2">Assistente Social</option>
										<option value="3">Orientador(a) Educacional</option>
										<option value="4">Supervisor(a) Pedagógico(a)</option>						
										<option value="5">Professor(a)</option>					
										<option value="6">Psicólogo(a)</option
										>
								    </select> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4" style="margin-left:40px">
                                    <label>Senha</label>
                                    <input type="password" style="width: 210px;" class="form-control" placeholder="********" id="senha" name="senha">
                                </div>
                                <div class="col-lg-4" style="margin-left:10px">
                                    <label>Repetir senha</label>
                                    <input type="password" style="width: 210px;" class="form-control" placeholder="********" id="senha1" name="senha1">
                                </div>
                            </div>
                            <div style="margin-left: 80%; margin-bottom: 25px;">
                                <button type="submit" class="glyphicon glyphicon-check botao1 btn btn-primary" name="inserir" data-toggle="modal" data-target=".bd-example-modal-lg" id="salvar"> Salvar</button>
                            </div>
                            
                        </form>
                        </div>
                    </div>
                </div>   
    </div> <!-- div aberta na index.php -->
</body>
</html>
