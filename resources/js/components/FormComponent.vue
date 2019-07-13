<template>
<div id="form-component">
    <!--目的地入力-->
    <div id="popup-bg" v-bind:style="popupStyle">
        <div class="popup">
            <h3>目的地の設定</h3>
            <div class="grid-container">
                <div class="grid-x grid-padding-x" v-for="item in items" v-bind:key="item.index">
                    <input type="hidden" :value="item.index">
                    <div class="cell medium-6">
                        <label>目的地{{ item.index }}<input type="text" class="place" v-model="item.place"></label>
                    </div>
                    <div class="cell medium-4">
                        <label>滞在時間(分)<input type="number" class="time" v-model="item.time"></label>
                    </div>
                    <button v-if="item.index > 1 && item.index === items.length" id="deleteForm" class="button secondary" v-on:click="deleteForm()">Delete</button>
                </div>
                <div class="grid-x grid-padding-x">
                    <div class="cell medium-4">
                        <button class="hollow button secondary" v-on:click="addForm()">＋目的地を追加</button>
                    </div>
                </div>
                <button id="search" class="button" v-on:click="sendPlaces()">Search</button>
            </div>
        </div>
    </div>
    <!--目的地リスト表示-->
    <button class="button" v-on:click="dispForm()">Edit</button>
    <div id="list" v-for="output in outputs" v-bind:key="output.index">
        <div class="card" v-if="output.distance">
            <div class="card-section">
                <div class="distance">{{ output.distance }}</div>
                <div class="duration">{{ output.duration }}</div>
            </div>
        </div>
        <div class="card">
            <div class="card-divider grid-x" >
                <div class="place cell medium-9"><p v-cloak>【{{ output.index }}】 {{ output.place }}</p></div>
            </div>
            <div class="card-section">
                <p v-cloak>住所：{{ output.address }}</p>
                <p v-cloak>滞在時間：{{ output.time }}分</p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            items: [{
                index: 1,
                place: '',
                time: '',
            }],
            outputs:[],
            popupStyle: {
                "display": "block" 
            }
        }
    },
    mounted() {
        console.log('This is FormComponent.');
    },
    methods: {
        addForm(){
            if(this.items.length < 10){
                this.items.push({
                    index: this.items.length + 1,
                    place: '',
                    time: '',
                });
            }else{
                alert('目的地の登録は最大10件です。');
            }
        },
        deleteForm(){
            if(this.items.length > 1){
                this.items.pop();
            }
        },
        sendPlaces(){
            try{
                var msg = '';
                this.items.forEach(item => {
                    if(item.place === ''){
                        msg = msg + '目的地' + item.index + 'を入力してください！\n';
                    }
                    if(item.time === ''){
                        msg = msg + '滞在時間' + item.index + 'を入力してください！\n';
                    }
                });
                if(msg != ''){
                    throw new Error(msg);
                }
                this.createPlaceLists();
            }catch(e){
                alert(e);
            }
        },
        createPlaceLists(){
            this.hiddenForm();
            this.items.forEach(item => {
                //目的地取得
                axios.post('api/place', {
                    place: encodeURI(item.place)
                }).then((response) => {
                    var results = response.data.results[0];
                    this.outputs.push({
                        index: item.index,
                        address: results.formatted_address,
                        place: item.place,
                        time: item.time,
                        lat: results.geometry.location.lat,
                        lng: results.geometry.location.lng,
                    });
                });
                //移動時間・移動距離取得
                if(item.index >= 2){
                    console.log(this.items[item.index - 2].place);
                    axios.post('api/route', {
                        origin: encodeURI(this.items[item.index - 2].place),
                        destination: encodeURI(item.place)
                    }).then((response) => {
                        this.$set(this.outputs[item.index - 1], 'distance', response.data.routes[0].legs[0].distance.text);
                        this.$set(this.outputs[item.index - 1], 'duration', response.data.routes[0].legs[0].duration.text);
                    });
                }
                console.log(this.outputs);
            });
        },
        hiddenForm(){
            this.popupStyle["display"] = "none";
        },
        dispForm(){
            this.popupStyle["display"] = "block";
            this.outputs = [];
        }
    }
}
</script>