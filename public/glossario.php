<?php
    require_once 'header.php';
?>

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
                            Definição
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#lei">
                            <span data-feather="file-text"></span>
                            Lei de criação
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
                    curso de doutorado.</p>
                    <p class="card-text text-right fonte">
                        <small class="text-muted">
                            Fonte: <a href="https://www.ifgoiano.edu.br/home/index.php/historico.html" target="_blank">IF Goiano</a> 
                        </small>
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
                    Hidrolândia, totalizando doze unidades em Goiás.</p>
                    <p class="card-text text-right fonte">
                        <small class="text-muted">
                            Fonte: <a href="https://www.ifgoiano.edu.br/home/index.php/historico.html" target="_blank">IF Goiano</a> 
                        </small>
                    </p>
                </div>
            </div>

            <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="conceito">
                <div class="card-body text-justify">
                    <h1 class="h2 mb-4">Conceito</h1>
                    <a class="red ribbon">Verticalização</a>
                    <p>Com o entendimento de verticalização sendo a oferta de diferentes níveis de ensino em uma mesma 
                    instituição, delimita-se a verticalização que é praticada pelos estudantes. Essa, é dada
                    com a subida de nível de ensino dentro do IF Goiano, desde que, o nível inferior tenha sido concluído 
                    anteriormente ao superior. Considera-se como nível de ensino o "técnico", "graduação", "especialização", 
                    "mestrado" e "doutorado".</p>
                    <div class="text-center">
                        <img width="400" src="assets/imagens/fluxograma.svg" class="img-fluid mt-2 mb-2" alt="Fluxograma">
                    </div>
                    <p class="card-text text-right"><small class="text-muted">Fonte: própria</small></p>
                </div>
            </div>

            <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="variacoes">
                <div class="card-body text-justify">
                    <h1 class="h2 mb-4">Variações</h1>
                    <a class="red ribbon">Verticalização</a>
                    <ul>
                        <li class="mb-2"><span>Concluída:</span> quando há conclusão de um curso de um determinado nível, advinda de um registro em um nível inferior.</li>
                        <li class="mb-2"><span>Não Concluída:</span> quando há evasão de um curso de um determinado nível, advinda de uma registro em um nível inferior.</li></li>
                        <li class="mb-2"><span>Em Fluxo:</span> quando ainda está se cursando um curso de um determinado nível, advinda de uma registro em um nível inferior.</li>
                        <li class="mb-2"><span>de Reingresso:</span> quando há evasão no registro de nível inferior.</li>
                        <li class="mb-2"><span>Fora da Área de Conhecimento:</span> quando há troca de área de conhecimento do curso de nível inferior para o de nível superior.</li>
                        <li class="mb-2"><span>Na Mesma Área de Conhecimento:</span> quando não há troca de área de conhecimento do curso de nível inferior para o de nível superior.</li>
                    </ul>
                    <p class="card-text text-right"><small class="text-muted">Fonte: própria</small></p>
                </div>
            </div>

            <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="calculo">
                <div class="card-body text-justify">
                    <h1 class="h2 mb-4">Cálculo</h1>
                    <a class="red ribbon">Verticalização</a>
                    <p>Com a intenção de alcançar um quantitativo de verticalidade do ensino proposto na criação dos IFs, foi 
                    criada uma métrica de cálculo denominada como taxa de verticalização (TV), ela mensura o percentual de alunos
                    verticalizados (AV) em relação ao total de alunos matriculados (AC), de um dado ano letivo (p). Sendo que, 
                    só é possível atingir 100% se todas as matrículas atendidas forem de alunos egressos de um curso com o nível 
                    inferior àquele curso posterior, dentro do IF Goiano. Dado pela fórmula:
                    <math>
                        <mi> TV(p) </mi>
                        <mo> = </mo>
                        <mfrac>
                            <mrow>
                                <mn> AV </mn>
                            </mrow>
                            <mn> AC </mn>
                        </mfrac>
                        <mo> x </mo>
                        <mn> 100 </mn>
                    </math>.
                    </p>
                    <p class="card-text text-right"><small class="text-muted">Fonte: própria</small></p>
                </div>
            </div>

            <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="dataset">
                <div class="card-body text-justify">
                    <h1 class="h2 mb-4">Dataset</h1>
                    <a class="blue ribbon">Dados</a>
                    <p>A seleção dos dados se deu a partir da obtenção dos dados dos estudantes registrados no sistema acadêmico 
                    do IF Goiano. Sistema esse que unifica, desde de 2013, os dados acadêmicos ligadas aos 12 campi (Campos Belos, 
                    Catalão, Ceres, Cristalina, Hidrolândia, Ipameri, Iporá, Morrinhos, Posse, Rio Verde, Trindade e Urutaí). 
                    No conjunto de dados concedido, incluem atributos como: identificação do aluno, sexo, cidade, matrícula, 
                    situação atual de matrícula, ano letivo atual, inicial e de conclusão, curso e unidade de ensino, registrados 
                    no período de 2009 a 2020. A fim de preservar a identidade do aluno, dados pessoais como CPF e nome não foram 
                    considerados na pesquisa. Portanto, para identificação e diferenciação dos alunos, utilizou-se um código único, 
                    composto por até 6 caracteres numéricos. Devido ao constante cadastramento de novas matrículas no sistema, em 
                    consequência do surgimento de novos ingressantes, a data-base utilizada para obter o dataset final foi dia 28 
                    de maio de 2020, totalizando 61.233 registros.</p>
                    <p class="card-text text-right"><small class="text-muted">Fonte: própria</small></p>
                </div>
            </div>
            <div class="card shadow-sm ml-3 mr-3 mb-4 glossario" id="diagrama">
                <div class="card-body text-justify">
                    <h1 class="h2 mb-4">Diagrama</h1>
                    <a class="blue ribbon">Dados</a>
                    <p>Utilizado para descrever as entidades envolvidos em um domínio de négocios, com seus atributos e 
                    relacionamentos de forma gráfica, o Diagrama Entidade Relacionamento que representa o conjunto de dados aqui 
                    utlizado é o seguinte:</p>
                    <div class="text-center">
                        <img width="800" src="assets/imagens/diagrama.svg" class="img-fluid mt-2 mb-2" alt="Diagrama">
                    </div>
                    <p class="card-text text-right"><small class="text-muted">Fonte: própria</small></p>
                </div>
            </div>
        </main>
    </div>
</div>

<?php
    require_once 'footer.php';
?>