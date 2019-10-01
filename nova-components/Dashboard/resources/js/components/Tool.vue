<template>
    <div>
        <heading class="mb-6">Embarques acumulados 2019</heading>
        <div class="">
            <div class="flex ">
                <div class="w-1/4 p-2 text-center">
                    <Card>
                        <div class="pb-6 pt-6">
                            <h3>{{delivered_count}}</h3>
                            ENTREGAS REALIZADAS
                        </div>
                    </Card>
                </div>
                <div class="w-1/4 p-2 text-center">
                    <Card>
                        <div class="pb-6 pt-6">
                            <h3>{{general_performance}}%</h3>
                            PERFORMANCE GERAL
                        </div>
                    </Card>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full p-2 text-right">
                    <button type="button" @click="setType(1)" v-class="{'bg-blue-500':type==1, 'bg-white':type==2}" class="bg-white  font-semibold py-2 px-4 border border-gray-400 rounded shadow mr-3">TRANSPORTADORAS</button>
                    <button type="button" @click="setType(2)" v-class="{'bg-blue-500':type==2, 'bg-white':type==1}" class="bg-white  font-semibold py-2 px-4 border border-gray-400 rounded shadow">CLIENTES</button>
                    <button type="button" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" v-if="false">LOCALIZAÇÃO</button>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 p-2 pr-3" style="position:relative">
                    <Card>
                        <highcharts  :options="chartDunet"></highcharts>
                        <div class="hidden_text"></div>
                    </Card>
                </div>
                <div class="w-1/2 p-2 pl-3">
                    <Card>
                        <highcharts  :options="chartBar"></highcharts>
                        <div class="hidden_text"></div>
                    </Card>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full p-2">
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
            type: 1, // 1 = transporter / 2 = customer
            delivered_count: 0,
            general_performance: 0,
            chartDunet: {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Entregas por Transportadora'
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
                    text: 'Performance Top 10 Transportadoras'
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
        this.delivered_count = Nova.config.delivered_count;
        this.general_performance = Nova.config.general_performance.toFixed(2);
        this.load();
    },
    methods:{
        load(){
            Nova.request().get('/nova-vendor/dashboard/'+(this.type==1?'transporters':'customers')).then(response => {
                console.log(response)
            })
        },
        setType(tp){
            if(tp != this.type){
                this.type = tp;
                this.load();
            }
        }
    },
    components:{
        Card,
        highcharts: Chart
    }
}
</script>

<style >
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #cacaca;
    }

    .hidden_text{
        background: #fff;
        position: absolute;
        height: 15px;
        width: 101px;
        right: 8px;
        bottom: 14px;
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
