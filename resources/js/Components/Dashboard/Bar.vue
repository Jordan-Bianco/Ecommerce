<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
	name: 'BarChart',
	components: { Bar },
	props: {
		chartId: {
			type: String,
			default: 'bar-chart'
		},
		datasetIdKey: {
			type: String,
			default: 'label'
		},
		width: {
			type: Number,
			default: 400
		},
		height: {
			type: Number,
			default: 180
		},
		cssClasses: {
			default: '',
			type: String
		},
		styles: {
			type: Object,
			default: () => {}
		},
		plugins: {
			type: Object,
			default: () => {}
		},
		data: {
			type: Object,
			default: () => {}
		},
	},
	computed: {
		chartData() {
			return {
				type: Object,
				required: true,
				labels: this.data.map(function(data) { return data.day }),
				datasets: [{
					data: this.data.map(function(data) { return data.total_spent }),
					backgroundColor: 'rgb(162, 209, 146)',
				}],
			}
		},
		chartOptions() {
			return {
				responsive: true,
				plugins: {
					legend: {
						display: false
					}
				},
			}
		}
	},
}
</script>

<template>
	<Bar
		:chart-options="chartOptions"
		:chart-data="chartData"
		:chart-id="chartId"
		:dataset-id-key="datasetIdKey"
		:plugins="plugins"
		:css-classes="cssClasses"
		:styles="styles"
		:width="width"
		:height="height"
	/>
</template>