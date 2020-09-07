<?php
    require_once 'header.php';
    require_once '../config.php';
    require_once "../core/controller/AreaConhecimentos.php";
    require_once "../core/model/AreaConhecimento.php";
    require_once "../core/controller/Visualizacoes.php";
    require_once "../core/model/Visualizacao.php";
    require_once "../core/controller/Unidades.php";
    require_once "../core/model/Unidade.php";


    use core\controller\AreaConhecimentos;
    use core\controller\Visualizacoes;
    use core\controller\Unidades;
    
    $areaConhecimento = new AreaConhecimentos();
    $visualizacao = new Visualizacoes();
    $unidade = new Unidades();

    $areaConhecimentos = $areaConhecimento->listarAreas();
    $periodos = $visualizacao->listarPeriodo();
    $unidades = $unidade->listarUnidades();

    $anoMax = max(array_column($periodos, 'anoLetInicio'));
    $anoMin = min(array_column($periodos, 'anoLetInicio'));
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
                                <label class="ml-1">Períodos:</label>
                                <span class="ml-1 intervalo-ano" data-max="<?= $anoMax ?>" data-min="<?= $anoMin ?>"></span>
                                <div class="slider-range mr-2" id="ano"></div>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">
                                <label class="ml-1">Gênero</label><br>
                                <select data-placeholder="Escolha o gênero" class="mp-select" id="sexo" multiple="multiple">
                                    <option value="F" selected>Feminino</option>
                                    <option value="M" selected>Masculino</option>
                                </select>
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">
                                <label class="ml-1">Unidade de Ensino</label><br>
                                <select data-placeholder="Escolha o campus" class="mp-select" id="campus" multiple="multiple">
                                    <?php 
                                        if (count((array)$unidades) > 0) {
                                            foreach ($unidades as $key => $value) {
                                                echo "<option value='$value->codigo' selected>$value->descricao</option>";
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
                                    <?php 
                                        if (count((array)$areaConhecimentos) > 0) {
                                            foreach ($areaConhecimentos as $key => $value) {
                                                echo "<option value='$value->codigo' selected>$value->descricao</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </span>
                        </li>
                    </ul>


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

                    <!-- <select class="custom-select custom-select-sm" id="tipoVerticalizacao">
                        <option selected value="0">Independente de Eixo</option>
                        <option value="1">Mesmo Eixo</option>
                        <option value="2">Fora do Eixo</option>
                    </select> -->

                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-8" id="gBar">
                    <div class="spinner-grow loader-graficos" role="status" hidden></div>
                    <canvas class="" width="700" height="500" id="chartBar"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="row" id="gVert">
                        <canvas class="" width="365" height="250" id="chartVert"></canvas>
                    </div>
                    <div class="row" id="gRein">
                        <canvas class="" width="365" height="250" id="chartReingresso"></canvas>
                    </div>
                </div>                    
            </div>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 mt-4">
                <h2 class="titulo">Detalhamento</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <select class="custom-select custom-select-sm" id="faseVerticalizacao">
                        <option value="0" selected>Independente da fase</option>
                        <option value="1">Verticalização Concluída</option>
                        <option value="2">Verticalização Não Concluída</option>
                        <option value="3">Verticalização em Fluxo</option>
                        <option value="4">Verticalização Reingresso Concluída</option>
                        <option value="5">Verticalização Reingresso Não Concluída</option>
                        <option value="6">Verticalização Reingresso em Fluxo</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Unidade de Ensino</th>
                            <th scope="col">Área de Conhecimento</th>
                            <th scope="col">2009</th>
                            <th scope="col">2010</th>
                            <th scope="col">2011</th>
                            <th scope="col">2012</th>
                            <th scope="col">2013</th>
                            <th scope="col">2014</th>
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
                            <td scope="row" colspan="14" class="align-middle text-center">Esperando resultados!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php
    require_once 'footer.php';
?>