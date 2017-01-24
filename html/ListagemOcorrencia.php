<?php	
	include 'index.php';
	require '../model/Ocorrencia.class.php';
	require '../dao/OcorrenciaDAO.class.php';
	
	$dao = new OcorrenciaDAO();
		
	if(isset($_POST["txtFiltro"])){
    	$lista = $dao->listar($_POST["txtFiltro"]); 
 	}     	
 	else{
    	$lista = $dao->listar(); 
 	}
?>

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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary" onclick="window.location.href='CadastroOcorrencia.php';">
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
									echo $nomeAluno . " ";
								}
							}						
                        		echo"</td>	                             
		                                <td>
		                                    <div class=''>
                                                <a type='button' class='btn btn-primary' name='Historico' href=''> <i class='glyphicon glyphicon-search'></i> Histórico</a>
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

                            <br><br>
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
                            <br><br><br>

                            <table class="table table-striped table-bordered table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>Usuário</th>
                                        <th>Data de Cadastro</th>
                                        <th class="col-span-8">Mensagem</th>
                                    </tr>
                                </thead>
                                <tbody>                 
                                    <tr>
                                        <th>Boo</th>
                                        <td>17/10/2016</td> 
                                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>    
                                    </tr>
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
        </div> <!-- div aberta na index.php -->
    </div>
</body>
</html>
