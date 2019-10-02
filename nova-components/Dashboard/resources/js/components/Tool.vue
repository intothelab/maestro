<template>
    <div>
        <heading class="mb-6">Embarques acumulados {{year}}</heading>
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
                    <button type="button" @click="setType(1)" v-bind:class="{'bg-blue-500':type==1, 'bg-white':type==2}" class="bg-white font-semibold py-2 px-4 border border-gray-400 rounded shadow mr-3">TRANSPORTADORAS</button>
                    <button type="button" @click="setType(2)" v-bind:class="{'bg-blue-500':type==2, 'bg-white':type==1}" class="bg-white font-semibold py-2 px-4 border border-gray-400 rounded shadow">CLIENTES</button>
                    <button type="button" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow" v-if="false">LOCALIZAÇÃO</button>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 p-2 pr-3" style="position:relative">
                    <Card style="padding-bottom: 19px;">
                        <highcharts  :options="chartDunet"></highcharts>
                        <div class="hidden_text"></div>
                    </Card>
                </div>
                <div class="w-1/2 p-2 pl-3">
                    <Card>
                        <highcharts  :options="chartBar"></highcharts>
                        <div class="hidden_text"></div>
                        <div class="text-center">
                            <Radio v-model="order" label="desc"  @change="sortData('desc')">Melhores</Radio>
                            <Radio v-model="order" label="asc"  @change="sortData('asc')">Piores</Radio>
                        </div>
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
                                    <th>
                                        <span v-if="type==2">Cliente</span>
                                        <span v-if="type==1">Transportadora</span>
                                    </th>
                                    <th>Número de Entregas</th>
                                    <th>Número de Atrasos</th>
                                    <th>Último Més</th>
                                    <th>Performace Média</th>
                                    <th>Tendência</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="reg in data" :key="reg.cnpj">
                                    <td>
                                        <div class="dot_status" v-bind:class="{'dot_status_red':reg.delivered_average<80,'dot_status_yellow':reg.delivered_average>=80&&reg.delivered_average<=90}"></div>
                                    </td>
                                    <td>{{reg.name}}</td>
                                    <td>{{reg.delivered_count}}</td>
                                    <td>{{reg.delivered_late_count}}</td>
                                    <td>{{reg.previous_month_average}}</td>
                                    <td>{{reg.delivered_average}}%</td>
                                    <td>{{reg.trend}}</td>
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
import _ from 'lodash'
import {Radio} from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

export default {
    data() {
        return {
            loading:true,
            type: 1, // 1 = transporter / 2 = companies
            year: Nova.config.year,
            delivered_count: 0,
            general_performance: 0,
            order: 'desc',
            data: [],
            chartDunet: {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Entregas por Transportadora'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
                },
                plotOptions: {
                    pie: {
                        innerSize: 200,
                        depth: 1
                    }
                },
                series: [{
                    name: 'Entregas',
                    data: []
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
                     type: 'category'
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
                        }
                    }
                },
                // tooltip: {
                //     pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b>'
                // },
                series: [
                    {
                        colorByPoint: true,
                        data: []
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
            this.raw = [];
            this.data = [];
            this.order = 'desc';
            Nova.request().get('/nova-vendor/dashboard/'+(this.type==1?'transporters':'companies')).then(response => {
                this.raw = response.data
                this.sortData('desc');
            })
        },
        sortData(order){
            console.log(order)
            let ChartData = [];
            this.data = this.raw.sort(order=='desc'?function(a, b){return b.delivered_count - a.delivered_count }:function(a, b){return a.delivered_count - b.delivered_count });
            ChartData = _.take(this.data,10);
            ChartData = ChartData;
            ChartData.push(_.reduce(_.slice(this.data, 10), function(result, value, key) {
                result.delivered_count += value.delivered_count
                return result;
            }, {
                name:'Outros',
                delivered_count: 0
            }))

            if(this.type==1){
                this.chartDunet.title.text = 'Entregas por Transportadora'
                this.chartDunet.series = [{
                    name: 'Entregas',
                    data: ChartData.map(r=>{
                        return {
                            name: r.name,
                            y: r.delivered_count,
                        }
                    })
                }]
                this.chartBar.title.text = 'Performance Top 10 Transportadoras'
                this.chartBar.series = [{
                    name: 'Entregas',
                    data: ChartData.map(r=>{
                        return {
                            name: r.name,
                            y: r.delivered_count,
                        }
                    })
                }]
            }else{
                this.chartDunet.title.text = 'Entregas por Cliente'
                this.chartDunet.series = [{
                    name: 'Entregas',
                    data: ChartData.map(r=>{
                        return [r.name, r.delivered_count]
                    })
                }]
                this.chartBar.title.text = 'Performance Top 10 Clientes'
                this.chartBar.series = [{
                    name: 'Entregas',
                    data: ChartData.map(r=>{
                        return {
                            name: r.name,
                            y: r.delivered_count,
                            drilldown: r.name
                        }
                    })
                }]
            }
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
        highcharts: Chart,
        Radio
    }
}
</script>

<style scoped>
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
        bottom: 32px;
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

    .dot_status_yellow {
        background: #ffeb00;
    }

    .btn-primary {
        color: #fff;
        background-color: #5b86ff;
        border-color: #007bff;
    }
</style>
