<?php 	
	include "index.php";
	
	require '../model/Ocorrencia.class.php';
	require '../dao/OcorrenciaDAO.class.php';
	
	require '../model/Aluno_Ocorrencia.class.php';
	require '../dao/Aluno_OcorrenciaDAO.class.php';
	
	require '../model/Comentario.class.php';
	require '../dao/ComentarioDAO.class.php';
	
	function inserirAluno_Ocorrencia($id_ocorrencia, $id_aluno){			
		$aluno_ocorrencia = new Aluno_Ocorrencia();
		$dao_aluno_ocorrencia = new Aluno_OcorrenciaDAO();
		
		$aluno_ocorrencia -> id_ocorrencia = $id_ocorrencia;
		$aluno_ocorrencia -> id_aluno = $id_aluno;
		
		$retorno = $dao_aluno_ocorrencia->inserir($aluno_ocorrencia);
						
	}
	
	function buscaOcorrencia($id_ocorrencia){
		$dao = new OcorrenciaDAO();
		$dados_ocorrencia = $dao->buscarChavePrimaria($id_ocorrencia);
		//$id_ocorrencia = $dados_ocorrencia -> id_ocorrencia;
		
		return $dados_ocorrencia;
	}
	
	function buscaAlunoOcorrencia($id_ocorrencia){
		$dao = new Aluno_OcorrenciaDAO();
		$alunos = $dao->buscarAlunoOcorrencia($id_ocorrencia);
		//$id_ocorrencia = $dados_ocorrencia -> id_ocorrencia;
		
		return $alunos;
	}
	
	
	if (isset($_GET['salvar'])){
		$ocorrencia = new Ocorrencia();
		$dao = new OcorrenciaDAO();
		
		/*$data_cadastro = $_POST["data_cadastro"];
		$id_solicitante = $_POST["id_solicitante"];
		$id_autuador = $_POST["id_solicitante"];
		$id_tipo_ocorrencia = $_POST["id_tipo_ocorrencia"];
		*/
		$ocorrencia -> data_cadastro = $_POST["data_cadastro"];
		$ocorrencia -> id_autuador = $_POST["id_autuador"];
		$ocorrencia -> id_tipo_ocorrencia = $_POST["id_tipo_ocorrencia"];
		
		if ((isset($_POST['id_solicitante'])) && ($_POST['id_solicitante'] != '')){
			$ocorrencia -> id_solicitante = $_POST["id_solicitante"];					
		}
		else{
			$ocorrencia -> id_solicitante = null;	
		}		
		
		$id_aluno = $_POST['id_aluno'];
		
		/*if ((isset($_POST['id_solicitante'])) && ($_POST['id_solicitante'] != '')){
			$aluno -> id_solicitante = $_POST["id_solicitante"];
		}
		else{
			$aluno -> id_solicitante = null;
		}*/
		
		//Chamo a DAO e mando inserir
		if ((!isset($_POST['id'])) || ($_POST['id'] == '')){
			$retorno = $dao->inserir($ocorrencia);			
			$id_ocorrencia = $retorno;
			
			inserirAluno_Ocorrencia($id_ocorrencia, $id_aluno);
			
			$dados_ocorrencia = buscaOcorrencia($id_ocorrencia);
			
			//objeto utilizado no formulario
			$alunos = buscaAlunoOcorrencia($id_ocorrencia);
		
			$data_cadastro = date('d/m/Y', strtotime($dados_ocorrencia -> data_cadastro));
			$id_tipo_ocorrencia = $dados_ocorrencia -> id_tipo_ocorrencia;
			
			if($dados_ocorrencia -> solicitante != null && $dados_ocorrencia -> id_solicitante != null){
				$solicitante = $dados_ocorrencia -> solicitante;
				$id_solicitante = $dados_ocorrencia -> id_solicitante;
			}
			else{
				$solicitante = "";
				$id_solicitante = "";
			}
			
			if ($alunos > 0){
				echo '<script type="text/javascript" language="javascript">
					  		$(document).ready(function() {	 
					  			$("#tipo_comentario1").attr("disabled", false);
						  		$("#tipo_comentario2").attr("disabled", false);
						  		$("#comentario").attr("disabled", false);
							});
					  </script>';
			}	
		}

		else{	//inserir mais de um aluno
			$id_ocorrencia = $_POST["id"];
			
			$ocorrencia -> id_ocorrencia = $id_ocorrencia;
			$retorno = $dao->alterar($ocorrencia);
			
			inserirAluno_Ocorrencia($id_ocorrencia, $id_aluno);
			
			$dados_ocorrencia = buscaOcorrencia($id_ocorrencia);
			$alunos = buscaAlunoOcorrencia($id_ocorrencia);
			
			$data_cadastro = date('d/m/Y', strtotime($dados_ocorrencia -> data_cadastro));
			$id_tipo_ocorrencia = $dados_ocorrencia -> id_tipo_ocorrencia;
			$solicitante = $dados_ocorrencia -> solicitante;
			$id_solicitante = $dados_ocorrencia -> id_solicitante;
			
			if ($alunos > 0){
				echo '<script type="text/javascript" language="javascript">
					  		$(document).ready(function() {	 
					  			$("#tipo_comentario1").attr("disabled", false);
						  		$("#tipo_comentario2").attr("disabled", false);
						  		$("#comentario").attr("disabled", false);
							});
					  </script>';
			}	
				
		}
					
	}
	
	else{
		$id_ocorrencia = '';
		$id_tipo_ocorrencia = '';
		$data_cadastro = Date("d/m/y");
		$solicitante = '';
		$id_solicitante = '';
	}
	
	if (isset($_GET['salvarComentario'])){
		$comentario = new Comentario();
		$dao = new ComentarioDAO();
		
		$comentario -> id_ocorrencia = $_POST["id_ocorrencia"];
		$comentario -> id_usuario = $_POST["id_usuario"];
		$comentario -> data_cadastro = Date("d/m/y");
		$comentario -> comentario = $_POST["comentario"];
		$comentario -> tipo_comentario = $_POST["tipo_comentario"];
		
		/*if ((isset($_POST['id_solicitante'])) && ($_POST['id_solicitante'] != '')){
			$aluno -> id_solicitante = $_POST["id_solicitante"];
		}
		else{
			$aluno -> id_solicitante = null;
		}*/
		
		//Chamo a DAO e mando inserir
		if ((!isset($_POST['id_comentario'])) || ($_POST['id_comentario'] == '')){			
			$retorno = $dao->inserir($comentario);				
			echo "
				<script language='Javascript'>
					location.href='ListagemOcorrencia.php';
				</script>
			";
//		$dadosOcorrencia = $dao -> buscarChavePrimaria($_POST["id"]);
		}

		else{		
			$id_comentario = $_POST["id_comentario"];
			
			$comentario -> id_comentario = $id_comentario;
			$retorno = $dao->alterar($comentario);
			
		}			
	}
	
	
	if(isset($_GET['editar'])){
		$id_ocorrencia = $_GET['idListaOcorrencia'];
		$dados_ocorrencia = buscaOcorrencia($id_ocorrencia);
		$alunos = buscaAlunoOcorrencia($id_ocorrencia);
		
			$data_cadastro = date('d/m/Y', strtotime($dados_ocorrencia -> data_cadastro));
			$id_tipo_ocorrencia = $dados_ocorrencia -> id_tipo_ocorrencia;
			$solicitante = $dados_ocorrencia -> solicitante;
			$id_solicitante = $dados_ocorrencia -> id_solicitante;
			
			if ($alunos > 0){
				echo '<script type="text/javascript" language="javascript">
					  		$(document).ready(function() {	 
					  			$("#tipo_comentario1").attr("disabled", false);
						  		$("#tipo_comentario2").attr("disabled", false);
						  		$("#comentario").attr("disabled", false);
							});
					  </script>';
			}			
			
		$daoComentario = new ComentarioDAO();
		$listaComentario = $daoComentario->listar($id_ocorrencia); 
		
	}
	
	//campo selecionado no select do tipo de ocorrencia
	function selected( $value, $selected ){
		return $value==$selected ? ' selected="selected"' : '';
	}
	
?>

	<script type="text/javascript" language="javascript">				
			$(function() {
				//autocomplete
				$("#solicitante").autocomplete({
					source: "cadastroOcorrencia_solicitante_autocomplete.php",
					minLength: 1,
					select: function( event, ui ) {
						$("#id_solicitante").val(ui.item.id_solicitante);
					}
				});	
			});
			
			$(function() {
			//autocomplete
				$("#aluno").autocomplete({
					source: "cadastroOcorrencia_aluno_autocomplete.php",
					minLength: 1,
					select: function( event, ui ) {
						$("#id_aluno").val(ui.item.id_aluno);
					}
				});	
			});
			/*
			$("#enable").click(function (){
				// habilita o campo 
				$("#tipo_comentario").prop("disabled", false);
				$("#comentario").prop("disabled", false);
		
			});
			*/
			
			function excluirAluno(idAluno, idOcorrencia){
				alert("Entrou no onClick excluirAluno.");
				alert(idAluno);
				alert(idOcorrencia);
				if (idAluno != "") {
					var r=confirm("Excluir aluno selecionado da ocorrência?");
					if (r==false) {
						return false;
					}
				}
				
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'cadastroOcorrencia_excluirAluno.php',
					async: true,
					data: { idAluno: idAluno, idOcorrencia: idOcorrencia},
					success: function(response) {
						/*if(response == 1){
							alert("Aluno excluído da ocorrência com sucesso.");
						}
						else{
							if(response == 0){
								alert("Impossível excluir. Há apenas um aluno na ocorrência.");
							}
							else(response == 2){
								alert("Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.");
							}
						}*/
					}
				});			
				
			}
			
			function validaOcorrencia(){			
				if (formulario.data_cadastro.value == ""){
					alert("Digite a data")
					return (false)
				}
			
				if (formulario.id_tipo_ocorrencia.value == ""){
					alert("Informe o tipo de ocorrencia")
					return (false)
				}
				
				if (formulario.aluno.value == ""){
					alert("Informe um aluno")
					return (false)
				}
				
				if (formulario.id_aluno.value == ""){
					alert("Houve um erro ao inserir aluno. Por favor, insira o nome do aluno novamente")
					return (false)
				}
																			
				formulario.submit();
			
			}
			
			function validaComentario(){
				if (formulario.data_cadastro.value == ""){
					alert("Digite a data")
					return (false)
				}
			
				if (formulario.id_tipo_ocorrencia.value == ""){
					alert("Informe o tipo de ocorrencia")
					return (false)
				}
				
								
				if (formulario_comentario.tipo_comentario.value == ""){
					alert("Informe o tipo de comentario")
					return (false)
				}
				
				if (formulario_comentario.comentario.value == ""){
					alert("Digite uma descrição ou comentário sobre a ocorrencia")
					return (false)
				}			
				
			}
			
			$('#myModal').on('shown.bs.modal', function () {
			  $('#myInput').focus()
			})	
	</script>

		<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Cadastro de ocorrência
                        </h1>
                    </div>
				</div>
				 <div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12">
						<div class="col-lg-12">
							<button class="glyphicon glyphicon-check btn btn-success"> Solicitar encaminhamento </button>
							<button class="glyphicon glyphicon-check btn btn-success"> Notificar responsáveis</button>
						</div>
					</div>
				</div>
                <form role="form" action="CadastroOcorrencia.php?salvar=true" method="POST" name='formulario' onSubmit="return validaOcorrencia()">
                	<div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-1">
	                        <label>Código</label>
	                        <input style="width: 70px;" class="form-control" placeholder="150" id="id" name='id' value='<?php echo $id_ocorrencia;?>' readonly >
	                    </div>
	                    <div class="col-lg-2">
	                        <label>Data de cadastro</label>
	                        <input id="data_cadastro" name='data_cadastro' value='<?php echo $data_cadastro;?>' style="width: 150px;" class="form-control" placeholder="28/09/2016" maxlength="14" readonly>
	                    </div>
	                    <div class="col-lg-3">
	                    	<label>Tipo de Ocorrência</label>
	                    	<select class="form-control" name="id_tipo_ocorrencia" id="id_tipo_ocorrencia">
		                    	<option value=""></option>
	                    		<option value="1"<?php echo selected( '1', $id_tipo_ocorrencia ); ?>>Di&aacute;logo com turma</option>
	                    		<option value="2"<?php echo selected( '2', $id_tipo_ocorrencia ); ?>>Di&aacute;logo com aluno</option>
	                    		<option value="3"<?php echo selected( '3', $id_tipo_ocorrencia ); ?>>Di&aacute;logo com respons&aacute;vel</option>
	                    		<option value="4"<?php echo selected( '4', $id_tipo_ocorrencia ); ?>>Di&aacute;logo com professor</option>
	                    		<option value="5"<?php echo selected( '5', $id_tipo_ocorrencia ); ?>>Ocorr&ecirc;ncia</option>
	                    	</select>
	                    </div> 
	                </div>
	                <div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-3">
	                        <label>Responsável pela ocorr&ecirc;ncia</label>
	                        <input style="width: 245px;" class="form-control" maxlength="14" id='autuador' name='autuador' value='<?php echo $nomeUsuario;?>' readonly />
	                        <input type="hidden" name="id_autuador" id="id_autuador"  value='<?php echo $idUsuario;?>'   />
	                    </div>
	                    <div class="col-lg-3">
	                        <label>Solicitante</label>
	                        <input style="width: 245px;" class="form-control" maxlength="14" id='solicitante' name='solicitante' value='<?php echo $solicitante;?>'  />
	                        <input type="hidden" name="id_solicitante" id="id_solicitante"  value='<?php echo $id_solicitante;?>'   />
	                    </div>
	                </div>
	                <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <label>Aluno envolvido</label>
	                        <input style="width: 240px;" class="form-control" placeholder="Aluno envolvido na ocorrência" id='aluno' name='aluno'>
	                        <input name="id_aluno" type="hidden" id="id_aluno" value=""  />
	                    </div>
	                    <div class="col-lg-3">
	                        <button class="glyphicon glyphicon-plus btn btn-primary" style="margin-top:23px"  ></button>
						</div>
                    </div>
                    <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-12">
	                        <label id="alunos" name="alunos">Alunos envolvidos: </label><br/>
	                   <?php
	                   if(isset($alunos)){
	                   		if($alunos != 0){
	                   			foreach($alunos as $obj){
									$id = $obj -> id_aluno;
									$nome = $obj -> nome;
									
									echo "
										<span value=$id class='label label-primary'> $nome </span><span style='cursor:pointer' onClick='excluirAluno($id, $id_ocorrencia);' class='label label-danger'><i class='glyphicon glyphicon-remove'></i></span>
									";
	                   			}
	                   		}
	                   	}
	                   ?>     	
	                    </div>
                    </div>
                </form>
                <form role="form" name="formulario_comentario" onSubmit="return validaComentario()" action="CadastroOcorrencia.php?salvarComentario=true" method="POST" >
                    <div class="form-group row" style="margin-left: 15px;">
                    <input  type="hidden" id="id_comentario" name="id_comentario" />
                    <input  type="hidden" id="id_ocorrencia" name="id_ocorrencia" value='<?php echo $id_ocorrencia; ?>' />
                    <input type="hidden" name="id_usuario"  id="id_usuario" value='<?php echo $idUsuario;?>' />
					<div class="col-lg-12">
						<label>Intera&ccedil;ão</label>
						<div class='row' style="margin-left: 0px;">
							<input type='radio' name='tipo_comentario' id='tipo_comentario1' value='1' disabled="disabled" >
							<label for='publico'>Público</label>
							<input type='radio' name='tipo_comentario' id='tipo_comentario2' value='0' disabled="disabled" >
							<label for='privado'>Privado</label>
						</div>                            
					</div>
					<div class="row" style="margin-top: 10px">
						 <div class="col-lg-12">
							<div class="form-group">
								<div class="col-lg-12">
									<textarea rows="6" id="comentario" name="comentario" disabled="disabled" class="form-control"></textarea>
								</div>
							</div>
						</div>
					</div>
                    <div class="row" style="margin: 10px;">
						 <div class="col-lg-12">
							<div class="form-group pull-right">
								<button class="glyphicon glyphicon-check btn btn-primary pull-right"> Salvar</button>
							</div>  
						</div>
					</div>      
                </form>                
				<div class="panel-body">
					<table class="table table-hover fundotable">
						<thead>
							<tr></tr>
							<tr style="background-color: #CDCDCD;">
								<th style="width:210px">Usuário</th>
								<th>Mensagem</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($listaComentario)){
								if($listaComentario != 0){
									foreach($listaComentario as $obj){
										$usuario = $obj -> nome;
										$comentario = $obj -> comentario;
										
										echo "
											<tr>
												<td>$usuario</td>
												<td>$comentario</td>
											</tr>
										";
									}
								}
							}
							
							else{
						echo"	
							<tr>
								<td>Usuário</td>
								<td>Nenhum comentário ou interação registrado.</td>
							</tr>";
							}?>                                
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div> 						              
			</div>
		</div>
	</body>
</html>
