<script>
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    ArcElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import { Bar,Pie } from 'vue-chartjs'
import ChartDataLabels from 'chartjs-plugin-datalabels';
ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Title, Tooltip, Legend, ChartDataLabels)

export default {
    name: "ElectionPieChart",
    components: {Bar,Pie},
    props: ['location'],
    data() {
        return {
            loading:false,
            dataPie1: null,
            dataPie2: null,
            dataPie3: null,
            backgroundColor: [
                '#77B252',
                '#5298D7',
                '#F7C100'
            ],
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    datalabels: {
                        backgroundColor: function(context) {
                            return context.dataset.backgroundColor;
                        },
                        borderRadius: 4,
                        color: 'white',
                        font: {
                            weight: 'bold'
                        },
                        padding: 6,
                        display: function(context) {
                            return context.dataset.data[context.dataIndex] > 0;
                        },
                        formatter: function(value, context) {
                            // return context.dataIndex + ': ' + Math.round(value*100) + '%';
                            const datapoints = context.chart.data.datasets[0].data
                            // console.log(datapoints)
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0) / 2
                            const percentage = Math.round(value / total * 100)
                            // return 'line1\nline2\n' + value;
                            // return ctx.dataIndex + ': ' + Math.round(value*100) + '%';
                            // return percentage.toFixed(2) + "%";
                            return 'V: ' + value + "" + '\nP: ' + percentage + "%";
                        }
                    }
                }
            },
            reports:{
                chattogram_casting:null,
                chattogram_non_casting:null,
                chattogram_voter:null,
                dhaka_casting:null,
                dhaka_non_casting:null,
                dhaka_voter:null,
                total_casting:null,
                total_non_casting:null,
                total_voter:null
            }
        }
    },
    created: function () {
        this.checkReport();
    },
    mounted() {
        setInterval(() => {
            this.checkReport();
            console.log('Page updated Successfully at ' + new Date().toLocaleTimeString() + '!')
        }, 40000); // reload every 10 seconds
        // this.showToast('Page updated Successfully at ' + new Date().toLocaleTimeString() + '!');
    },
    methods: {
        checkReport: function (){
            this.loading = false;
            axios
                // .get('/api/election/' + this.$route.params.election_id + '/casting_report')
                .get('/api/election_casting_report')
                .then(res => {
                    // this.showMessage = true;
                    this.reports = res.data;
                    this.dataPie1 = {
                        labels: [
                            'Total',
                            'Casted',
                            'Non-Casted'
                        ],
                            datasets: [{
                            label: 'Total',
                            data: [this.reports.total_voter,this.reports.total_casting,this.reports.total_non_casting],
                            backgroundColor: this.backgroundColor,
                            hoverOffset: 4,
                            datalabels: {
                                color: '#FFF'
                            }
                        }]
                    };
                    this.dataPie2 = {
                        labels: [
                            'Dhaka',
                            'Casted',
                            'Non-Casted'
                        ],
                            datasets: [{
                            label: 'Dhaka',
                            data: [this.reports.dhaka_voter,this.reports.dhaka_casting,this.reports.dhaka_non_casting],
                            backgroundColor: this.backgroundColor,
                            hoverOffset: 4,
                            datalabels: {
                                color: '#FFF'
                            }
                        }]
                    };
                    this.dataPie3 = {
                        labels: [
                            'Chittagong',
                            'Casted',
                            'Non-Casted'
                        ],
                            datasets: [{
                            label: 'Chittagong',
                            data: [this.reports.chattogram_voter,this.reports.chattogram_casting,this.reports.chattogram_non_casting],
                            backgroundColor: this.backgroundColor,
                            hoverOffset: 4,
                            datalabels: {
                                color: '#FFF'
                            }
                        }]
                    };
                    // this.getVoters();
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = true;
            });
        },
/*        checkExist(){
            setTimeout(() => {
                this.checkReport();
            }, 5000);
        }*/
    }
}
</script>

<template>
    <b-container class="bv-example-row text-center">
<!--        <b-row>-->
<!--            <b-col>-->
<!--                <div class="card">-->
<!--                    <div class="card-header text-light bg-secondary bg-gradient"><h4>Casting Graph</h4></div>-->
<!--                    <div class="card-body">-->
                        <b-row>
                            <b-col cols="4">
                                <b-row>
                                    <b-col><h2>Total</h2></b-col>
                                    <b-col><Pie v-if="loading" :data="dataPie1" :options="chartOptions"/></b-col>
                                </b-row>
                            </b-col>
                            <b-col cols="4">
                                <b-row>
                                    <b-col><h2>Dhaka</h2></b-col>
                                    <b-col><Pie v-if="loading" :data="dataPie2" :options="chartOptions"/></b-col>
                                </b-row>
                            </b-col>
                            <b-col cols="4">
                                <b-row>
                                    <b-col><h2>Chattogram</h2></b-col>
                                    <b-col><Pie v-if="loading" :data="dataPie3" :options="chartOptions"/></b-col>
                                </b-row>
                            </b-col>
                        </b-row>
<!--                    </div>-->
<!--                </div>-->

<!--            </b-col>-->
<!--        </b-row>-->
    </b-container>
</template>

<style scoped>

</style>
