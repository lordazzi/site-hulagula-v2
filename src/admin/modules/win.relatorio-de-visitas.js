$(function(){
	asWindow({ id: "relatorio-de-visitas", scope: $("#admin") });
	$("#de-relatorio-de-visitas, #ate-relatorio-de-visitas").datepicker({
		dateFormat: "dd/mm/yy",
		monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezambro" ],
		dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
		minDate: new Date(1343793600000),
		maxDate: new Date()
	});
	
	var d =	new Date().getDate();
	var m = new Date().getMonth() + 1;
	var Y = new Date().getFullYear();
	
	d = (d < 10) ? ("0" + d.toString()) : (d.toString());
	m = (m < 10) ? ("0" + m.toString()) : (m.toString());
	
	$("#ate-relatorio-de-visitas").val(d+"/"+m+"/"+Y);
	
	Highcharts.theme = {
		colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
		chart: {
			backgroundColor: {
				linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
				stops: [
					[0, 'rgb(255, 255, 255)'],
					[1, 'rgb(240, 240, 255)']
				]
			},
			plotBackgroundColor: 'rgba(255, 255, 255, .9)',
			plotShadow: true
		},
		title: {
			style: {
				color: '#000',
				font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
			}
		},
		subtitle: {
			style: {
				color: '#666666',
				font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
			}
		},
		xAxis: {
			gridLineWidth: 1,
			lineColor: '#000',
			tickColor: '#000',
			labels: {
				style: {
					color: '#000',
					font: '11px Trebuchet MS, Verdana, sans-serif'
				}
			},
			title: {
				style: {
					color: '#333',
					fontWeight: 'bold',
					fontSize: '12px',
					fontFamily: 'Trebuchet MS, Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			minorTickInterval: 'auto',
			lineColor: '#000',
			lineWidth: 1,
			tickWidth: 1,
			tickColor: '#000',
			labels: {
				style: {
					color: '#000',
					font: '11px Trebuchet MS, Verdana, sans-serif'
				}
			},
			title: {
				style: {
					color: '#333',
					fontWeight: 'bold',
					fontSize: '12px',
					fontFamily: 'Trebuchet MS, Verdana, sans-serif'
				}
			}
		},
		legend: {
			itemStyle: {
				font: '9pt Trebuchet MS, Verdana, sans-serif',
				color: 'black'
			},
				itemHoverStyle: {
				color: '#039'
			},
				itemHiddenStyle: {
				color: 'gray'
			}
		},
		labels: {
			style: {
				color: '#9999BB'
			}
		},
		navigation: {
			buttonOptions: {
				theme: {
					stroke: '#CCCCCC'
				}
			}
		}
	};

	// Apply the theme
	var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
	
	reloadChart = (function(params){
		if (params == null) { params = {}; }
		if (params.ate == null) { params.ate = (Math.round(new Date().getTime() / 1000)); }
		if (params.de == null) { params.de = 1343793600; }
		if (params.per == null) { params.per = 2; }
		
		$.ajax({
			url: "action/get-visitantes.php",
			type: "post",
			data: params,
			success: function(json){
				json = JSON.parse(json);
				var categories = [], visitantes = [];
				for (var i = 0; i < json.length; i++) {
					categories[i] = json[i].rotulo;
				}
				
				for (var i =0; i < json.length; i++) {
					visitantes[i] = json[i].visitas;
				}
				
				$('#charts-relatorio-de-visitas').highcharts({
					chart: {
						type: 'line'
					},
					title: {
						text: 'Gráfico de Visitantes',
						x: -20 //center
					},
					xAxis: {
						categories: categories
					},
					yAxis: {
						title: {
							text: 'Visitantes'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						valueSuffix: ' visitantes'
					},
					legend: { enabled: false },
					series: [{
						name: 'Visitantes',
						data: visitantes
					}],
					credits: { enabled: false }
				});
			}
		});
	});
	
	reloadChart();
	
	$("#consultar-relatorio-de-visitas").on("click", function(){
		reloadChart({
			de: Math.round($("#de-relatorio-de-visitas").datepicker("getDate").getTime() / 1000),
			ate: Math.round($("#ate-relatorio-de-visitas").datepicker("getDate").getTime() / 1000),
			per: $("#per-relatorio-de-visitas").val()
		});
		
		return false;
	});
});