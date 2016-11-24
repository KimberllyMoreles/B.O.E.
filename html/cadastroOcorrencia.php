<?php 
	include "index2.php";
	
	$hoje = Date("d/m/y");
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
                <form role="form">
                	<div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-1">
	                        <label>Código</label>
	                        <input style="width: 70px;" class="form-control" placeholder="150" disabled>
	                    </div>
	                    <div class="col-lg-2">
	                        <label>Data de cadastro</label>
	                        <input style="width: 150px;" class="form-control" placeholder="28/09/2016" maxlength="14" value=<?php echo $hoje?>>
	                    </div>
	                    <div class="col-lg-3">
	                    	<label>Tipo de Ocorrência</label>
	                    	<select class="form-control" name="" id="">
		                    	<option value=""></option>
	                    		<option value="1">Di&aacute;logo com turma</option>
	                    		<option value="1">Di&aacute;logo com aluno</option>
	                    		<option value="1">Di&aacute;logo com respons&aacute;vel</option>
	                    		<option value="1">Di&aacute;logo com professor</option>
	                    		<option value="1">Ocorr&ecirc;ncia</option>
	                    	</select>
	                    </div>
	                </div>
	                <div class="form-group row" style="margin-left: 15px;">
	                    <div class="col-lg-3">
	                        <label>Responsável pela ocorrência</label>
	                        <input style="width: 240px;" class="form-control" placeholder="Pessoa logada no sistema">
	                    </div>
	                    <div class="col-lg-3">
	                        <label>Solicitante</label>
	                        <input style="width: 245px;" class="form-control" maxlength="14" id='solicitante' name='solicitante'>
	                        <input name="id_solicitante" type="hidden" id="id_solicitante" value="" size="20"  />
	                    </div>
	                </div>
	                <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <label>Aluno envolvido</label>
	                        <input style="width: 240px;" class="form-control" placeholder="Aluno envolvido na ocorrência" id='aluno' name='aluno'>
	                        <input name="id_aluno" type="hidden" id="id_aluno" value="" size="20"  />
	                    </div>
	                    <div class="col-lg-3">
	                        <button class="glyphicon glyphicon-plus btn btn-primary" style="margin-top:23px"></button>
	                    </div>
                    </div>
                    <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <label>Alunos envolvidos: <br>
	                        <span class="label label-primary">Tainã Milano</span> <span class="label label-primary">Almir Milano</span></label>
	                    </div>
                    </div>
                    <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-3">
	                        <span class="label label-primary" id="basic-addon2">Tainã Milano</span> <span class="label label-primary">Almir Milano</span></label>
	                    </div>
                    </div>
                    <div class="form-group row" style="margin-left: 15px;">
                    	<div class="col-lg-4">
                    		<label>Interação</label>
                            <div class='row' style="margin-left: 0px;">
                                <input type='radio' name='tipo' id='publico'>
                                <label for='publico'>Público</label>
                                <input type='radio' name='tipo' id='privado'>
                                <label for='privado'>Privado</label>
                            </div>
                    		<textarea rows="6" cols="140" style="border-radius:10px" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."></textarea>
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
