<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TravelMap</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.3/css/foundation.css">
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
        $(document).on('click', '#searchButton', function(){
            $.ajax({
                type: 'POST',
                url: '/api/route',
                data: {
                    'origin': encodeURI($('#origin').val()),
                    'destination': encodeURI($('#destination').val())
                },
                datatype: 'json',
            }).done(function(data){
                // console.log(data);
                var arr = JSON.parse(data);
                console.log(arr.routes[0].legs[0]);
                // alert('OK');
            }).fail(function(){
                alert('NG');
            });
        });
    </script>
</head>
    <body>
    <div class="top-bar">
      <div class="top-bar-left">TravelMap</div>
    </div>
    <div id="map"></div>
    <div id="searchForm">
      <div class="grid-container">
        <div class="grid-x grid-padding-x">
          <div class="cell medium-4">
            <label>目的地<input type="text" id="place" v-model="place"></label>
          </div>
          <div class="cell medium-4">
            <label>滞在時間(分)<input type="number" id="time" v-model="time"></label>
          </div>
          <div class="cell medium-2">
            <button id="search" class="button" v-on:click="getLocation">Search</button>
          </div>
        </div>
      </div>

        <div id="list" v-if="lists" v-for="(list, index) in lists">
            <div class="card" v-if="index >= 1">
                <div class="card-section">
                    <div class="distance">@{{ list.distance }}</div>
                    <div class="duration">@{{ list.duration }}</div>
                </div>
            </div>
            <div class="card">
                <div class="card-divider grid-x" >
                    <div class="place cell medium-9"><p v-cloak>【@{{ index + 1 }}】 @{{ list.place }}<p></div>
                    <div class="cell medium-3">
                        <button class="button secondary deleteButton">Delete</button>
                    </div>
                </div>
                <div class="card-section">
                    <p v-cloak>住所：@{{ list.address }}</p>
                    <p v-cloak>滞在時間：@{{ list.time }}分</p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.apikey')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
</html>