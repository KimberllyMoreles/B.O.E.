<?php 
	session_start();
	
	include "index2.php";
	
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
		$ocorrencia -> id_solicitante = $_POST["id_solicitante"];
		$ocorrencia -> id_autuador = $_POST["id_solicitante"];
		$ocorrencia -> id_tipo_ocorrencia = $_POST["id_tipo_ocorrencia"];
		
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
			
			echo '<script type="text/javascript" language="javascript">
				  		$("#tipo_comentario1").attr("disabled", false);
				  		$("#tipo_comentario2").attr("disabled", false);
				  		$("#comentario").attr("disabled", false);
				  </script>';	
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
			
			
//		$dadosOcorrencia = $dao -> buscarChavePrimaria($_POST["id"]);
		}

		else{		
			$id_comentario = $_POST["id_comentario"];
			
			$comentario -> id_comentario = $id_comentario;
			$retorno = $dao->alterar($comentario);
			
		}			
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
			function validaOcorrencia(){			
				if (formulario.data_cadastro.value == ""){
					alert("Digite a data")
					return (false)
				}
			
				if (formulario.id_tipo_ocorrencia.value == ""){
					alert("Informe o tipo de ocorrencia")
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
			
			
			
			
	</script>

		<div>
			<div class="container-fluid">
				<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1>
                            Cadastro de ocorrência
                        </h1>
                    </div>
                    <div class="col-lg-12" style="background-color: #BEBEBE; padding: 10px;">
                    	<button class="glyphicon glyphicon-check btn btn-primary" style="background-color: #00CD00; margin-left:30px"> Solicitar encaminhamento </button>
        				<button class="glyphicon glyphicon-check btn btn-primary" style="background-color: #00CD00; margin-left:15px"> Notificar responsáveis</button>
                    </div>
                </div><br><br>
                <form role="form" action="CadastroOcorrencia.php?salvar=true" method="POST" name='formulario' onSubmit="return validaOcorrencia()">
                	<div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-1">
	                        <label>Código</label>
	                        <input style="width: 70px;" class="form-control" placeholder="150" id="id" name='id' value='<?php echo $id_ocorrencia;?>' readonly >
	                    </div>
	                    <div class="col-lg-2">
	                        <label>Data de cadastro</label>
	                        <input id="data_cadastro" name='data_cadastro' value='<?php echo $data_cadastro;?>' style="width: 150px;" class="form-control" placeholder="28/09/2016" maxlength="14" >
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
	                        <input id="autuador" name='autuador' style="width: 240px;" class="form-control" />
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
                    	<div class="col-lg-3">
	                        <label id="alunos" name="alunos">Alunos envolvidos: <br></label>
	                   <?php
	                   if(isset($alunos)){
	                   		if($alunos != 0){
	                   			foreach($alunos as $obj){
									$id = $obj -> id_aluno;
									$nome = $obj -> nome;
									
									echo "
										<span value=$id class='label label-primary'> $nome </span>
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
                    <input type="hidden" name="id_usuario"  id="id_usuario" value='<?php echo $id_solicitante;?>' />
                    	<div class="col-lg-4">
                    		<label>Intera&ccedil;ão</label>
                            <div class='row' style="margin-left: 0px;">
                                <input type='radio' name='tipo_comentario' id='tipo_comentario1' value='1' disabled="disabled" >
                                <label for='publico'>Público</label>
                                <input type='radio' name='tipo_comentario' id='tipo_comentario2' value='0' disabled="disabled" >
                                <label for='privado'>Privado</label>
                            </div>
                    		<textarea rows="6" cols="140" style="border-radius:10px" id="comentario" name="comentario" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." disabled="disabled" ></textarea>
	                    </div><br>
                    </div>
                    <div class="form-group row col-lg-12" style="margin-left: 15px;">
	                    <button class="glyphicon glyphicon-check btn btn-primary pull-right" style="margin-right: 60px"> Salvar</button>
                    </div>
                </form>
				<div class="panel-body">
                    <div>
                        <table class="table table-hover fundotable">
                            <thead>
                            	<tr></tr>
                                <tr style="background-color: #CDCDCD;">
                                    <th style="width:210px">Usuário</th>
                                    <th>Mensagem</th>
                                </tr>
                            </thead>
                            <tbody>
                              	<tr>
                                    <td>Uncompleted Profile</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                                </tr>
                                <tr>
                                    <td>Uncompleted Profile</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                                </tr>
                                <tr>
                                    <td>Uncompleted Profile</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>                
			</div>
		</div>
