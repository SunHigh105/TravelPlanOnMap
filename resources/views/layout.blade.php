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
              <li class="menu-text">
                <a href="{{ url('/')}}">Travel Plan Map</a>
              </li>
          </ul>
      </div>
      <div class="top-bar-right">
          <ul class="menu">
          @if(Auth::user())
            <li>{{ Auth::user()->name }} さん</li>
            <li><a href="{{ url('mypage')}}">Mypage</a></li>
            <li><a href="{{ url('logout')}}">Logout</a></li>
          @else
              <li><a href="{{ url('login/twitter')}}">twitterログイン</a></li>
          @endif 
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