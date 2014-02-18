var svgIconConfig = {
	volume : {
		url : '/assets/img/svg/volume.svg',
		animation : [
			{ 
				el : 'path:nth-child(1)', 
				animProperties : { 
					from : { val : '{"transform" : "t-10 0 s0 32 32"}' }, 
					to : { val : '{"transform" : "t0 0 s1 32 32", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 32 32"}', delayFactor : .5 }
				} 
			},
			{ 
				el : 'path:nth-child(2)', 
				animProperties : { 
					from : { val : '{"transform" : "t-10 0 s0 32 32"}', delayFactor : .25 }, 
					to : { val : '{"transform" : "t0 0 s1 32 32", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 32 32"}', delayFactor : .25 }
				} 
			},
			{ 
				el : 'path:nth-child(3)', 
				animProperties : { 
					from : { val : '{"transform" : "t-10 0 s0 32 32"}', delayFactor : .5 }, 
					to : { val : '{"transform" : "t0 0 s1 32 32", "opacity" : 1}', before : '{"transform" : "t-10 0 s0 32 32"}' }
				} 
			}
		]
	},
	hamburger : {
		url : '/assets/img/svg/hamburger.svg',
		animation : [
			{ 
				el : 'path:nth-child(1)', 
				// animProperties : { 
				// 	from : { val : '{"path" : "m 5.0916789,20.818994 53.8166421,0"}' }, 
				// 	to : { val : '{"path" : "m 5.091679,9.771104 53.816642,0"}' }
				// }
				animProperties : { 
					from : { val : '{"path" : "m 5.0916789,10.409497 26.90832105,0"}' }, 
					to : { val : '{"path" : "m 5.091679, 9.771104 26.90832105,0,0"}' }
				}  
			},
			{ 
				el : 'path:nth-child(3)', 
				animProperties : { 
					from : { val : '{"path" : "m 5.0916788,42.95698 53.8166422,0"}' }, 
					to : { val : '{"path" : "m 5.0916789,54.00487 53.8166421,0"}' }
				} 
			}
		]
	},
	hamburgerCross : {
		url : '/assets/img/svg/hamburger.svg',
		animation : [
			{ 
				el : 'path:nth-child(1)', 
				animProperties : { 
					from : { val : '{"path" : "m 5.0916789,20.818994 53.8166421,0"}' }, 
					to : { val : '{"path" : "M 12.972944,50.936147 51.027056,12.882035"}' }
				} 
			},
			{ 
				el : 'path:nth-child(2)', 
				animProperties : { 
					from : { val : '{"transform" : "s1 1", "opacity" : 1}', before : '{"transform" : "s0 0"}' }, 
					to : { val : '{"opacity" : 0}' }
				} 
			},
			{ 
				el : 'path:nth-child(3)', 
				animProperties : { 
					from : { val : '{"path" : "m 5.0916788,42.95698 53.8166422,0"}' }, 
					to : { val : '{"path" : "M 12.972944,12.882035 51.027056,50.936147"}' }
				} 
			}
		]
	},
	play : {
		url : '/assets/img/svg/play.svg',
		animation : [
			{ 
				el : 'path', 
				animProperties : { 
					from : { val : '{"path" : "M 18.741071,52 31.30178,42.531655 45.258928,31.887987 18.741071,12 z"}' }, 
					to : { val : '{"path" : "m 12.5,52 39,0 0,-40 -39,0 z"}' }
				} 
			}
		]
	},
};