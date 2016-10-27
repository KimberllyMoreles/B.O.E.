<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>B.O.E</title>

    <script type="text/javascript" src="js/jquery-1.12.2.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.js"></script>  
    <script type="text/javascript" language="javascript" src="js/DataTable/jquery.dataTables.min.js"></script>  
    
    <!-- autocomplete Javascript -->
    <script src="autocomplete/js/autocomplete-min.js"></script>
    <!-- autocomplete CSS -->
    <link href="autocomplete/css/autocomplete-min.css" rel="stylesheet" />  
    
    <!-- calendar stylesheet -->
    <link rel="stylesheet" type="text/css" media="all" href="js/jscalendar-1.0/skins/aqua/theme.css" title="win2k-cold-1" />

    <!-- main calendar program -->
    <script type="text/javascript" src="js/jscalendar-1.0/calendar.js"></script>

    <!-- language for the calendar -->
    <script type="text/javascript" src="js/jscalendar-1.0/lang/calendar-br.js"></script>

    <!-- the following script defines the Calendar.setup helper function, which makes
        adding a calendar a matter of 1 or 2 lines of code. -->
    <script type="text/javascript" src="js/jscalendar-1.0/calendar-setup.js"></script>  

    <!-- Bootstrap Core CSS -->
    <link href="outros/startbootstrap-sb-admin-1.0.4/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="outros/startbootstrap-sb-admin-1.0.4/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="outros/startbootstrap-sb-admin-1.0.4/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Meus estilos -->
    <link href="css/estilo.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="outros/startbootstrap-sb-admin-1.0.4/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="outros/startbootstrap-sb-admin-1.0.4/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
    .fundotable{
        background-color: #CCCCCC;
    }
    .negrito{
        font-weight: bold;
    }
    .margemEsq{
        margin-left: 60px;
    }

    .margemTop{
        margin-top: 70px;
    }

    .margemSearch{
        margin-left: 400px;
        border-radius: 4px;
        padding: 10px 32px;
    }

    .botao1{
        background-color: #008CBA; /* Blue */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        margin-top: 25px;
    }

    .botao2{
        background-color: white;
        border: none;
        color: gray;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
    }
    
    .botaoEditar{
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
    }

    .botaoDeletar{
        background-color: #f44336; /* Red */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
    }

    .margemTable{
        margin-top: 25px;
    }

    body{
        background-color: #CCCCCC;
    }

</style>

</head>


<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">B.O.E</a>
            </div>
            <!-- Top Menu Items -->
            <div class="row">
                <form action="login.php" method="POST">
                    <input style="margin-top:2px; margin-left: 850px" type="text" name="siape" placeholder="siape">
                    <input type="password" name="senha" placeholder="********">
                    
                    <button type="submit" name="entrar" class="botao2 glyphicon glyphicon-log-in" style="border-style: none; margin-top:10px; padding-top:5px; padding-bottom:6px"></button>
                </form>
            </div>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#pessoas">
                            <i class="glyphicon glyphicon-user"></i> Pessoa
                        </a>
                        <ul id="pessoas" class="collapse nav">
                            <li>
                                <a href="Aluno.php"><i class="glyphicon glyphicon-minus "></i> Aluno</a>
                            </li>
                            <li>
                                <a href="Responsavel.php"><i class="glyphicon glyphicon-minus "></i> Responsavel</a>
                            </li>
                            <li>
                                <a href="Servidor.php"><i class="glyphicon glyphicon-minus "></i> Servidor</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#tarefas">
                            <i class="glyphicon glyphicon-list-alt"></i> Ocorrencia
                        </a>
                        <ul id="tarefas" class="collapse nav">
                            <li>
                                <a href="cadastroOcorrencia.php"><i class="glyphicon glyphicon-minus "></i> Cadastro</a>
                            </li>
                            <li>
                                <a href="#"><i class="glyphicon glyphicon-minus "></i> Listagem</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        
