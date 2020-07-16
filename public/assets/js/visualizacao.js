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
		console.log(dados);

        $.ajax({
            url: baseUrl,
            type: "POST",
            data: dados,
            dataType: "text",
            async: true,
            success: function (res) {
                if (res && Number(res) > 0) {
                    console.log("Deu Certo");
                } else {
                    console.log("Não Deu Certo :(");
                }
            },
            error: function (request, status, str_error) {
                console.log(request, status, str_error)
            }
        });
	});

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
        
	var ctxBar = document.getElementById('myChart');
	var chartBar = new Chart(ctxBar, {
		type: 'bar',
		data: {
			labels: lbs,
			datasets: [{
				label: 'Concluida',
				backgroundColor: 'transparent',
				borderColor: cores[4],
				data: [153, 218, 110, 254, 358, 100],
				type: 'line'
			},
			{
				label: 'Não Concluída',
				backgroundColor: 'transparent',
				borderColor: cores[13],
				data: [131, 458, 354, 180, 288, 273],
				type: 'line'
			},
			{
				label: 'Em Fluxo',
				backgroundColor: 'transparent',
				borderColor: cores[11],
				data: [100, 358, 254, 100, 218, 153],
				type: 'line'
			},
			{
				label: 'Masculino',
				data: [29, 307, 239, 137, 210, 212],
				backgroundColor: coresSexo[0]
			},
			{
				label: 'Feminio',
				data: [102, 251, 215, 143, 178, 161],
				backgroundColor: coresSexo[1]
			}]
		},
		options: {
			layout: {
				padding: {
					left: 40,
					right: 40,
					top: 20,
					bottom: 0
				}
			},
			legend: {
				position: 'top',
				onClick: false,
				labels: {
					boxWidth: 30,
					padding: 17,
					fontColor: '#333'
				}
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
					barPercentage: 0.8,
					scaleLabel: {
						display: true,
						labelString: 'Anos',
						fontColor: '#333'
					}
				}]
			}
		}
	});
	
	/*
	var ctxPizza = document.getElementById('myChart');
	var chartPizza = new Chart(ctxPizza, {
		type: 'pie',
		data: {
			labels: [
				'Red',
				'Yellow',
				'Blue'
			],
			datasets: [{
				backgroundColor: [
					'rgba(255, 99, 132, .7)',
					'rgba(75, 192, 192, 0.7)',
					'rgba(75, 92, 92, 0.7)'
				],
				data: [10, 20, 30]
			}]
		},
		options: {
			title: {
				display: false,
				fontSize: 20,
				text: "Gráfico dos checkboxs",
				// padding: 20,
				lineHeight: 2
			},
			legend: {
				position: 'right',
				onClick: false,
				labels: {
					boxWidth: 30,
					padding: 17,
					fontColor: '#666',
					fontFamily: 'Arial'
				}
			}
		}
	});
	
	var ctxLines = document.getElementById('g-lines');
	var chartLine = new Chart(ctxLines, {
		type: 'line',
		data: {
			labels: lbs,
			datasets: [{
				label: 'Masculino',
				backgroundColor: 'transparent',
				borderColor: 'rgb(205, 99, 132)',
				data: [0, 10, 5, 2, 20, 30]
			},
			{
				label: 'Feminino',
				backgroundColor: 'transparent',
				borderColor: 'rgb(55, 99, 255)',
				data: [10, 2, 10, 2, 30, 35]
			}]
		},
		options: {
			title: {
				display: true,
				fontSize: 20,
				text: "Gráfico dos checkboxs",
				// padding: 20,
				lineHeight: 2
			},
			legend: {
				position: 'right',
				onClick: false,
				labels: {
					boxWidth: 30,
					padding: 17,
					fontColor: '#666',
					fontFamily: 'Arial'
				}
			}
		}
	});
	*/
}())
