const base = window.location.origin;
const url = window.location.pathname.split('/');
const baseUrl = `${base}/${url[1]}/${url[2]}/api.php`;

(function () {
	'use strict'

	// icons
	feather.replace();

	// tooltip
	$('[data-toggle="tooltip"]').tooltip({ boundary: 'window' });


	$('#formulario-filtros').on('submit', function (e) {
		e.preventDefault();

		let ano = $('#ano').val(),
			sexo = $('#sexo').val(),
			campus = $('#campus').val(),
			area = $('#area').val();

        let dados = {
            ano: ano,
            sexo: sexo,
            campus: campus,
            area: area
        };

		dados.acao = "Visualizacoes/filtrar";
		// console.log(baseUrl);

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
	var coresSexo = ['rgb(255, 192, 203)', 'rgb(176, 224, 230)'];

	// graphs
	var lbs = ['2015', '2016', '2017', '2018', '2019', '2020'];            
        
	var ctxBar = document.getElementById('myChart');
	var chartBar = new Chart(ctxBar, {
		type: 'bar',
		chart: ' aaa',
		data: {
			labels: lbs,
			datasets: [{
				label: 'Masculino',
				data: [129, 307, 239, 137, 210, 212],
				backgroundColor: [
					'rgba(255, 99, 132, .2)',
					'rgba(255, 99, 132, .2)',
					'rgba(255, 99, 132, .2)',
					'rgba(255, 99, 132, .2)',
					'rgba(255, 99, 132, .2)',
					'rgba(255, 99, 132, .2)'
				],
				borderColor: [
					'rgba(255, 99, 132, 1)',
					'rgba(255, 99, 132, 1)',
					'rgba(255, 99, 132, 1)',
					'rgba(255, 99, 132, 1)',
					'rgba(255, 99, 132, 1)',
					'rgba(255, 99, 132, 1)'
				],
				borderWidth: 1
			},
			{
				label: 'Feminio',
				data: [102, 251, 215, 143, 178, 161],
				backgroundColor: [
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)'
				],
				borderColor: [
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)'
				],
				borderWidth: 1
			},
			{
				label: 'Ceres',
				backgroundColor: 'transparent',
				borderColor: 'rgb(205, 99, 132)',
				data: [30, 125, 106, 48, 62, 67],
				type: 'line'
			},
			{
				label: 'Geral',
				backgroundColor: 'transparent',
				borderColor: 'rgb(55, 99, 255)',
				data: [231, 558, 454, 280, 388, 373],
				type: 'line'
			}]
		},
		options: {
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
