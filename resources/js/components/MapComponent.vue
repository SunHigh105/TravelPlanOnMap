<template>
    <div id="map-comp" v-bind:style="mapStyle">
        <div class="row">
            <!--map-->
            <div class="columns medium-8 map-area">
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
                    <!--<button class="button search-button" v-on:click="registPlan()">Regist</button>-->
                    <button class="button search-button" v-on:click="registPlan()">Regist</button>
                    <button class="button search-button" v-on:click="dispForm">Edit</button>
                </div>
                <div v-else>
                    <button class="button search-button" v-on:click="backPlanList()">Back</button>
                </div>
                <div id="list" v-for="output in outputs" v-bind:key="output.index">
                    <div class="card" v-if="output.distance">
                        <div class="card-section">
                            <div class="distance">{{ output.duration }} ({{ output.distance }})</div>
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
    </div>
</template>
<script>
import Bus from '../bus';
export default {
    data(){
        return{
            outputs:[],
            //プランタイトル
            title: '',
            hour: '',
            minute: '',
            //登録済みかどうか
            isRegisterd: 0,
            //地図関連
            center: {
                lat:35.6585805, 
                lng:139.7454329
            },
            zoom: 12,
            markers: [],
            mapStyle: {
                "display" : "none"
            },
        }
    },
    methods: {
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
        createPlaceLists(planInfo, items, isRegisterd){
            // タイトル、時刻、登録ずみか設定
            this.title = planInfo.title;
            this.hour = planInfo.hour;
            this.minute = planInfo.minute;
            this.isRegisterd = isRegisterd;
            // 時刻計算用
            var totalTime = 0;
            var fromTime = '';
            var toTime = '';
            //オブジェクト→配列に変換
            var array = Object.entries(items).map(item => {
                return item[1];
            }).sort(function(a, b){
                return a.index - b.index;
            });
            //console.log(array);
            array.forEach(item => {
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
            this.mapStyle["display"] = "block";
        },
        dispForm(){
            // 地図表示をリセット
            this.resetMapDisplay();
            this.mapStyle["display"] = "none";
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
            axios.post('api/registPlace', this.outputs).then((response) => {
                alert('プランの登録に成功しました！');
            }).catch((error) => {
                console.log(error);
                alert('プランの登録に失敗しました...');
            });
            // 地図表示をリセット
            this.resetMapDisplay();
            // フォームの値をリセット
            this.$emit('resetForm');
            //入力画面に戻す
            this.dispForm();
        },
        backPlanList(){
            // 地図表示をリセット
            this.resetMapDisplay();
            this.dispForm();
        },
        resetMapDisplay(){
            this.outputs = [];
            this.markers = [];
            this.title = '';
            this.hour = '';
            this.minute = '';
            //登録済みフラグを戻す
            this.isRegisterd = 0;
        },

    }
}
</script>