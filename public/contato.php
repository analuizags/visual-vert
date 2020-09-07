<?php
    require_once 'header.php';
?>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse pl-2">
            <div class="sidebar-sticky pt-3 mt-3">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-2 text-muted">
                    <span>Desenvolvimento</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#programadora">
                            <span data-feather="code"></span>
                            Programadora
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projeto">
                            <span data-feather="edit-3"></span>
                            Projeto
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#grupo">
                            <span data-feather="users"></span>
                            Grupo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">
                            <span data-feather="at-sign"></span>
                            Contato
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-5" id="programadora">
            <div class="row align-items-center justify-content-md-center mt-5 mb-5">
                <div class="col-md-4 mr-3 text-center">
                    <h1 class="nome quadro mt-3">Ana Luiza G. de Souza</h1>
                    <h1 class="funcao quadro">Desenvolvedora Web Junior</h1>
                    <p class="mt-3">Acadêmica do curso de bacharelado em Sistemas de Informação pelo 
                    <span class="marcador-texto">IF Goiano - Campus Ceres</span></p>
                </div>
                <div class="col-md-3">
                    <figure class="avatar">
                        <img src="assets/imagens/avatar.jpg" alt="Ana Luiza">
                    </figure>
                </div>
            </div>
            <!-- style="border:solid" -->

            <div class="row ml-4 mt-5" id="projeto">
                <div class="col">
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <h3 class="titulo-contato">Projeto</h3>
                        </div>
                    </div>
                    <div class="row ml-4 mt-3">
                        <div class="col-md-11">
                            <p>Projeto iniciado a partir do editar nº07/2019, com a finalidade de mensurar
                            quantitativamente o percentual de verticalização no IF Goiano por meio do uso de regras de 
                            associação e orientado pelo Prof. Me. Adriano Honorato Braga. Buscou por meio do desenvolvimento 
                            <i>web</i> criar um local para a visualização dos dados encontrados na pesquisa. Esse, pode ser 
                            encontrado no <a class="marcador-texto" href="http://https://github.com/analuizags/visual-vert" target="_blank">
                            github</a>. Construido com as tecnologias:  
                            </p>
                            <ul class="tecnologias">
                                <li>Bootstrap</li>
                                <li>jQuery</li>
                                <li>Chartjs</li>
                            </ul>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row ml-4 mt-5" id="grupo">
                <div class="col">
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <h3 class="titulo-contato">Grupo</h3>
                        </div>
                    </div>
                    <div class="row ml-4 mt-3">
                        <div class="col-md-11">
                            <p>Atualmente todo os envolvidos nesse projeto fazem parte do grupo de pesquisa
                            <a class="marcador-texto" href="http://dgp.cnpq.br/dgp/espelhogrupo/8129715117574510" target="_blank">
                            Núcleo de Estudos e Pesquisa em Tecnologia da Informação (Nepeti)</a>. Que iniciou suas 
                            atividades em 2014, formado por docentes da área de Informática do IF Goiano - Campus Ceres. 
                            A primeira aprovação de projeto foi logo no mês de Dezembro sob a coordenação do professor 
                            Adriano Honorato Braga, CNPq-SETEC/MEC nº 17/2014. 
                            </p>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="row ml-4 mt-5 mb-5" id="contato">
                <div class="col">
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <h3 class="titulo-contato">Contato</h3>
                        </div>
                    </div>
                    <div class="row ml-4 mt-3">
                        <div class="col-md-11">
                            <p>Entre em contato a partir das redes sociais</p>
                            <div class="row icones-contato">
                                <div class="col-md-1">
                                    <a target="_blank" href="https://github.com/analuizags">
                                        <span data-feather="github"></span>
                                    </a>
                                </div>
                                <div class="col-md-1">
                                    <a target="_blank" href="http://lattes.cnpq.br/8179954748202484">
                                        <span data-feather="map-pin"></span>
                                    </a>
                                </div>
                                <div class="col-md-1">
                                    <a target="_blank" href="mailto:ana.souza@estudante.ifgoiano.edu.br">
                                        <span data-feather="mail"></span>
                                    </a>
                                </div>
                                <div class="col-md-1">
                                    <a target="_blank" href="http://instagram.com/analu.gs">
                                        <span data-feather="instagram"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </main>
    </div>
</div>

<?php
    require_once 'footer.php';
?>