<template>
    <div>
        <heading class="mb-6 p-3 font-semibold">Embarques acumulados {{year}}</heading>
        <div class="flex ">
            <div class="w-1/4 p-3 text-center">
                <Card>
                    <div class="pb-4 pt-4">
                        <h3>{{delivered_count}}</h3>
                        <div class="mt-4 font-semibold">ENTREGAS REALIZADAS</div>
                    </div>
                </Card>
            </div>
            <div class="w-1/4 p-3 text-center">
                <Card>
                    <div class="pb-4 pt-4">
                        <h3>{{general_performance}}%</h3>
                        <div class="mt-4 font-semibold">PERFORMANCE GERAL</div>
                    </div>
                </Card>
            </div>
            <div class="w-1/4 p-3 text-center">
                <Card>
                    <div class="pb-4 pt-4">
                        <h3>{{divergence}}</h3>
                        <div class="mt-4 font-semibold">
                            DIVERGÊNCIA<span v-if="divergence>=2">S</span>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
        <div class="flex mb-4">
            <div class="w-full p-3 ">
                <Card>
                    <Tabs tab-position="top"  @tab-click="handleClick" value="1">
                        <TabPane label="TRANSPORTADORAS" name="1">
                            <div class="flex mb-4">
                                <div class="w-1/2 p-3 pr-3" style="position:relative">
                                        <highcharts  :options="chartDunet"></highcharts>
                                        <div class="hidden_text"></div>
                                </div>
                                <div class="w-1/2 p-3 pl-3">
                                        <highcharts  :options="chartBar"></highcharts>
                                        <div class="hidden_text"></div>

                                        <div class="text-center">
                                            <Radio v-model="order" label="desc"  @change="sortData('desc')">Melhores</Radio>
                                            <Radio v-model="order" label="asc"  @change="sortData('asc')">Piores</Radio>
                                        </div>
                                </div>
                            </div>
                        </TabPane>
                        <TabPane label="CLIENTES" name="2">
                            <div class="flex mb-4">
                                <div class="w-1/2 p-3 pr-3" style="position:relative">
                                        <highcharts  :options="chartDunet"></highcharts>
                                        <div class="hidden_text"></div>
                                </div>
                                <div class="w-1/2 p-3 pl-3">
                                        <highcharts  :options="chartBar"></highcharts>
                                        <div class="hidden_text"></div>

                                        <div class="text-center">
                                            <Radio v-model="order" label="desc"  @change="sortData('desc')">Melhores</Radio>
                                            <Radio v-model="order" label="asc"  @change="sortData('asc')">Piores</Radio>
                                        </div>
                                </div>
                            </div>
                        </TabPane>
                    </Tabs>
                </Card>
            </div>
        </div>

        <div class="flex mb-4 p-3 pt-0">
            <div class="w-full card text-center">
                <table cellpadding="0" cellspacing="0" data-testid="resource-table" class="table w-full mt-2">
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
            </div>
        </div>
    </div>
</template>

<script>
import Card from './Card'
import moment from 'moment'
import {Chart} from 'highcharts-vue'
import _ from 'lodash'
import {Radio, Tabs, TabPane} from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';


export default {
    data() {
        return {
            loading:true,
            type: 1, // 1 = transporter / 2 = companies
            year: Nova.config.year,
            delivered_count: 0,
            general_performance: 0,
            divergence: 0,
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
        this.divergence = Nova.config.divergence;
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
        handleClick(tab, event){
            this.type = parseInt(tab.name)
            this.load()
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
        Radio,
        Tabs,
        TabPane
    }
}
</script>

<style >
    .el-tabs__active-bar {
        background-color: #552e96;
    }
    .el-tabs__item:hover {
        color: #35136d;
    }
    .el-tabs__item.is-active {
        color: #35136d;
    }
    .el-tabs__item {
        font-weight: bold;
    }
    .el-radio__input.is-checked .el-radio__inner {
        border-color: #35136d;
        background: #7841d2;
    }

    .el-radio__input.is-checked+.el-radio__label {
        color: #7841d2;
        font-size: 15px;
        font-weight: 600
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


</style>
