<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Fonts do Google -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto&family=Source+Code+Pro&display=swap" rel="stylesheet"> 

    <!-- Estilo próprio -->
    <link rel="stylesheet" href="assets/css/estilo.css">
    <!-- <link href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/css/multiple-select.css">
    
    <title>Visualização da Verticalização</title>
</head>
<body>

    <?php

        require_once '../config.php';
        // require_once 'header.php';
        require_once "../core/controller/Visualizacoes.php";
        require_once "../core/model/Visualizacao.php";
        require_once "../core/crud/CRUD.php";

        use core\controller\Visualizacoes;

        $visualizacoes = new Visualizacoes();

        $opcoesFiltro = $visualizacoes->opcoesFiltro();

        // echo "<pre>";
        // print_r($opcoesFiltro);  

    ?>

    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3 titulo-site" href="#">
            <span data-feather="bar-chart-2"></span>
            Visual-vert
        </a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="navbar-nav px-3 ml-auto">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="glossario.php">
                    <span data-feather="book" class="mr-1"></span>
                    Glossário
                </a>
            </li>
        </ul>

        <ul class="navbar-nav px-3 ">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">
                    <span data-feather="at-sign" class="mr-1">></span>
                    Contato
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <form id="formulario-filtros">

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted">
                            <span>Dados</span>
                            
                            <span class="d-flex align-items-center text-muted" data-toggle="tooltip" data-placement="right" 
                            title="Aqui você pode filtrar os dados que podem aparecer no gráfico. Não são necessariamente os mesmos da tabela.">
                                <span data-feather="info"></span>
                            </span>
                        </h6>

                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <span class="nav-link">
                                    <!-- <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="switchAno" checked>
                                        <label class="custom-control-label" for="switchAno">Períodos</label>
                                    </div> -->
                                    <label class="ml-1">Períodos</label><br>
                                    <select data-placeholder="Escolha o período" class="mp-select" id="ano" multiple="multiple">
                                        <!-- <option value="1">Nenhum</option>
                                        <option value="0" selected>Todos</option> -->
                                        <?php 
                                            if (count((array)$opcoesFiltro["periodos"][0]) > 0) {
                                                foreach ($opcoesFiltro["periodos"] as $key => $value) {
                                                    echo "<option value='$value->anoLetInicio'>$value->anoLetInicio</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <label class="ml-1">Gênero</label><br>
                                    <select data-placeholder="Escolha o gênero" class="mp-select" id="sexo" multiple="multiple">
                                        <!-- <option value="1">Nenhum</option>
                                        <option value="0" selected>Todos</option> -->
                                        <option value="F">Feminino</option>
                                        <option value="M">Masculino</option>
                                    </select>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <label class="ml-1">Unidade de Ensino</label><br>
                                    <select data-placeholder="Escolha o campus" class="mp-select" id="campus" multiple="multiple">
                                        <!-- <option value="1">Nenhum</option>
                                        <option value="0" selected>Todos</option> -->
                                        <?php 
                                            if (count((array)$opcoesFiltro["instituicoes"][0]) > 0) {
                                                foreach ($opcoesFiltro["instituicoes"] as $key => $value) {
                                                    echo "<option value='$value->codInstituicao'>$value->descInstituicao</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <label class="ml-1">Área do Conhecimento</label><br>
                                    <select data-placeholder="Escolha a área" class="mp-select" id="area" multiple="multiple">
                                        <!-- <option value="1" selected>Nenhum</option>
                                        <option value="0">Todos</option> -->
                                        <?php 
                                            if (count((array)$opcoesFiltro["areas"][0]) > 0) {
                                                foreach ($opcoesFiltro["areas"] as $key => $value) {
                                                    echo "<option value='$value->codAreaConhecimento'>$value->descAreaConhecimento</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </span>
                            </li>
                        </ul>

                        <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Tabela</span>
                            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                                <span data-feather="info"></span>
                            </a>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    Current month
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file-text"></span>
                                    Year-end sale
                                </a>
                            </li>
                        </ul> -->

                        <div class="btn-sm clearfix mr-2">
                            <button type="submit" class="btn btn-secondary btn-sm float-right">
                                <span data-feather="filter"></span>
                                Filtrar
                            </button>
                        </div>                        
                    </form>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mb-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 titulo">Visualização</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">

                        <select class="custom-select custom-select-sm">
                            <option selected value="1">Independente de Eixo</option>
                            <option value="2">Mesmo Eixo</option>
                            <option value="3">Fora do Eixo</option>
                        </select>

                    </div>
                </div>

                <!-- <div id="aqui" style="border-stye:solid; width:100%; height:500px; display:flex"></div> -->
                <canvas class="my-4 w-85" id="myChart" width="850" height="400"></canvas>
                
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 mt-4">
                    <h2 class="titulo">Detalhamento</h2>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <select class="custom-select custom-select-sm">
                            <option selected value="1">Em Fluxo</option>
                            <option value="2">Não Concluída</option>
                            <option value="3">Concluída</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th scope="col">Unidade de Ensino</th>
                                <th scope="col">Área de Conhecimento</th>
                                <th scope="col">2015</th>
                                <th scope="col">2016</th>
                                <th scope="col">2017</th>
                                <th scope="col">2018</th>
                                <th scope="col">2019</th>
                                <th scope="col">2020</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row" rowspan="2" class="align-middle">Ceres</td>
                                <td>Exatas</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td>Biológicas</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td scope="row" rowspan="4" class="align-middle">Rio Verde</td>
                                <td>Exatas</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td>Biológicas</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td>Engenharias</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                            <tr>
                                <td>Sociais e Aplicadas</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                                <td>12%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="assets/js/multiple-select.js"></script>
    <script src="assets/js/visualizacao.js"></script>

</body>
</html>