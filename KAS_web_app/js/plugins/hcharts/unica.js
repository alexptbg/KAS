Highcharts.createElement('link', {
	href: 'https://fonts.googleapis.com/css?family=Unica+One',
	rel: 'stylesheet',
	type: 'text/css'
}, 
null, 
document.getElementsByTagName('head')[0]);
Highcharts.theme = {
	colors: ["#2791D9", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee", "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
	chart: {
		backgroundColor: {
			linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
			stops: [
				[0, '#272A33'],
				[1, '#18191F']
			]
		},
		style: {
			fontFamily: "'Unica One', sans-serif"
		},
		plotBorderColor: '#606063'
	},
	title: {
		style: {
			color: '#fdfdfd',
			textTransform: 'uppercase',
			fontSize: '20px'
		}
	},
	subtitle: {
		style: {
			color: '#fdfdfd',
			textTransform: 'uppercase'
		}
	},
	xAxis: {
		gridLineColor: '#333333',
		labels: {
			style: {
				color: '#FFFFFF'
			}
		},
		lineColor: '#333333',
		minorGridLineColor: '#333333',
		tickColor: '#333333',
		title: {
			style: {
				color: '#A0A0A3'
			}
		}
	},
	yAxis: {
		gridLineColor: '#333333',
		labels: {
			style: {
				color: '#FFFFFF'
			}
		},
		lineColor: '#333333',
		minorGridLineColor: '#333333',
		tickColor: '#333333',
		tickWidth: 1,
		title: {
			style: {
				color: '#A0A0A3'
			}
		}
	},
	tooltip: {
		backgroundColor: 'rgba(0, 0, 0, 0.85)',
		style: {
			color: '#FFFFFF'
		}
	},
	plotOptions: {
		series: {
			dataLabels: {
				color: '#fdfdfd'
			},
			marker: {
				lineColor: '#333'
			}
		},
		boxplot: {
			fillColor: '#505053'
		},
		candlestick: {
			lineColor: 'white'
		},
		errorbar: {
			color: 'white'
		}
	},
	legend: {
		itemStyle: {
			color: '#E0E0E3'
		},
		itemHoverStyle: {
			color: '#FFF'
		},
		itemHiddenStyle: {
			color: '#606063'
		}
	},
	credits: {
		style: {
			color: '#FFFFFF'
		}
	},
	labels: {
		style: {
			color: '#707073'
		}
	},
	drilldown: {
		activeAxisLabelStyle: {
			color: '#F0F0F3'
		},
		activeDataLabelStyle: {
			color: '#F0F0F3'
		}
	},
	navigation: {
		buttonOptions: {
			symbolStroke: '#FF0000',
			theme: {
				fill: '#2791D9'
			}
		}
	},
	rangeSelector: {
		buttonTheme: {
			fill: '#505053',
			stroke: '#000000',
			width : 50,
			style: {
				color: '#CCC'
			},
			states: {
				hover: {
					fill: '#2791D9',
					stroke: '#000000',
					style: {
						color: 'white'
					}
				},
				select: {
					fill: '#2791D9',
					stroke: '#000000',
					style: {
						color: 'white'
					}
				}
			}
		},
		inputBoxBorderColor: '#505053',
		inputStyle: {
			backgroundColor: '#333',
			color: 'silver'
		},
		labelStyle: {
			color: 'silver'
		}
	},
	navigator: {
		handles: {
			backgroundColor: '#2791D9',
			borderColor: '#AAAAAA'
		},
		outlineColor: '#333333',
		maskFill: 'rgba(255,255,255,0.1)',
		series: {
			color: '#7798BF',
			lineColor: '#2791D9'
		},
		xAxis: {
			gridLineColor: '#333333',
		    labels: {
			    style: {
				    color: '#FFFFFF'
			    }
		    }
		}
	},
	scrollbar: {
		barBackgroundColor: '#2791D9',
		barBorderColor: '#808083',
		buttonArrowColor: '#CCC',
		buttonBackgroundColor: '#606063',
		buttonBorderColor: '#606063',
		rifleColor: '#FFF',
		trackBackgroundColor: '#404043',
		trackBorderColor: '#404043'
	},
	legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
	background2: '#505053',
	dataLabelsColor: '#B0B0B3',
	textColor: '#FFFFFF',
	contrastTextColor: '#F0F0F3',
	maskColor: 'rgba(255,255,255,0.3)'
};
Highcharts.setOptions(Highcharts.theme);