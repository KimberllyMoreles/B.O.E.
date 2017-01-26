<?php	
	include 'index.php';
	require '../model/Aluno.class.php';
	require '../dao/AlunoDAO.class.php';	
	
	$dao = new AlunoDAO();

	if(isset($_POST["txtFiltro"])){
		$lista = $dao->listar($_POST["txtFiltro"]); 
     	}     	
     	else{
		$lista = $dao->listar(); 
     	}
     		
	function salvar($aluno){	
		$dao = new AlunoDAO();
		if ((!isset($_POST["id"])) || ($_POST["id"] == '')){
			$verificaCpf = $dao -> buscarPorCpf( $_POST["cpf"]);
		
			if($verificaCpf == null){
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
				echo "<script language='Javascript'>
						alert('CPF duplicado. Por favor, verifique e tente novamente.');
					</script>";	
			}
				
		}

		else{
			$aluno -> id = $_POST["id"];		
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
	}
	
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
		$aluno -> data_nasc = $_POST["data_nasc"];
		$aluno -> observacao = $_POST["observacao"];
		
		// Declara a data
		$data =  $_POST["data_nasc"];

		// Separa em dia, mês e ano
		list($dia, $mes, $ano) = explode('/', $data);

		// Descobre que dia é hoje e retorna a unix timestamp
		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		// Descobre a unix timestamp da data de nascimento do fulano
		$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

		// Depois apenas fazemos o cálculo já citado :)
		$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

		//menor de idade
		if ($idade < 18){		
			//verifica se ao menos um dos campos de responsável está preenchido
			if ((isset($_POST['id_responsavel1'])) && ($_POST['id_responsavel1'] == '') && (isset($_POST['id_responsavel2'])) && ($_POST['id_responsavel2'] == '') ){
				//se os campos estiverem vazios alerta
				echo "<script language='Javascript'>
					alert('Alunos menores de idade necessitam do registro de um responsável');
					location.href='Aluno.php';
				</script>";	
			}	
			//se não estiverem vazios
			else{					
				if ((isset($_POST['id_responsavel1'])) && ($_POST['id_responsavel1'] != '')){
					$aluno -> responsavel1 = $_POST["id_responsavel1"];					
				}
				else{
					$aluno -> responsavel1 = null;
				}

				if ((isset($_POST['id_responsavel2'])) && ($_POST['id_responsavel2'] != '')){
					$aluno -> responsavel2 = $_POST["id_responsavel2"];					
				}
				else{
					$aluno -> responsavel2 = null;
				}
				salvar($aluno);
			}	
		}
			
		//se maior de idade
		else{					
			if ((isset($_POST['id_responsavel1'])) && ($_POST['id_responsavel1'] != '')){
				$aluno -> responsavel1 = $_POST["id_responsavel1"];					
			}
			else{
				$aluno -> responsavel1 = null;	
			}

			if ((isset($_POST['id_responsavel2'])) && ($_POST['id_responsavel2'] != '')){
				$aluno -> responsavel2 = $_POST["id_responsavel2"];
			}
			else{
				$aluno -> responsavel2 = null;	
			}				
			salvar($aluno);		
		}	
	}
?>

	<script type="text/javascript" language="javascript">	
		$(function() {
		//autocomplete
			$("#responsavel1").autocomplete({
				source: "aluno_responsavel_autocomplete.php",
				minLength: 1,
				select: function( event, ui ) {
					$("#id_responsavel1").val(ui.item.id_responsavel);
				}
			});	
		});
	
	$(function() {
		//autocomplete
		$("#responsavel2").autocomplete({
			source: "aluno_responsavel_autocomplete.php",
			minLength: 1,
			select: function( event, ui ) {
				$("#id_responsavel2").val(ui.item.id_responsavel);
			}
		});	
	});
	
		function cleanForm(){
			$("input[name=id]").val('');
			$("input[name=nome]").val('');	
			$("input[name=cpf").val('');
			$("input[name=matricula]").val('');
			$("input[name=data_nasc]").val('');
			$("select[name=curso]").val('');  
			$("input[name=responsavel1]").val('');    
			$("input[name=responsavel2]").val('');
			$("textarea[name=observacao]").val('');   
		}
		
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
						$("input[name=data_nasc]").val(response.data_nasc);
						$("select[name=curso]").val(response.id_curso);  
						$("input[name=responsavel1]").val(response.responsavel1);    
						$("input[name=responsavel2]").val(response.responsavel2);
						$("textarea[name=observacao]").val(response.observacao);    
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
				alert("Digite a data de nascimento do aluno")
				return (false)
			}
			
			if (formulario.matricula.value == ""){
				alert("Digite a matrícula")
				return (false)
			}			
			
			if (formulario.responsavel1.value != "" && formulario.responsavel2.value != ""){				
				var str1 = document.getElementById('responsavel1').value;
				var str2 = document.getElementById('responsavel2').value;
				var n = str1.localeCompare(str2); 
				if(n == 0){
					//verificar se senha do segundo campo é a mesma do primeiro
					alert(str1);
					alert(str2);
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
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onClick='cleanForm();'>
                                <i class="glyphicon glyphicon-check"></i> Novo cadastro</button>
                        </div>
                        <div class="col-lg-6">
							<div class="input-group pull-right">
							 <form method="post">
								<input type="text" class="form-control" name="txtFiltro" style="width: 80%;" placeholder="Nome do aluno">
								<span class="input-group-btn">
								<button class="btn btn-default pull-right" type="submit" onClick='filtro();' style="margin-left: -20px;" ><i class="glyphicon glyphicon-search"></i></button></span>
							</form>
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
                    <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>							
			</div>
                       <h2><p style="text-align: center; font-weight: bold;">Cadastro de Aluno</p></h2>
                         <form role="form" action="Aluno.php?salvar=true" method="POST" name='formulario' onSubmit="return valida()">
                             <input type="hidden" id="id" name="id">
                             <div class="row">
								 <div class="col-lg-12">
									 <div class="form-group">
										<div class="col-lg-4">
											<label>Nome</label>
											<input type="text" class="form-control" placeholder="Nome do aluno" id="nome" name="nome">
										</div>
										<div class="col-lg-4">
											<label>CPF</label>
											<input class="form-control" placeholder="000.000.000-00" id="cpf" name="cpf">
										</div>
										<div class="col-lg-4">
											<label>Matrícula</label>
											<input class="form-control" placeholder="123456789" id="matricula" name="matricula">
										</div>
									</div>
								</div>
                            </div>
                            <div class="row" style="margin-top: 10px">								
								 <div class="col-lg-12">
									<div class="form-group">
										<div class="col-lg-3">
											<label>Data de Nascimento</label>
											<input type="text" class="form-control" id="data_nasc" name="data_nasc" placeholder="dd/mm/aaaa" readonly>
										</div>
										<div class="col-lg-1">
											<label></label><br>
											<button type="button" id="bt_inicio" name="bt_inicio" style="margin-top: 3px" class="btn glyphicon glyphicon-calendar" />

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
										</div> 
										<div class="col-lg-6">
											<label>Curso</label>
											<select name='curso' class="form-control">
												<option value="">Selecione o curso: </option>
												<option value="1">Técnico em Agropecuária</option>
												<option value="2">Técnico em Agroindustria</option>
												<option value="3">Técnico em Informática</option>
												<option value="4">Técnico em Informática para Internet</option>						
												<option value="5">TADS</option>
											</select> 
										</div>
									</div>
								</div>
                            </div>
                            <div class="row" style="margin-top: 10px">
								 <div class="col-lg-12">
									<div class="form-group">										                               
										<div class="col-lg-4">
											<!-- Tratar autocomplete-->
											<label>Responsavel 1</label>
											<input class="form-control" id="responsavel1" name="responsavel1" placeholder="Nome do primeiro responsavel">
											<input name="id_responsavel1" type="hidden" id="id_responsavel1" value="" size="20"  />
										</div>
										<div class="col-lg-4">
											 <label>Responsavel 2</label>
											 <input class="form-control" id="responsavel2" name="responsavel2" placeholder="Nome do segundo responsavel">
											 <input name="id_responsavel2" type="hidden" id="id_responsavel2" value="" size="20"  />
										</div>
									</div>
								</div>
                            </div>
                            <div class="row" style="margin-top: 10px">
								 <div class="col-lg-12">
									<div class="form-group">
										<div class="col-lg-12">
											<label>Observação</label>
											<textarea rows="6" id='observacao' name='observacao' class="form-control"></textarea>
										</div>
									</div>
								</div>
                            </div>
                            <div class="row" style="margin: 10px;">
								 <div class="col-lg-12">
									<div class="form-group pull-right">
										<button type="submit" class="glyphicon glyphicon-check btn btn-primary" name="inserir" id='salvar'> Salvar</button>
									</div>  
								</div>
                            </div>                        
                        </form>     
                    </div>
                </div>
            </div>
    </div> <!-- div aberta na index.php -->
</body>
</html>
