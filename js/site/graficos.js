	var myChart = echarts.init(document.getElementById('echart_line'), theme);
	myChart.setOption({
		title: {
			text: 'Acessos na Última Semana',
			subtext: 'Acompanhe o número de acessos ao seu site dia-a-dia'
		},
		tooltip: {
			trigger: 'axis',
			formatter: "{b}: {c} acessos"
		},
		legend: {
			data: ['Acessos no dia']
		},
		calculable: false,
		xAxis: [{
			type: 'category',
			boundaryGap: false,
			data: lastWeekJS,
			axisLabel:{interval: 0}
		}],
		yAxis: [{
			type: 'value',
			min: 0,
			max: limitValue
		}],
		series: [{
			name: 'Acessos no dia',
			type: 'line',
			smooth: true,
			itemStyle: {
				normal: {
					areaStyle: {
						type: 'line'
					},
					lineStyle: {
						type: 'dotted'
					}
				}
			},
			data: viewsLastWeek
		}]
	});

	var myChart2 = echarts.init(document.getElementById('echart_pie'), theme);
	myChart2.setOption({
		title: {
			text: 'Acessos Totais por Seção',
			subtext: 'Descubra a popularidade de cada seção do seu site'
		},
		tooltip: {
			trigger: 'item',
			formatter: "{a} <br/>Acessos a \"{b}\" : {c} ({d}%)"
		},
		legend: {
			x: 'center',
			y: 'bottom',
			data: ['Home', 'Serviços', 'Empresa', 'Imagens', 'Contato']
		},
		calculable: false,
		series: [{
			name: 'Total de Acessos ao Site: 159',
			type: 'pie',
			radius: '55%',
			center: ['50%', '48%'],
			data: [{
				value: sectionsViews.home.count,
				name: 'Home'
			},
			{
				value: sectionsViews.servicos.count,
				name: 'Serviços'
			},
			{
				value: sectionsViews.empresa.count,
				name: 'Empresa'
			},
			{
				value: sectionsViews.imagens.count,
				name: 'Imagens'
			},
			{
				value: sectionsViews.contato.count,
				name: 'Contato'
			}]
		}]
	});

	var myChart3 = echarts.init(document.getElementById('mainb'), theme);
	myChart3.setOption({
		title: {
			text: 'Acessos Hoje',
			subtext: 'Monitore os acessos ao seu site no dia de hoje'
		},
		tooltip: {
			trigger: 'item',
			formatter: "Acessos hoje a {a}: {c}"
		},
		legend: {
			data: ['Home', 'Serviços', 'Empresa', 'Imagens', 'Contato'],
			x: 'right'
		},
		toolbox: {
			show: false
		},
		calculable: false,
		xAxis: [{
			type: 'category',
			data: [currentDay]
		}],
		yAxis: [{
			type: 'value'
		}],
		series: [{
			name: 'Home',
			type: 'bar',
			data: [todaysViews.home.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Serviços',
			type: 'bar',
			data: [todaysViews.servicos.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Empresa',
			type: 'bar',
			data: [todaysViews.empresa.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Imagens',
			type: 'bar',
			data: [todaysViews.imagens.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Contato',
			type: 'bar',
			data: [todaysViews.contato.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}]
	});

	//Custom Statiscs Stuff
	// var myChart4 = echarts.init(document.getElementById('mainb2'), theme);
	// myChart4.setOption({
	// 	title: {
	// 		text: 'Personalizadas',
	// 		subtext: 'Selecione os filtros e obtenha dados personalizados sobre o seu site'
	// 	},
	// 	tooltip: {
	// 		trigger: 'item',
	// 		formatter: "Acessos: {c}"
	// 	},
	// 	legend: {
	// 		data: ['Acessos'],
	// 		x: 'right'
	// 	},
	// 	toolbox: {
	// 		show: false
	// 	},
	// 	calculable: false,
	// 	xAxis: [{
	// 		type: 'category',
	// 		data: ["Resultado"]
	// 	}],
	// 	yAxis: [{
	// 		type: 'value'
	// 	}],
	// 	series: [{
	// 		name: 'Acessos',
	// 		type: 'bar',
	// 		data: [views.count[0]],
	// 		markLine: {
	// 			data: [{
	// 				type: 'max',
	// 				name: 'Acessos'
	// 			}],
	// 			symbolSize: [6, 4]
	// 		}
	// 	}]
	// });