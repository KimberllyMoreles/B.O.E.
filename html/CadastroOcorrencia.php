<?php 
	include "index2.php";
	require '../model/Ocorrencia.class.php';
	require '../dao/OcorrenciaDAO.class.php';
	
	require '../model/Aluno_Ocorrencia.class.php';
	require '../dao/Aluno_OcorrenciaDAO.class.php';
	
	$hoje = Date("d/m/y");
	
	
	function inserirAluno_Ocorrencia($id_ocorrencia, $id_aluno){			
		$aluno_ocorrencia = new Aluno_Ocorrencia();
		$dao_aluno_ocorrencia = new Aluno_OcorrenciaDAO();
		
		$aluno_ocorrencia -> id_ocorrencia = $id_ocorrencia;
		$aluno_ocorrencia -> id_aluno = $id_aluno;
		
		$retorno = $dao_aluno_ocorrencia->inserir($aluno_ocorrencia);	
	}
	
	if (isset($_GET['salvar'])){
		$ocorrencia = new Ocorrencia();
		$dao = new OcorrenciaDAO();
		
		$ocorrencia -> data_cadastro = $_POST["data_cadastro"];
		$ocorrencia -> id_solicitante = $_POST["id_solicitante"];
		$ocorrencia -> id_autuador = $_POST["id_solicitante"];
		$ocorrencia -> id_tipo_ocorrencia = $_POST["tipo_ocorrencia"];
		
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
			
//		$dadosOcorrencia = $dao -> buscarChavePrimaria($id);
		}

		else{		
			$id_ocorrencia = $_POST["id"];
			
			$ocorrencia -> id_ocorrencia = $id_ocorrencia;
			$retorno = $dao->alterar($ocorrencia);
			
			inserirAluno_Ocorrencia($id_ocorrencia, $id_aluno);
		}			
	}
	
	if (isset($_GET['salvarComentario'])){
		$comentario = new Comentario();
		$dao = new ComentarioDAO();
		
		$comentario -> data_cadastro = $_POST["data_cadastro"];
		$comentario -> comentario = $_POST["comentario"];
		$comentario -> id_ocorrencia = $_POST["id"];
		$comentario -> id_usuario = $_POST["id_solicitante"];
		$comentario -> tipo_comentario = $_POST["tipo"];
		
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
			
			function validaOcorrencia(){			
				if (formulario.data.value == ""){
						alert("Digite a data")
					return (false)
				}
			
				if (formulario.tipo_ocorrencia.value == ""){
					alert("Informe o tipo de ocorrencia")
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
                            Cadastro de ocorrência
                        </h1>
                    </div>
                    <div class="col-lg-12" style="background-color: #BEBEBE; padding: 10px;">
                    	<button class="glyphicon glyphicon-check btn btn-primary" style="background-color: #00CD00; margin-left:30px"> Solicitar encaminhamento </button>
        				<button class="glyphicon glyphicon-check btn btn-primary" style="background-color: #00CD00; margin-left:15px"> Notificar responsáveis</button>
                    </div>
                </div><br><br>
                <form role="form" action="CadastroOcorrencia.php?salvar=true" method="POST" name='formulario' onSubmit="return validaOcorrencia()>
                	<div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-1">
	                        <label>Código</label>
	                        <input style="width: 70px;" class="form-control" placeholder="150" id="id" name='id' disabled>
	                    </div>
	                    <div class="col-lg-2">
	                        <label>Data de cadastro</label>
	                        <input id="data_cadastro" name='data_cadastro' style="width: 150px;" class="form-control" placeholder="28/09/2016" maxlength="14" value=<?php echo $hoje?>>
	                    </div>
	                    <div class="col-lg-3">
	                    	<label>Tipo de Ocorrência</label>
	                    	<select class="form-control" name="tipo_ocorrencia" id="tipo_ocorrencia" name="tipo_ocorrencia" >
		                    	<option value=""></option>
	                    		<option value="1">Di&aacute;logo com turma</option>
	                    		<option value="2">Di&aacute;logo com aluno</option>
	                    		<option value="3">Di&aacute;logo com respons&aacute;vel</option>
	                    		<option value="4">Di&aacute;logo com professor</option>
	                    		<option value="5">Ocorr&ecirc;ncia</option>
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
	                        <input style="width: 245px;" class="form-control" maxlength="14" id='solicitante' name='solicitante' />
	                        <input name="id_solicitante" type="hidden" id="id_solicitante" value=""   />
	                    </div>
	                </div>
	                <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <label>Aluno envolvido</label>
	                        <input style="width: 240px;" class="form-control" placeholder="Aluno envolvido na ocorrência" id='aluno' name='aluno'>
	                        <input name="id_aluno" type="hidden" id="id_aluno" value=""  />
	                    </div>
	                    <div class="col-lg-3">
	                        <button class="glyphicon glyphicon-plus btn btn-primary" style="margin-top:23px"></button>
</div>
                    </div>
                    <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <label>Alunos envolvidos: <br></label>
	                    </div>
                    </div>
                </form>
                <form role="form" onSubmit="return validaComentario()" action="CadastroOcorrencia.php?salvarComentario=true">
                    <div class="form-group row" style="margin-left: 15px;">
                    <input type="hidden" id="id_comentario" name="id_comentario" />
                    	<div class="col-lg-4">
                    		<label>Intera&ccedil;ão</label>
                            <div class='row' style="margin-left: 0px;">
                                <input type='radio' name='tipo' id='publico' value='publico'>
                                <label for='publico'>Público</label>
                                <input type='radio' name='tipo' id='privado' value='privado'>
                                <label for='privado'>Privado</label>
                            </div>
                    		<textarea rows="6" cols="140" style="border-radius:10px" id="comentario" name="comentario" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."></textarea>
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
