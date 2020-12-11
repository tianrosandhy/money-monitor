<script>
	var barChartData = {
		labels: {!! json_encode($label) !!},
		datasets: [
			@foreach($dataset as $rd)
			{!! json_encode($rd) !!},
			@endforeach
		]
	};

	var ctx = document.getElementById('{{ $canvas_id }}').getContext('2d');
	window.myBar = new Chart(ctx, {
		type: '{{ $type }}',
		data: barChartData,
		options: {
			title: {
				display: false,
			},
			tooltips: {
				mode: 'index',
				intersect: false
			},
			elements : {
				line: {
					tension : 0
				}
			},
			responsive: true,
			maintainAspectRatio : false,
			scales : {
				yAxes : [{
					ticks : {
						beginAtZero : true,
						callback: function(value, index, values) {
						if(parseInt(value) >= 1000){
							return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						} else {
							return value;
						}
						}						
					}
				}]
			},
			tooltips : {
				callbacks : {
					label: function(tooltipItem, data) {
						console.log(tooltipItem, data);
						var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
						var label = data.datasets[tooltipItem.datasetIndex].label;
						if(parseInt(value) >= 1000){
							return label + ' : ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						} else {
							return label + ' : ' + value;
						}
					}					
				}
			}
		}
	});
</script>