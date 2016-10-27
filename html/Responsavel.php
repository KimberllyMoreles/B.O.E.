<?php
	include 'index2.php';
	require '../model/Responsavel.class.php';
	require '../dao/ResponsavelDAO.class.php';
	require '../dao/AlunoDAO.class.php';
	
	$dao = new ResponsavelDAO();
	$daoAluno = new AlunoDAO();
		
	if(isset($_POST["txtFiltro"])){
        	$lista = $dao->listar($_POST["txtFiltro"]); 
     	}     	
     	else{
        	$lista = $dao->listar(); 
     	}
     	
     	
     	
	if (isset($_GET['acao'])=='excluir'){
		$dao = new ResponsavelDAO();
		$chaveprimaria = $_GET['id'];
		$retorno = $dao -> excluir($chaveprimaria);
		echo '<script language="Javascript">
				    location.href="Responsavel.php";
			 </script>';
	}

	if (isset($_GET['salvar'])){
		$responsavel = new Responsavel();
		
		$responsavel -> nome = $_POST["nome"];
		$responsavel -> cpf = $_POST["cpf"];
		$responsavel -> email = $_POST["email"];
		$responsavel -> telefone1 = $_POST["telefone1"];
		$responsavel -> telefone2 = $_POST["telefone2"];
		$responsavel -> telefone3 = $_POST["telefone3"];
		$responsavel -> senha = $_POST["senha"];

		//Chamo a DAO e mando inserir

		if ((!isset($_POST['id'])) || ($_POST['id'] == '')){		
			$retorno = $dao->inserir($responsavel);
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
						alert('Responsável adicionado com sucesso');
						location.href='Responsavel.php';
					</script>";	
			}
			else{
				echo "<script language='Javascript'>
						alert('Erro ao adicionar responsável');
						location.href='Responsavel.php';
					</script>";	
			}	
		}
	
		else{				
			$responsavel -> id = $_POST["id"];	
			$retorno = $dao->alterar($responsavel);	
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
					alert('Responsável alterado com sucesso');
					location.href='Responsavel.php';
				</script>";
			}	
			
			else{
				echo "<script language='Javascript'>
						alert('Erro ao alterar responsável');
						location.href='Responsavel.php';
					</script>";	
			}	
		}
		
		echo '<script type="text/javascript" language="javascript">
					$("input[name=id]").val("");
					$("input[name=nome]").val("");
					$("input[name=cpf").val("");
					$("input[name=email]").val("");
					$("input[name=telefone1]").val("");
					$("input[name=telefone2]").val("");
					$("input[name=telefone3]").val("");
					$("input[name=senha]").val("");
					$("input[name=senha1]").val("");
				</script>';	
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
					url: 'responsavel_busca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						$("input[name=id]").val(valor);
						$("input[name=nome]").val(response.nome);	
						$("input[name=cpf").val(response.cpf);
						$("input[name=email]").val(response.email);
						$("input[name=telefone1]").val(response.telefone1);     
						$("input[name=telefone2]").val(response.telefone2);    
						$("input[name=telefone3]").val(response.telefone3);
						$("input[name=senha]").prop('disabled', true);       
						$("input[name=senha1]").prop('disabled', true);
						
					}
				});
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'responsavel_busca_aluno.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						for(var i=0; i < response.length; i++){						
							//Adicionando registros retornados no label									
							$('#filhos').append('<span class="label label-primary">' + response[i].nome + '</span>');							
						}
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
			
			if (formulario.email.value == ""){
					alert("Digite o email")
				return (false)
			}
			
			if (formulario.telefone1.value == ""){
				alert("Digite um número para o telefone 1")
				return (false)
			}
						
			if (formulario.senha.value != "" || formulario.senha2.value != ""){
				//verificar se senha do segundo campo é a mesma do primeiro
				alert("Preencha ambos os campos de senha com o mesmo valor")
				return (false)
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
                            Listagem de Responsáveis
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
                                <div class="form-group input-group">
                               	 <form method="post">
                                    <input type="text" class="form-control" name="txtFiltro">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" onClick='filtro();' ><i class="glyphicon glyphicon-search"></i></button></span>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>CPF</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <!-- Tratar campo 'ativo -->
                                <tbody>
                        	 <?php
                        	 	$cont = 0;
				 	if($lista != 0){
						foreach($lista as $obj){
							$id = $obj -> id_responsavel;
							$nome = $obj -> nome;
							$email = $obj -> email;
							$cpf = $obj -> cpf;
							$cont += 1;	
				echo "							
					<tr>
						<th>$cont</th>
						<td>$nome</td>	
						<td>$email</td>	
						<td>$cpf</td>	
						<td><input type='checkbox' name='ativo'></td>                             
		                                <td>
		                                    <div class='pull-right'>
		                                        <a type='button' class='btn btn-success' name='editar' data-toggle='modal'  data-target='#myModal' onClick='fillForm($id)' rel='modal' id='salvar' name='salvar' title='Editar'>
		                                            <i class='glyphicon glyphicon-edit'></i> Editar</a>&nbsp&nbsp&nbsp&nbsp
		                                "; ?> <a type='button' class='btn btn-danger' name='Deletar' href='Responsavel.php?acao="excluir"&&id=<?php echo  $id?>'> 
		                                            <i class='glyphicon glyphicon-edit'></i> Deletar</a>
		                                    </div>
		                                </td>
                                    </tr><?php
                                    		}
                                    	}
                                    ?>
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
                                <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">3</a></li>
                                <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">4</a></li>
                                <li tabindex="0" aria-controls="dataTables-example" class="paginate_button "><a href="#">5</a></li>
                                <li id="dataTables-example_next" tabindex="0" aria-controls="dataTables-example" class="paginate_button next"><a href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Modal -->

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <h2><p style="text-align: center; font-weight: bold;">Cadastro de Responsável</p></h2>
                        <form role="form" action="Responsavel.php?salvar=true" method="POST" name='formulario' onSubmit="return valida()">
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
                            <div class="form-group" style="width: 350px; margin-left: 40px;">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="example@mail.com" id="email" name="email">
                            </div>
                            <div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-3">
                                    <label>Telefone</label>
                                    <input style="width: 210px;" class="form-control" placeholder="5312341234" id="telefone1" name="telefone1" onkeypress='return SomenteNumero(event)'>
                                </div>
                                <div class="col-lg-3" style="margin-left:20px">
                                    <label>Telefone 2</label>
                                    <input style="width: 210px;" class="form-control" placeholder="5312341234" id="telefone2" name="telefone2" onkeypress='return SomenteNumero(event)'>
                                </div>
                                <div class="col-lg-2" style="margin-left:20px">
                                    <label>Telefone 3</label>
                                    <input type="text" style="width: 210px;" class="form-control" placeholder="5312341234" id="telefone3" name="telefone3" onkeypress='return SomenteNumero(event)'>
                                </div>
                            </div>
                            <div>
                                <label style="margin-left: 40px;" id="filhos" name="filhos">Filhos(as):</label>
                            </div>
                            <div style="margin-left: 80%; margin-bottom: 25px;">
                                <button type="submit" class="glyphicon glyphicon-check botao1 btn btn-primary" name="inserir" data-toggle="modal" data-target=".bd-example-modal-lg" id="salvar"> Salvar</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>   
        </div> <!-- div aberta na index.php -->
    </div>
</body>
</html>
