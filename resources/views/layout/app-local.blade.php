<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- bootstrap --}}
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

  {{-- google fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  {{-- tailwind --}}
  <link rel="stylesheet" href="{{ url('css/app.css') }}">

  <title>
    @yield('title')
  </title>
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
    }

    .playfair {
      font-family: 'Playfair Display', serif;
    }
  </style>
</head>

<body>
  {{-- include jquery --}}
  <script src="{{ asset('js/jquery.js') }}"></script>
  <script src="{{ asset('js/chart.min.js') }}"></script>

  {{-- content --}}
  @yield('content')

  {{-- bootstrap script --}}
  <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>