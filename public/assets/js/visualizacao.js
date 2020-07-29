const base = window.location.origin;
const url = window.location.pathname.split('/');
const baseUrl = `${base}/${url[1]}/${url[2]}/api.php`;
const cores = [ 'rgb(0, 0, 0)', 'rgb(220, 20, 60)', 'rgb(255, 20, 147)', 'rgb(139, 0, 139)', 'rgb(75, 0, 130)', 'rgb(0, 0, 128)', 'rgb(0, 128, 128)', 'rgb(0, 191, 255)', 'rgb(0, 255, 255)', 'rgb(0, 250, 154)', 'rgb(173, 255, 47)', 'rgb(0, 128, 0)', 'rgb(255, 215, 0)', 'rgb(255, 69, 0)', 'rgb(139, 69, 19)', ];
var res = 0;

(function () {
	'use strict'

	// icons
	feather.replace();

	// $('[data-toggle="tooltip"]').tooltip();

	// multiple select
	$('.mp-select').multipleSelect({
		animate: 'slide'
	});

	// $(document).ready(enviarFormulario());
	
	$('#formulario-filtros').on('submit', function (e) {
		e.preventDefault();
		enviarFormulario();
	});

	$('#faseVerticalizacao').change(function () {
		setTimeout(() => {
			verificarFase(res.tabela);
		}, 1500)	
	});


	// range slider
	$(function() {	
		var max = parseInt($(".intervalo-ano").attr("data-max"), 10),
			min = parseInt($(".intervalo-ano").attr("data-min"), 10);

		$(".slider-range").slider({
		  range: true,
		  min: min,
		  max: max,
		  values: [ min, max ],
		  slide: function( event, ui ) {
			$(".intervalo-ano").empty();
			$(".intervalo-ano").append(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
		  }
		});

		$(".intervalo-ano").empty();
		$(".intervalo-ano").append(
			$(".slider-range").slider("values", 0) + " - " + $(".slider-range").slider("values", 1)
		);
	});

}());

function enviarFormulario() {
	let ano = $('.intervalo-ano'),
		sexo = $('#sexo'),
		campus = $('#campus'),
		area = $('#area'),
		unidades = [], 
		areas = [];

	campus.find(":selected").each(function() {
		unidades.push($(this).text());
	});

	area.find(":selected").each(function() {
		areas.push($(this).text());
	});

	let tb = {
		unidades: unidades,
		areas: areas
	};

	let dados = {
		periodos: ano.text(),
		sexo: sexo.val(),
		codInstituicao: campus.val(),
		codAreaConhecimento: area.val(),
		// tabela: tb
	};

	dados.acao = "Visualizacoes/filtrar";
	// console.log(dados);

	$('.loader-graficos').removeAttr('hidden');

	$.ajax({
		url: baseUrl,
		type: "POST",
		data: dados,
		dataType: "text",
		async: true,
		success: function (result) {
			res = JSON.parse(result);
			// console.log(res)

			if (res && (Object.keys(res).length) > 0) {
				// let retorno = verificarTipo();
				gerarGrafico(res);
				verificarFase(res.tabela);
				// console.log(retorno);
			} else {
				console.log("Não Deu Certo :(");
			}
			
		},
		error: function (request, status, str_error) {
			console.log(request, status, str_error)
		}
	});
}

function verificarFase(dados) {
	
	let tipo = $('#faseVerticalizacao').find(":selected").val();
				
	if (tipo == 0) { // independente de tipo
		gerarTabela(dados.independente);
		// console.log(dados);
		
	} else if (tipo == 1) { // vert concluida
		gerarTabela(dados.vertConcluida);
		
	} else if (tipo == 2) { // vert nao concluida
		gerarTabela(dados.vertNConcluida);
		
	} else if (tipo == 3) { // vert em fluxo
		gerarTabela(dados.vertFluxo);
		
	} else if (tipo == 4) { // vert reingresso concluida
		gerarTabela(dados.reingressoConcluida);
		
	} else if (tipo == 5){ // vert reingresso nao concluida
		gerarTabela(dados.reingressoNConcluida);

	} else if (tipo == 6){ // vert reingresso em fluxo
		gerarTabela(dados.reingressoFluxo);
	}

}

function resetCanvas(){
	$('.loader-graficos').attr('hidden', '');
	$('#chartBar').remove(); 
	$('#chartVert').remove(); 
	$('#chartReingresso').remove(); 

	$('#gBar').append('<canvas class="" width="700" height="500" id="chartBar"></canvas>');
	$('#gVert').append('<canvas class="" width="365" height="250" id="chartVert"></canvas>');
	$('#gRein').append('<canvas class="" width="365" height="250" id="chartReingresso"></canvas>');
};

function gerarGrafico(dados) {

	var coresBarras = ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'];
	var lbs = Object.keys(dados.barras.vert);
        
	resetCanvas();

	var ctxBar = document.getElementById('chartBar').getContext('2d');
	var chart = new Chart(ctxBar, {		
		type: 'bar',
		data: {
			labels: lbs,
			datasets: [{
				label: 'Concluida',
				backgroundColor: 'transparent',
				borderColor: cores[4],
				data: Object.values(dados.linhas.Concluida),
				type: 'line'
			},
			{
				label: 'Não Concluída',
				backgroundColor: 'transparent',
				borderColor: cores[13],
				data: Object.values(dados.linhas.NConcluida),
				type: 'line'
			},
			{
				label: 'Em Fluxo',
				backgroundColor: 'transparent',
				borderColor: cores[11],
				data: Object.values(dados.linhas.Fluxo),
				type: 'line'
			},
			{
				label: 'Verticalização',
				data: Object.values(dados.barras.vert),
				backgroundColor: coresBarras[0]
			},
			{
				label: 'Reingresso',
				data: Object.values(dados.barras.reingresso),
				backgroundColor: coresBarras[1]
			}]
		},
		options: {
			layout: {
				padding: {
					left: 0,
					right: 0,
					top: 20,
					bottom: 0
				}
			},
			legend: {
				boxWidth: 20,
				fontSize: 12,
				position: 'top',
				onClick: false,
				labels: {
					boxWidth: 30,
					padding: 17,
					fontColor: '#333'
				},
				padding: 30
			},
			scales: {
				yAxes: [{
					scaleLabel: {
						display: true,
						labelString: 'Qtde alunos verticalizados',
						fontColor: '#333'
					}
				}],
				xAxes: [{
					// barPercentage: 0.7,
					// categoryPercentage: 0.7,
					scaleLabel: {
						display: true,
						labelString: 'Anos',
						fontColor: '#333'
					}
				}]
			}
		}
	});
	

	var ctxPizza1 = document.getElementById('chartVert');
	var chartPizza1 = new Chart(ctxPizza1, {
		type: 'doughnut',
		data: {
			labels: ['Concluída',	'Não Concluída', 'Em Fluxo'],
			datasets: [{
				backgroundColor: [
					cores[4],
					cores[13],
					cores[11]
				],
				data: Object.values(dados.pizzas.vert)
			}]
		},
		options: {
			layout: {
				padding: {
					left: 10,
					right: 10,
					top: 10,
					bottom: 15
				}
			},
			title: {
				display: true,
				fontSize: 16,
				text: "Verticalização",
				// padding: 20,
				// lineHeight: 2
			}, 
			legend: {
				position: 'right',
				onClick: false,
				labels: {
					boxWidth: 20,
					padding: 17,
					fontColor: '#666',
					fontFamily: 'Arial'
				}
			}
		}
	});
	
	var ctxPizza2 = document.getElementById('chartReingresso');
	var chartPizza2 = new Chart(ctxPizza2, {
		type: 'doughnut',
		data: {
			labels: ['Concluída',	'Não Concluída', 'Em Fluxo'],
			datasets: [{
				backgroundColor: [
					cores[4],
					cores[13],
					cores[11]
				],
				data: Object.values(dados.pizzas.reingresso)
			}]
		},
		options: {
			layout: {
				padding: {
					left: 10,
					right: 10,
					top: 15,
					bottom: 10
				}
			},
			title: {
				display: true,
				fontSize: 16,
				text: "Verticalização de Reingressos",
				// padding: 20,
				// lineHeight: 2
			},
			legend: {
				position: 'right',
				onClick: false,
				labels: {
					boxWidth: 20,
					padding: 17,
					fontColor: '#666',
					fontFamily: 'Arial'
				}
			}
		}
	});
	
}

function gerarTabela(dados) {
	
	let corpoTabela = "", 
		cabecaTabela = '<tr> <th scope="col">Unidade de Ensino</th><th scope="col">Área de Conhecimento</th>',
		anos = Object.keys(dados[Object.keys(dados)[0]][Object.keys(dados[Object.keys(dados)[0]])[0]]);
	
	$('table > thead').empty();

	for (let key in anos) {
		cabecaTabela += '<th scope="col">' + anos[key] + '</th>';
	}

	cabecaTabela += '</tr>';
	$('table > thead').append(cabecaTabela);

	for (let campus in dados) {
		if (dados.hasOwnProperty(campus)) {

			corpoTabela += '<tr><td scope="row" rowspan="' + Object.keys(dados[campus]).length + '" class="align-middle">' + codigoDescricao(campus, 'unidade') + '</td>';
			let flag = false;

			for (let area in dados[campus]) {
				if (dados[campus].hasOwnProperty(area)) {
					if (flag) {
						corpoTabela += '<tr>';
					}

					corpoTabela += '<td class="align-middle">' + codigoDescricao(area, 'area') + '</td>';

					for (let ano in dados[campus][area]) {
						if (dados[campus][area].hasOwnProperty(ano)) {
							corpoTabela += '<td>' + dados[campus][area][ano] + '</td>';							
						}
					}
				}

				corpoTabela += '</tr>';	
				flag = false;
			}
		}
	}

	$('table > tbody').empty();
	$('table > tbody').append(corpoTabela);
}

function codigoDescricao(codigo, tipo) {
	
	if (tipo == 'unidade') {
		switch (codigo) {
			case '1':
				return 'Campus Urutaí';
				break;
			case '2':
				return 'Campus Rio Verde';
				break;
			case '3':
				return 'Campus Ceres';
				break;
			case '4':
				return 'Campus Morrinhos';
				break;
			case '5':
				return 'Campus Iporá';
				break;
			case '6':
				return 'Reitoria';
				break;
			case '8':
				return 'Campus Cristalina';
				break;
			case '9':
				return 'Campus Avançado Ipameri';
				break;
			case '10':
				return 'Campus Avançado Catalão';
				break;
			case '11':
				return 'Campus Avançado Hidrolândia';
				break;
			case '12':
				return 'Campus Campos Belos';
				break;
			case '13':
				return 'Campus Posse';
				break;
			case '14':
				return 'Campus Trindade';
				break;
			default:
				return 'Unidades de Ensino distintas';
				break;
		}
	} else {
		switch (codigo) {
			case '10000003':
				return 'Ciências Exatas e da Terra';
				break;
			case '20000006':
				return 'Ciências Biológicas';
				break;
			case '30000009':
				return 'Engenharias';
				break;
			case '40000001':
				return 'Ciências da Saúde';
				break;
			case '50000004':
				return 'Ciências Agrárias';
				break;
			case '60000007':
				return 'Ciências Sociais Aplicadas';
				break;
			case '70000000':
				return 'Ciências Humanas';
				break;
			case '80000002':
				return 'Linguística, Letra e Artes';
				break;
			case '90000005':
				return 'Multidisciplinar';
				break;
			default:
				return 'Áreas de Conhecimento distintas';
				break;
		}
	}
}