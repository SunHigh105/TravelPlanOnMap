<template>
<div id="form-component">
    <div class="tabs-panel is-active" id="input-form">
        <div class="grid-x grid-padding-x" v-for="input in inputs" v-bind:key="input.index">
            <div class="cell medium-1"></div>
            <input type="hidden" :value="input.index">
            <div class="cell medium-6">
                <label>目的地{{ input.index }}<input type="text" v-model="input.place"></label>
            </div>
            <div class="cell medium-3">
                <label>滞在時間(分)<input type="number" min=10 max=2000 step=10 v-model="input.time"></label>
            </div>
            <div class="button-wrapper">
                <button v-if="input.index > 1 && input.index === inputs.length" id="delete-form" class="button secondary" v-on:click="deleteForm()">Delete</button>
            </div>
        </div>
        <div class="grid-x grid-padding-x">
            <div class="cell medium-12">
                <div class="button-wrapper">
                    <button class="hollow button secondary add-button" v-on:click="addForm()">＋目的地を追加</button>
                </div>
            </div>
        </div>
        <div class="grid-x grid-padding-x start-time">
            <div class="cell medium-2"></div>
            <label>出発時刻</label>
            <div class="cell medium-2">
                <select v-model="hour">
                    <option v-for="hour in selectHour" 
                    v-bind:key="hour.val" 
                    v-bind:value="hour.val">{{ hour.disp }}
                    </option>
                </select>
            </div>
            :
            <div class="cell medium-2">
                <select v-model="minute">
                    <option v-for="minute in selectMinute" 
                    v-bind:key="minute.val" 
                    v-bind:value="minute.val">{{ minute.disp }}
                    </option>
                </select>
            </div>
            <div class="cell medium-3">
                <button id="search" class="button search-button" v-on:click="sendPlaces()">Search</button>
            </div>
        </div>
    </div>
    <map-component ref="map" v-on:resetForm="resetForm"></map-component>
</div>
</template>

<script>
import { totalmem } from 'os';
import { setTimeout } from 'timers';
export default {
    data(){
        return{
            inputs: [{
                index: 1,
                place: '',
                time: '',
            }],
            hour: 9,
            minute: 0,
            //時間のプルダウン用
            selectHour:[],
            selectMinute:[],
        }
    },
    mounted() {
        this.createSelectList();
    },
    methods: {
        createSelectList(){
            for(var i = 0; i <= 5; i++){
                this.selectMinute.push({
                    val: i * 10,
                    disp: String(i * 10).padStart(2,'0'),
                });
            }
            for(var i = 0; i <= 23; i++){
                //ゼロ埋め
                this.selectHour.push({
                    val: i,
                    disp: String(i).padStart(2,'0'),
                });
            }
        },
        addForm(){
            if(this.inputs.length < 10){
                this.inputs.push({
                    index: this.inputs.length + 1,
                    place: '',
                    time: '',
                });
            }else{
                alert('目的地の登録は最大10件です。');
            }
        },
        deleteForm(){
            if(this.inputs.length > 1){
                this.inputs.pop();
            }
        },
        sendPlaces(){
            try{
                var msg = '';
                this.inputs.forEach(input => {
                    if(input.place === ''){
                        msg = msg + '目的地' + input.index + 'を入力してください！\n';
                    }
                    if(input.time === ''){
                        msg = msg + '滞在時間' + input.index + 'を入力してください！\n';
                    }
                });
                if(this.hour === '' || this.minute === ''){
                    msg = msg + '出発時刻を設定してください！';
                }
                if(msg != ''){
                    throw new Error(msg);
                }
                // 引数planInfo作成
                let planInfo = {
                    title: '',
                    hour: this.hour,
                    minute: this.minute
                };
                this.$refs.map.createPlaceLists(planInfo, this.inputs, 0);
                // Loading→地図表示
                this.$emit('dispMap');
            }catch(e){
                alert(e);
            }
        },
        resetForm(){
            this.inputs = [{
                index: 1,
                place: '',
                time: '',
            }];
            this.hour = 9;
            this.minute = 0;
            this.title = '';
        },
    }
}
</script>