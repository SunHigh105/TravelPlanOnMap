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
  @yield('content')
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!--<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.apikey')}}"></script>-->
  <script src="{{ asset('js/app.js')}}"></script>
</body>
</html>