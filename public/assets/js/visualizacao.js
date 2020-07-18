const base = window.location.origin;
const url = window.location.pathname.split('/');
const baseUrl = `${base}/${url[1]}/${url[2]}/api.php`;

(function () {
	'use strict'

	// icons
	feather.replace();

	// $('[data-toggle="tooltip"]').tooltip();

	// multiple select
	$('.mp-select').multipleSelect({
		animate: 'slide'
	});

	
	$('#formulario-filtros').on('submit', function (e) {
		e.preventDefault();

		let ano = $('#ano').val(),
			sexo = $('#sexo').val(),
			campus = $('#campus').val(),
			area = $('#area').val();

        let dados = {
            anoLetConclusao: ano,
            sexo: sexo,
            codInstituicao: campus,
            codAreaConhecimento: area
        };

		dados.acao = "Visualizacoes/filtrar";
		// console.log(dados);

        $.ajax({
            url: baseUrl,
            type: "POST",
            data: dados,
            dataType: "text",
            async: true,
            success: function (res) {
				res = JSON.parse(res);

                if (res && (Object.keys(res).length) > 0) {

					let tipo = $('#tipoVerticalizacao').find(":selected").val();
					
					if (tipo == 0) { //independente de eixo
						console.log('aaa');				

					} else if (tipo == 1) { //mesmo eixo
						gerarGrafico(res.eixo);

					} else { //fora do eixo
						gerarGrafico(res.foraEixo);
					}

                    // console.log(tipo);
                } else {
                    console.log("Não Deu Certo :(");
				}
				
            },
            error: function (request, status, str_error) {
                console.log(request, status, str_error)
            }
        });
	});

}());

function resetCanvas(){
	$('#chartBar').remove(); 
	$('#chartVert').remove(); 
	$('#chartReingresso').remove(); 

	$('#gBar').append('<canvas class="" width="700" height="500" id="chartBar"></canvas>');
	$('#gVert').append('<canvas class="" width="365" height="250" id="chartVert"></canvas>');
	$('#gRein').append('<canvas class="" width="365" height="250" id="chartReingresso"></canvas>');
	
	// ctxBar = document.getElementById('myChart').getContext('2d');
};

function gerarGrafico(dados) {

	// cores	
	var cores = [
		'rgb(0, 0, 0)',
		'rgb(220, 20, 60)',
		'rgb(255, 20, 147)',
		'rgb(139, 0, 139)',
		'rgb(75, 0, 130)',
		'rgb(0, 0, 128)',
		'rgb(0, 128, 128)',
		'rgb(0, 191, 255)',
		'rgb(0, 255, 255)',
		'rgb(0, 250, 154)',
		'rgb(173, 255, 47)',
		'rgb(0, 128, 0)',
		'rgb(255, 215, 0)',
		'rgb(255, 69, 0)',
		'rgb(139, 69, 19)',
	];

	var coresArea = [cores[1], cores[3], cores[5],cores[7],cores[9],cores[11],cores[12],cores[13],cores[14]];
	var coresSexo = ['rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'];

	// graphs
	var lbs = ['2015', '2016', '2017', '2018', '2019', '2020'];            
        
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
				backgroundColor: coresSexo[0]
			},
			{
				label: 'Reingresso',
				data: Object.values(dados.barras.reingresso),
				backgroundColor: coresSexo[1]
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
					barPercentage: 0.7,
					categoryPercentage: 0.7,
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