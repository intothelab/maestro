<template>
    <div>
        <heading class="mb-6">Embarques acumulados 2019</heading>
        <div class="">
            <div class="row">
                <div class="col-3 text-center">
                    <Card>
                        <h3>35554</h3>
                        ENTREGAS REALIZADAS
                    </Card>
                </div>
                <div class="col-3 text-center">
                    <Card>
                        <h3>35554</h3>
                        PERFORMANCE GERAL
                    </Card>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-primary mr-3">TRANSPORTADORAS</button>
                    <button type="button" class="btn btn-light">CLIENTES</button>
                    <button type="button" class="btn btn-light" v-if="false">LOCALIZAÇÃO</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-6" style="position:relative">
                    <Card>
                        <highcharts  :options="chartDunet"></highcharts>
                        <div class="hidden_text"></div>
                    </Card>
                </div>
                <div class="col-6">
                    <Card>
                        <highcharts  :options="chartBar"></highcharts>
                        <div class="hidden_text"></div>
                    </Card>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <Card>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Transportadora</th>
                                    <th>Número de Entregas</th>
                                    <th>Número de Atrasos</th>
                                    <th>Último Més</th>
                                    <th>Performace Média</th>
                                    <th>Tendência</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="dot_status"></div>
                                    </td>
                                    <td>Casas Bahia</td>
                                    <td>343</td>
                                    <td>34323</td>
                                    <td>98%</td>
                                    <td>56%</td>
                                    <td>2%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="dot_status dot_status_red"></div>
                                    </td>
                                    <td>Casas Bahia</td>
                                    <td>343</td>
                                    <td>34323</td>
                                    <td>98%</td>
                                    <td>56%</td>
                                    <td>2%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="dot_status dot_status_orange"></div>
                                    </td>
                                    <td>Casas Bahia</td>
                                    <td>343</td>
                                    <td>34323</td>
                                    <td>98%</td>
                                    <td>56%</td>
                                    <td>2%</td>
                                </tr>
                            </tbody>
                        </table>

                    </Card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Card from './Card'
import moment from 'moment'
import {Chart} from 'highcharts-vue'

export default {
    data() {
        return {
            loading:true,
            chartDunet: {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Entregas por Cliente'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Delivered amount',
                    data: [
                        ['Bananas', 8],
                        ['Kiwi', 3],
                        ['Mixed nuts', 1],
                        ['Oranges', 6],
                        ['Apples', 8],
                        ['Pears', 4],
                        ['Clementines', 4],
                        ['Reddish (bag)', 1],
                        ['Grapes (bunch)', 1]
                    ]
                }]
            },
            chartBar: {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Performance Top 10 Clientes'
                },
                xAxis: {
                    // type: 'category'
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%'
                        }
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                },

                series: [
                    {
                        name: "Browsers",
                        colorByPoint: true,
                        data: [
                            {
                                name: "Chrome",
                                y: 62.74,
                                drilldown: "Chrome"
                            },
                            {
                                name: "Firefox",
                                y: 10.57,
                                drilldown: "Firefox"
                            },
                            {
                                name: "Internet Explorer",
                                y: 7.23,
                                drilldown: "Internet Explorer"
                            },
                            {
                                name: "Safari",
                                y: 5.58,
                                drilldown: "Safari"
                            },
                            {
                                name: "Edge",
                                y: 4.02,
                                drilldown: "Edge"
                            },
                            {
                                name: "Opera",
                                y: 1.92,
                                drilldown: "Opera"
                            },
                            {
                                name: "Other",
                                y: 7.62,
                                drilldown: null
                            }
                        ]
                    }
                ],
            }
        }
    },
    created(){
        //this.load();
    },
    methods:{
        // load(){
        //     this.$http.get('url').then(response=>{
        //         this.loading = false
        //     })
        // },
    },
    components:{
        Card,
        highcharts: Chart
    }
}
</script>

<style>
    @import '../../../node_modules/bootstrap/dist/css/bootstrap.min.css';
    .hidden_text{
        background: #fff;
        position: absolute;
        height: 15px;
        width: 101px;
        right: 0px;
        bottom: 33px;
    }

    .dot_status {
        width: 15px;
        height: 15px;
        background: #0bad00;
        border-radius: 15px;
        margin: 0 auto;
        margin-top: 4px;
        border: 0.7px solid #0000002e;
    }

    .dot_status_red {
        background: red;
    }

    .dot_status_orange {
        background: orangered;
    }

    .btn-primary {
        color: #fff;
        background-color: #5b86ff;
        border-color: #007bff;
    }
</style>
