<template>
<div id="form-component">
    <!--loading-->
    <div class="loading-bg" v-bind:style="loaderStyle">
        <div>Searching...</div>
    </div>
    <!--input form-->
    <div class="popup" v-bind:style="popupStyle">
        <div class="grid-container">
            <ul class="tabs" data-tabs id="example-tabs">
                <li class="tabs-title is-active"><a href="#input-form" aria-selected="true">目的地の設定</a></li>
                <li class="tabs-title" v-on:click="showPlan();"><a href="#plan-list">モデルプラン</a></li>
            </ul>
            <!--<h3>目的地の設定</h3>-->
            <div class="tabs-content" data-tabs-content="example-tabs">
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
                <div class="tabs-panel grid-x grid-padding-x" id="plan-list">
                    <div v-if="plans.length === 0">まだモデルプランが登録されていません。</div>
                    <div v-for="plan in plans" v-bind:key="plan.id">
                        <div class="card cell medium-8">
                            <div class="card-section grid-x">
                                <div class="cell medium-8 plan-title" v-on:click="getPlanDetail(plan.id)">{{ plan.plan_title }}</div>
                                <div class="cell medium-4">{{ plan.created_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!--map-->
        <div class="columns medium-8">
            <GmapMap ref="myMap"
            :center="center"
            :zoom="zoom"
            map-type-id="roadmap"
            >
                <GmapMarker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    :label="m.label"
                    :clickable="true"
                    :draggable="false"
                    @click="center=m.position"
                />
            </GmapMap>
        </div>
        <!--place list-->
        <div class="columns medium-4 place-list">
            <label>プラン名</label>
            <input type="text" v-model="title">
            <div v-if="isRegisterd === 0">
                <button class="button search-button" v-on:click="registPlan()">Regist</button>
                <button class="button search-button" v-on:click="dispForm()">Edit</button>
            </div>
            <div v-else>
                <button class="button search-button" v-on:click="backPlanList()">Back</button>
            </div>
            <div id="list" v-for="output in outputs" v-bind:key="output.index">
                <div class="card" v-if="output.distance">
                    <div class="card-section">
                        <div class="distance">{{ output.duration }} ({{ output.distance }})</div>
                        <!--<div class="duration"></div>-->
                    </div>
                </div>
                <div class="card">
                    <div class="card-divider grid-x" >
                        <div class="place cell medium-8">
                            【{{ output.index }}】 {{ output.place }}
                        </div>
                        <div class="place cell medium-4">
                            {{ output.fromTime }} ~ {{ output.toTime }}
                        </div>
                    </div>
                    <div class="card-section">
                        <p>住所：{{ output.address }}</p>
                        <p>滞在時間：{{ output.time }}分</p>
                        <input name="lat" type="hidden" :value="output.lat">
                        <input name="lng" type="hidden" :value="output.lng">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <map-component></map-component>
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
            plans: [],
            outputs:[],
            //プランタイトル
            title: '',
            //出発時刻
            hour: 9,
            minute: 0,
            //登録済みかどうか
            isRegisterd: 0,
            //入力フォーム・Loading
            popupStyle: {
                "display": "block" 
            },
            loaderStyle: {
                "display": "none" 
            },
            //地図関連
            center: {
                lat:35.6585805, 
                lng:139.7454329
            },
            zoom: 12,
            markers: [],
            //時間のプルダウン用
            selectHour:[],
            selectMinute:[],
        }
    },
    mounted() {
        this.createSelectList();
        this.showPlan();    
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
                console.log(this.inputs);
                this.createPlaceLists(this.inputs);
            }catch(e){
                alert(e);
            }
        },
        calcTime(hour, minute, time){
            var h = hour;
            var m = minute + time;
            if(m >= 60){
                h = h + Math.floor(m / 60);
                m = m % 60;
            }
            if(h >= 24){
                h = h - 24;
            }
            return String(h).padStart(2, '0') + ' : ' + String(m).padStart(2, '0');
        },
        createPlaceLists(items){
            var totalTime = 0;
            var fromTime = '';
            var toTime = '';
            items.forEach(item => {
                //目的地取得
                axios.post('api/place', {
                    place: encodeURI(item.place)
                }).then((response) => {
                    var results = response.data.results[0];
                    //目的地を追加
                    this.outputs.push({
                        index: item.index,
                        address: results.formatted_address,
                        place: item.place,
                        time: item.time,
                        lat: results.geometry.location.lat,
                        lng: results.geometry.location.lng
                    });
                    //マーカーを追加
                    this.markers.push({
                        position: {
                            lat: results.geometry.location.lat,
                            lng: results.geometry.location.lng
                        },
                        label: String(item.index)
                    })
                    if(item.index === 1){
                        //地図の中心
                        this.center.lat = results.geometry.location.lat;
                        this.center.lng = results.geometry.location.lng;
                        //fromTimeとtoTimeを設定
                        this.$set(this.outputs[item.index - 1], 'fromTime', this.calcTime(this.hour, this.minute, totalTime));
                        totalTime = totalTime + parseInt(item.time, 10);
                        this.$set(this.outputs[item.index - 1], 'toTime', this.calcTime(this.hour, this.minute, totalTime));
                    }
                    
                }).catch((error) => {
                    alert('目的地が見つかりませんでした');
                });
                //移動時間・移動距離取得
                if(item.index >= 2){
                    axios.post('api/route', {
                        origin: encodeURI(items[item.index - 2].place),
                        destination: encodeURI(item.place)
                    }).then((response) => {
                        // distanceとduration設定
                        this.$set(this.outputs[item.index - 1], 'distance', response.data.routes[0].legs[0].distance.text);
                        this.$set(this.outputs[item.index - 1], 'duration', response.data.routes[0].legs[0].duration.text);
                        // 移動時間を分に変換
                        var duration = response.data.routes[0].legs[0].duration.value;
                        totalTime = totalTime + Math.floor(duration / 60); 
                        //fromTimeとtoTimeを設定
                        this.$set(this.outputs[item.index - 1], 'fromTime', this.calcTime(this.hour, this.minute, totalTime));
                        totalTime = totalTime + parseInt(item.time, 10);
                        this.$set(this.outputs[item.index - 1], 'toTime', this.calcTime(this.hour, this.minute, totalTime));
                    }).catch((error) => {
                        alert('移動経路が見つかりませんでした');
                    });                    
                }
            });
            console.log(this.outputs);
            this.dispLoader();
        },
        dispForm(){
            this.popupStyle["display"] = "block";
            this.outputs = [];
            this.markers = [];
        },
        dispLoader(){
            //Loadingを3秒表示
            this.loaderStyle["display"] = "block";
            setTimeout(this.hiddenForm, 3000);
            setTimeout(this.hiddenLoader, 3000);
        },
        hiddenForm(){
            this.popupStyle["display"] = "none";
        },
        hiddenLoader(){
            this.loaderStyle["display"] = "none";
        },
        registPlan(){
            //プラン名の入力チェック
            if(this.title === ''){
                alert('プラン名を入力してください！');
                return false;
            }
            //プランの登録
            axios.post('api/registPlan', {
                plan_title: this.title,
                hour: this.hour,
                minute: this.minute
            }).then((response) => {
                //alert('プランの登録に成功しました！');
            }).catch((error) => {
                alert('プランの登録に失敗しました...');
            });
            //目的地の登録
            axios.post('api/registPlace', this.inputs).then((response) => {
                alert('プランの登録に成功しました！');
            }).catch((error) => {
                console.log(error);
                alert('プランの登録に失敗しました...');
            });
            //入力値リセット
            this.resetForm();
            //入力画面に戻す
            this.dispForm();
        },
        resetForm(){
            this.inputs = [{
                index: 1,
                place: '',
                time: '',
            }];
            this.outputs = [];
            this.hour = 9;
            this.minute = 0;
            this.title = '';
        },
        showPlan(){
            axios.post('api/showPlan').then((response) => {
                this.plans = response.data;
            }).catch((error) => {
                alert('プランの取得に失敗しました。');
            });
        },
        getPlanDetail(id){
            //idからplace取得
            axios.post('api/getPlaces', {plan_id: id})
            .then((response) => {
                var params = response.data;
                // タイトルと出発時刻設定
                this.plans.forEach(plan => {
                    if(plan.id === id){
                        this.hour = plan.start_time_h;
                        this.minute = plan.start_time_m;
                        this.title = plan.plan_title;
                    }
                });
                //登録済みフラグ
                this.isRegisterd = 1;
                //placeList表示
                this.createPlaceLists(params);
            }).catch((error) => {
                console.log(error);
                alert('お探しのプランが見つかりませんでした。');
            });
        },
        backPlanList(){
            //フォームをリセット
            this.resetForm();
            //入力フォーム表示
            this.dispForm();
            //登録済みフラグを戻す
            this.isRegisterd = 0;
        }

    }
}
</script>