<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TravelMap</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.3/css/foundation.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="top-bar">
      <div class="top-bar-left">
          <ul class="dropdown menu" data-dropdown-menu>
              <li class="menu-text">Travel Plan Map</li>
          </ul>
      </div>
      <div class="top-bar-right">
          <ul class="menu">
              <li><a href="{{ url('login/twitter')}}">twitterログイン</a></li>
          </ul>
      </div>
  </div>
  @yield('content')
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.3/js/foundation.js"></script>
  <script>
    $(document).foundation();
  </script>

</body>
</html>