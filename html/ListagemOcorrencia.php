<?php	
	include 'index.php';
	require '../model/Ocorrencia.class.php';
	require '../dao/OcorrenciaDAO.class.php';
	
	require '../model/Comentario.class.php';
	require '../dao/ComentarioDAO.class.php';
	
	$dao = new OcorrenciaDAO();
		
	if(isset($_POST["txtFiltro"])){
    	$lista = $dao->listar($_POST["txtFiltro"]); 
 	}     	
 	else{
    	$lista = $dao->listar(); 
 	}
?>
	<script type="text/javascript" language="javascript">	
		
		function fillForm(valor){			
			$('#tab_ocorrencia').empty();	
			$('#tab_alunos').empty();	
			$('#tab_comentario').empty();	
			if (valor != null) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'cadastroOcorrencia_busca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						//Adicionando registros retornados na tabela		
						var tipo_ocorrencia;
						var solicitante;			
						
						switch (response.id_tipo_ocorrencia){
							case 1:
								tipo_ocorrencia = "Diálogo com turma";
								break;
							case 2:
								tipo_ocorrencia = "Diálogo com aluno";
								break;
							case 3:
								tipo_ocorrencia = "Diálogo com responsável";
								break;
							case 4:
								tipo_ocorrencia = "Diálogo com professor";
								break;
							case 5:
								tipo_ocorrencia = "Ocorrência";
								break;
						}	
						
						if(response.solicitante == null){
							solicitante = " - ";
						}	
						else{
							solicitante = response.solicitante;
						}	
						
						var date = new Date(response.data_cadastro);
						var day = date.getDate();
						var monthIndex = date.getMonth() + 1;
						var year = date.getFullYear();
						
						var dataF = day + '/' + monthIndex + '/' + year;						
						
						$("#titulo").text(tipo_ocorrencia);				
						$('#tab_ocorrencia').append('<tr><td>'+
							dataF+'</td><td>'+
							response.responsavel+'</td><td>'+
							solicitante+'</td></tr>');
						
					}
				});
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'listagemOcorrencia_alunoBusca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						//Adicionando registros retornados na tabela	
						for(var i=0; i < response.length; i++){									
							$('#tab_alunos').append('<tr><td></td><td>'+
								response[i].nome+'</td></tr>');
						}
					}
				});
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'listagemOcorrencia_comentarioBusca.php',
					async: true,
					data: { id: valor},
					success: function(response) {
						for(var i=0; i < response.length; i++){						
							//Adicionando registros retornados na tabela	
							var date = new Date(response[i].data_cadastro);
							var day = date.getDate();
							var monthIndex = date.getMonth() + 1;
							var year = date.getFullYear();
						
							var dataF = day + '/' + monthIndex + '/' + year;	
																		
							$('#tab_comentario').append('<tr><td>'+
								response[i].nome+'</td><td>'+
								dataF+'</td><td>'+
								response[i].comentario+'</td></tr>');
						}
					}
				});				
			}
		}	
	</script>
	<script type="text/javascript" language="javascript">	
		('#myModal').on('shown.bs.modal', function () {
			  $('#myInput').focus()
			})	
	</script>
		<div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Listagem de Ocorrências
                        </h1>
                    </div>
                </div>               
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary" onclick="window.location.href='CadastroOcorrencia.php';">
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
					<div class="panel-body col-lg-12">
						<div class="table-responsive">
							 <table class="table table-striped table-bordered table-hover" id="example">
								<thead>
									<tr>
										<th>#</th>
										<th>Data da ocorrência</th>
										<th>Responsável</th>
										<th>Tipo de ocorrência</th>
										<th class="col-lg-2">Alunos envolvidos</th>
										<th></th>
									</tr>
								</thead>
								<!-- Tratar campo 'ativo -->
								<tbody>		
								<?php
									$cont = 0;
					if($lista != 0){
						foreach($lista as $obj){
							$id = $obj -> id_ocorrencia;
							$servidorResponsavel = $obj -> nome;
							$dataCadastro = date('d/m/Y', strtotime($obj -> data_cadastro));
							$id_tipo_ocorrencia = $obj -> id_tipo_ocorrencia;
							
							switch ($id_tipo_ocorrencia){
								case 1:
									$tipo_ocorrencia = "Di&aacute;logo com turma";
									break;
								case 2:
									$tipo_ocorrencia = "Di&aacute;logo com aluno";
									break;
								case 3:
									$tipo_ocorrencia = "Di&aacute;logo com respons&aacute;vel";
									break;
								case 4:
									$tipo_ocorrencia = "Di&aacute;logo com professor";
									break;
								case 5:
									$tipo_ocorrencia = "Ocorr&ecirc;ncia";
									break;
							}
							
							$cont += 1;		
									
									$alunos = $dao -> buscarAlunoOcorrencia($id);
									
					echo"<tr>
						<th>$cont</th>
						<td>$dataCadastro</td>	
						<td>$servidorResponsavel</td>	
						<td>$tipo_ocorrencia</td>
									<td>";
										if($alunos != null){
								foreach($alunos as $aluno){
									$nomeAluno = $aluno -> nome;
									echo $nomeAluno . " <br/> ";
								}
							}						
								echo"</td>	                             
										<td>
											<div class=''>
												<a type='button' class='btn btn-info' name='Historico' data-toggle='modal' data-target='#myModal' onClick='fillForm($id)' rel='modal'> <i class='glyphicon glyphicon-search' ></i> Histórico</a>												
												&nbsp&nbsp&nbsp
											   ";?> <a type='button' class='btn btn-success' name='editar' title='Editar' href="CadastroOcorrencia.php?editar=true&&idListaOcorrencia=<?php echo  $id?>">
													<i class='glyphicon glyphicon-edit'></i> Editar</a>&nbsp&nbsp&nbsp <a type='button' class='btn btn-danger' name='Deletar' href="ListagemOcorrencia.php?acao='excluir'&&id=<?php echo  $id?>"> 
													<i class='glyphicon glyphicon-trash'></i> Deletar</a>
											</div>
										</td>
									</tr><?php
											}
										}
									?>
								</tbody>
							</table>

							<nav aria-label="Page navigation" style="margin-left:40%">
								<ul class="pagination">
									<li>
										<a href="#" aria-label="Previous">
											<span aria-hidden="true">&laquo;</span>
										</a>
									</li>
									<li><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#">5</a></li>
									<li>
										<a href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										</a>
									</li>
								</ul>
							</nav>							
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.panel-body -->
				</div>
				<div class="modal fade" tabindex="-1" role="dialog" id="myModal printable"">
				  <div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>							
							<label id="titulo" name="titulo" ></label>
						</div>
						<div class="modal-body">		
						<table class="table table-striped table-bordered table-hover" id="example">				
							<thead>
								<tr>
									<th>Data</th>
									<th>Responsável</th>								
									<th>Solicitante</th>
									<!--<th class="col-lg-2">Aluno(s) envolvido(s)</th>-->
									
								</tr>
							</thead>
							<tbody id="tab_ocorrencia" name="tab_ocorrencia"></tbody>
						</table>
							<table class="table table-striped table-bordered table-hover" id="example">
								<thead>
									<tr>
										<th>Alunos envolvidos: </th>
										<th></th>
									</tr>
								</thead>
								<tbody id="tab_alunos" name="tab_alunos"></tbody>
							</table>
						</table>
							<table class="table table-striped table-bordered table-hover" id="example">
								<thead>
									<tr>
										<th>Usuário</th>
										<th>Data de Cadastro</th>
										<th class="col-span-8">Mensagem</th>
									</tr>
								</thead>
								<tbody id="tab_comentario" name="tab_comentario"></tbody>
							</table>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal --> 
            </div>            
        </div> <!-- div aberta na index.php -->
    </div>
</body>
</html>
