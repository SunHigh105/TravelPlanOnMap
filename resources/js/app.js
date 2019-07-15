/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
  load: {
    // key: "{{ env('API_KEY') }}",
    key: process.env.MIX_API_KEY,
    libraries: 'places', 
  },
});

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
    'form-component', 
    require('./components/FormComponent.vue').default
);
Vue.component(
    'map-component', 
    require('./components/MapComponent.vue').default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});

// var map;
// var point = {lat: 35.6585805, lng: 139.7454329};

// function initMap() {
//     map = new google.maps.Map(document.getElementById('map'), {
//         center: point,
//         zoom: 12
//     });
// }
// // 初回読み込み時
// initMap();

const vm = new Vue({
    el: '#searchForm',
    data:{
        num: 0,
        lists:[],
        place: '',
        time: '',
        markers:[],
        origin: '',
    },
    methods:{
        getLocation: function(){
            axios.post('api/place', {place: encodeURI(this.place)}).then((response) => {
                var results = response.data.results[0];
                // 地図の中心
                point = {
                    lat: results.geometry.location.lat,
                    lng: results.geometry.location.lng
                };
                //地図を表示
                initMap();

                this.lists.push({
                    // num: this.num + 1,
                    address: results.formatted_address,
                    place: this.place,
                    time: this.time,
                    lat: results.geometry.location.lat,
                    lng: results.geometry.location.lng,
                });

                // if(this.lists.length > 1){
                //     this.getRoute(this.origin, this.place, this.lists.length - 1);
                // }
                console.log(this.lists);

                // マーカーを追加
                this.addMarker(point, String(this.lists.length), map);

                this.markers.forEach(marker => {
                    // マーカーを置く
                    marker.setMap(map);
                });

                // 出発地点設定
                this.origin = this.place;

                // this.num = this.num + 1;
                // 入力フォームのリセット
                this.place = '';
                this.time = '';
            }).catch(error => {
                alert('目的地を見つけられませんでした！');
                console.log(error);
            });
        },
        addMarker: function(point, index, map){
            var marker = new google.maps.Marker({
                position: point,
                label: String(index),
                map: map
            });
            this.markers.push(marker);
        },
        getRoute: function(origin, destination, num){
            axios.post('api/route', {
                origin: encodeURI(origin),
                destination: encodeURI(destination)
            }).then((response) => {
                this.$set(this.lists[num], 'distance', response.data.routes[0].legs[0].distance.text);
                this.$set(this.lists[num], 'duration', response.data.routes[0].legs[0].duration.text);
            });

            // var directionsService = new google.maps.DirectionsService;
            // var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, draggable: true});

            // directionsDisplay.setMap(map);

            // directionsService.route({
            //     origin: origin,
            //     destination: destination,
            //     travelMode: travelMode,
            // },
            // function(response, status){
            //     if(status === 'OK'){
            //         directionsDisplay.setDirections(response);
            //     }
            // });
        },
        get_data(name) {
            return this.$data[name];
        },
        deleteData: function(message){
            if(!confirm('削除してもよろしいですか？')){
                return false;
            }
            //削除対象のインデックス
            var num = message;
            this.lists.splice(num, 1);
            //表示されているマーカーを消す
            // this.markers[num].setMap(null);
            //マーカー消す
            this.markers.splice(num, 1);

            this.markers.forEach(marker => {
                // マーカーを置く
                marker.setMap(map);
            });
        }
    },
});
