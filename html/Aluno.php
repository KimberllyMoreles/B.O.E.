<?php
	include 'index.php';
	require '../model/Aluno.class.php';
	require '../dao/AlunoDAO.class.php';	
	require '../dao/ResponsavelDAO.class.php';
	
	$dao = new AlunoDAO();
	$daoG = new ResponsavelDAO();

	if(isset($_POST["txtFiltro"])){
		$lista = $dao->listar($_POST["txtFiltro"]); 
     	}     	
     	else{
		$lista = $dao->listar(); 
     	}
     		
	$gLista = $daoG -> listar();
	
	if (isset($_GET['acao'])=='excluir'){
		$dao = new AlunoDAO();
		$chaveprimaria = $_GET['id'];
		$retorno = $dao -> excluir($chaveprimaria);
		echo '<script language="Javascript">
				    location.href="Aluno.php";
			 </script>';
	}
	
	if (isset($_GET['salvar'])){
		$aluno = new Aluno();
		
		$aluno -> nome = $_POST["nome"];
		$aluno -> cpf = $_POST["cpf"];
		$aluno -> matricula = $_POST["matricula"];
		//colocar opção para listar inativos
		$aluno -> curso = $_POST["curso"];
		$aluno -> responsavel1 = $_POST["responsavel1"];
		$aluno -> responsavel2 = $_POST["responsavel2"];	
		$aluno -> data_nasc = $_POST["data_nasc"];

		//Chamo a DAO e mando inserir

		if ((!isset($_POST['id_aluno'])) || ($_POST['id_aluno'] == '')){		
			$retorno = $dao->inserir($aluno);	
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
						alert('Aluno adicionado com sucesso');
						location.href='Aluno.php';
					</script>";	
			}
			else{
				echo "<script language='Javascript'>
						alert('Erro ao adicionar aluno');
						location.href='Aluno.php';
					</script>";	
			}		
		}
	
		else{				
			$aluno -> id_aluno = $_POST["id"];	
			$retorno = $dao->alterar($aluno);
			
			if ($retorno > 0){		
				echo "<script language='Javascript'>
					alert('Aluno alterado com sucesso');
					location.href='Aluno.php';
				</script>";
			}	
			
			else{
				echo "<script language='Javascript'>
						alert('Erro ao alterar aluno');
						location.href='Aluno.php';
					</script>";	
			}			
		}
		
		echo '<script type="text/javascript" language="javascript">
					$("input[name=id]").val("");
					$("input[name=nome]").val("");
					$("input[name=cpf").val("");
					$("input[name=matricula]").val("");
					$("input[name=curso]").val("");
					$("input[name=responsavel1]").val("");  
					$("input[name=responsavel2]").val("");  
					$("input[name=data_nasc]").val("");
				</script>';
			
	}
	//comparar idade para campo responsavel
	echo "<script type='text/javascript' language='javascript'>		
			function idadeAluno(data_nasc){
				
			}
		</script>";
?>

	<script type="text/javascript" language="javascript">	
		 
		function fillForm(valor){		
			if (valor != null) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'aluno_busca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						$("input[name=id]").val(valor);
						$("input[name=nome]").val(response.nome);	
						$("input[name=cpf").val(response.cpf);
						$("input[name=matricula]").val(response.matricula);
						$("select[name=curso]").val(response.id_curso);  
						$("input[name=responsavel1]").val(response.responsavel1);    
						$("input[name=responsavel2]").val(response.responsavel2);                
					}
				});				
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
		
		function valida(){
			if (formulario.nome.value == ""){
					alert("Digite o nome")
				return (false)
			}
			
			if (formulario.cpf.value == ""){
				alert("Digite o CPF")
				return (false)
			}
			
			if(TestaCPF(formulario.cpf.value)==false){
				alert("CPF inválido")
				return (false)
			}
			
			if (formulario.data_nasc.value == ""){
				alert("Digite a matrícula")
				return (false)
			}
			
			if (formulario.matricula.value == ""){
				alert("Digite a matrícula")
				return (false)
			}
			
			//comparar idade para campo responsavel
			/*if (formulario.responsavel1.value == ""){
				//habilitar outro campo responsavel somente se o primeiro estiver preenchido
				alert("Adicione um responsável")
				return (false)
			}*/
			
			if (formulario.responsavel1.value != "" && formulario.responsavel2.value != ""){				
				var str1 = document.getElementById('responsavel1').value;
				var str2 = document.getElementById('responsavel2').value;
				var n = str1.localeCompare(str2); 
				if(n != 0){
					//verificar se senha do segundo campo é a mesma do primeiro
					alert("Os responsaveis estão iguais, insira outro responsavel ou deixe o campo vazio")
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
                            Listagem de Alunos
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
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Matrícula</th>
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
							$id = $obj -> id_aluno;
							$nome = $obj -> nome;
							$matricula = $obj -> matricula;
							$cpf = $obj -> cpf;
							$cont += 1;	
				echo "							
					<tr>
						<th>$cont</th>
						<td>$nome</td>	
						<td>$matricula</td>	
						<td>$cpf</td>	
						<td><input type='checkbox' name='ativo'></td>                             
		                                <td>
		                                    <div class='pull-right'>
		                                        <a type='button' class='btn btn-success' name='editar' data-toggle='modal'  data-target='#myModal' onClick='fillForm($id)' rel='modal' id='salvar' name='salvar' title='Editar'>
		                                            <i class='glyphicon glyphicon-edit'></i> Editar</a>&nbsp&nbsp&nbsp&nbsp
		                                "; ?> <a type='button' class='btn btn-danger' name='Deletar' href='Aluno.php?acao="excluir"&&id=<?php echo  $id?>'> 
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
            
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                       <h2><p style="text-align: center; font-weight: bold;">Cadastro de Alunos</p></h2>
                         <form role="form" action="Aluno.php?salvar=true" method="POST" name='formulario' onSubmit="return valida()">
                             <input type="hidden" id="id" name="id">
                             <div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-3">
                                    <label>Nome</label>
                                    <input type="text" style="width: 210px;" class="form-control" placeholder="Fulano de Tal" id="nome" name="nome">
                                </div>
                                <div class="col-lg-3" style="margin-left:20px">
                                    <label>CPF</label>
                                    <input style="width: 210px;" class="form-control" placeholder="12312312312" id="cpf" name="cpf">
                                </div>
                                <div class="col-lg-2" style="margin-left:20px">
                                    <label>Matrícula</label>
                                    <input style="width: 210px;" class="form-control" placeholder="1234567890987654321" id="matricula" name="matricula">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-left: 25px;">
                                <div class="col-lg-3">
					<tr>
						<td>
							Data de Nascimento</br>
							<input type='text' id='data_nasc' name='data_nasc' size='20'>
							<input type="reset" id="bt_inicio" value=" ... ">

							<script type="text/javascript">
								Calendar.setup({
									inputField	 :	"data_nasc",
									ifFormat	   :	"%d/%m/%Y",
									showsTime	  :	true,
									button		 :	"bt_inicio",
									singleClick	:	true,
									step		   :	1,
									disableFunc: function(date) {
										var now= new Date();
										return (date.getTime() > now.getTime());
									}
								});
							</script>			
						</td>
					</tr>
                                </div>                                
                                <div class="col-lg-3" style="margin-left:20px">
                                    <!-- Tratar autocomplete-->
                                    <label>Responsavel 1</label>
					<select id="responsavel1" name="responsavel1" class="grid_5">
						<option value="">Escolha um responsável:</option><?php							
						foreach($gLista as $objg){
							$id_responsavel = $objg -> id_responsavel;
							$nomeg = $objg -> nome;							
							echo "<option value='$id_responsavel' >$nomeg</option>";	
						}?>									
					</select><br/><br/>
                                </div>
                                <div class="col-lg-3" style="margin-left:20px">
                                     <label>Responsavel 2</label>
					<select id="responsavel2" name="responsavel2" class="grid_5">
						<option value="">Escolha um responsável:</option><?php							
						foreach($gLista as $objg){
							$id_responsavel = $objg -> id_responsavel;
							$nomeg = $objg -> nome;							
							echo "<option value='$id_responsavel' >$nomeg</option>";	
						}?>									
					</select><br/><br/>
                                </div>
                            </div>
                        	<div class="form-group row" style="margin-left: 25px;">
	                        	<div class="col-lg-4">
		                            <label>Curso</label>
						<select name='curso'>
							<option value="">Selecione o curso: </option>
							<option value="1">Técnico em Agropecuária</option>
							<option value="2">Técnico em Agroindustria</option>
							<option value="3">Técnico em Informática</option>
							<option value="4">Técnico em Informática para Internet</option>						
							<option value="5">TADS</option>
						</select> 
		                        </div>
		                        <div class="col-lg-3" style="margin-left:15px">
		                            <label>Senha</label>
		                            <input type="password" style="width: 150px;" class="form-control" placeholder="********" id="senha" name="senha">
		                        </div>
		                        <div class="col-lg-3" style="margin-left:12px">
		                            <label>Repetir a Senha</label>
		                            <input type="password" style="width: 150px;" class="form-control" placeholder="********" id="senha1" name="senha1">
                                </div>
                            </div>
                            <div style="margin-left: 80%; margin-bottom: 25px;">
                                <button type="submit" class="glyphicon glyphicon-check botao1 btn btn-primary" name="inserir" data-toggle="modal" data-target=".bd-example-modal-lg" id='salvar'> Salvar</button>
                            </div>                          
                        </form>     
                    </div>
                </div>
            </div>
    </div> <!-- div aberta na index.php -->
</body>
</html>
