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
                <a class="nav-link" href="index.php">
                    <span data-feather="home" class="mr-1"></span>
                    Início
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
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse pl-2">
                <div class="sidebar-sticky pt-3 mt-3">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted">
                        <span>IF Goiano</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#coisa">
                                <span data-feather="award"></span>
                                Alguma coisa 
                                <!-- falar bem -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#lei">
                                <span data-feather="file-text"></span>
                                Lei de criação
                                <!-- verticalização faz parte de finalidade e caracteristicas -->
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted">
                        <span>Verticalização</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#conceito">
                                <span data-feather="help-circle"></span>
                                Conceito
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#variacoes">
                                <span data-feather="layers"></span>
                                Variações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#calculo">
                                <span data-feather="percent"></span>
                                Cálculo
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted">
                        <span>Dados</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#dataset">
                                <span data-feather="database"></span>
                                Dataset 
                                <!-- Falar os anos, campus, áreas do conhecimento segundo não sei o que -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#diagrama">
                                <span data-feather="grid"></span>
                                Diagrama
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mb-5">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                    <h1 class="h2 titulo">Glossário</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        Alguma coisa
                    </div>
                </div>
                
                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="coisa">
                    <div class="card-body text-justify">
                        <h1 class="h2 mb-4">Breve resumo</h1>
                        <a class="green ribbon">IF Goiano</a>
                        <p>O IF Goiano é uma autarquia federal detentora de autonomia 
                        administrativa, patrimonial, financeira, didático-pedagógica e disciplinar, equiparado às 
                        universidades federais. Oferece educação superior, básica e profissional, 
                        pluricurricular e multicampi, especializada em educação profissional e tecnológica 
                        nas diferentes modalidades de ensino. Atende atualmente mais de seis mil alunos 
                        de diversas localidades.</p>
                        <p>Na educação superior prevalecem os cursos de Tecnologia, especialmente na área de 
                        Agropecuária, e os de bacharelado e licenciatura. Na educação profissional técnica 
                        de nível médio, O IF Goiano atua preferencialmente na forma integrada, atendendo 
                        também ao público de jovens e adultos, por meio do Programa Nacional de Integração 
                        da Educação Profissional com a Educação Básica na Modalidade de Educação Jovens e 
                        Adultos (Proeja). A Instituição também atua na pós-graduação, com a oferta de três 
                        cursos de mestrado e, atualmente, é o único Instituto Federal do país a ofertar 
                        curso de doutorado.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="lei">
                    <div class="card-body text-justify">
                        <h1 class="h2 mb-4">Lei de criação</h1>
                        <a class="green ribbon">IF Goiano</a>
                        <p>Na mais recente dessas transformações nasce o Instituto Federal Goiano (IF Goiano), 
                        criado por meio da Lei 11.892, de 29 de dezembro de 2008, juntamente com outros 37 Institutos 
                        Federais de Educação, Ciência e Tecnologia. As novas instituições são fruto do reordenamento e 
                        da expansão da Rede Federal de Educação Profissional e Tecnológica, iniciados em abril de 2005.
                        De acordo com o disposto na Lei, o Estado de Goiás ficou com dois Institutos: o Instituto Federal 
                        Goiano (IF Goiano) e o Instituto Federal de Goiás (IFG). O IF Goiano integrou os antigos Centros 
                        Federais de Educação Tecnológica (Cefets) de Rio Verde, de Urutaí e sua respectiva Unidade de Ensino 
                        Descentralizada de Morrinhos, mais a Escola Agrotécnica Federal de Ceres (EAFCE) – todos provenientes 
                        de antigas escolas agrícolas. Como órgão de administração central, o IF Goiano tem uma Reitoria 
                        instalada em Goiânia, Capital do Estado. Em 2010, a Instituição inaugurou mais um campus em Iporá e 
                        em 2014 iniciou atividades em três novos campi, em Campos Belos, Posse e Trindade. Além destes, a 
                        Instituição também possui quatro campi avançados, nas cidades de Catalão, Cristalina, Ipameri e 
                        Hidrolândia, totalizando doze unidades em Goiás.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="conceito">
                    <div class="card-body text-justify">
                        <h1 class="h2 mb-4">Conceito</h1>
                        <a class="red ribbon">Verticalização</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia 
                        deserunt mollit anim id est laborum.
                        </p>

                        <div class="text-center">
                            <img width="400" src="assets/imagens/fluxograma.svg" class="img-fluid mt-2 mb-2" alt="Fluxograma">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="variacoes">
                    <div class="card-body">
                        <h1 class="h2 mb-4">Variações</h1>
                        <a class="red ribbon">Verticalização</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia 
                        deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="calculo">
                    <div class="card-body">
                        <h1 class="h2 mb-4">Cálculo</h1>
                        <a class="red ribbon">Verticalização</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia 
                        deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="dataset">
                    <div class="card-body">
                        <h1 class="h2 mb-4">Dataset</h1>
                        <a class="blue ribbon">Dados</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia 
                        deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
                <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="diagrama">
                    <div class="card-body">
                        <h1 class="h2 mb-4">Diagrama</h1>
                        <a class="blue ribbon">Dados</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna 
                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
                        ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit 
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
                        occaecat cupidatat non proident, sunt in culpa qui officia 
                        deserunt mollit anim id est laborum.
                        </p>

                        <div class="text-center">
                            <img width="800" src="assets/imagens/diagrama.svg" class="img-fluid mt-2 mb-2" alt="Diagrama">
                        </div>
                    </div>
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

    <script src="assets/js/visualizacao.js"></script>

</body>
</html>