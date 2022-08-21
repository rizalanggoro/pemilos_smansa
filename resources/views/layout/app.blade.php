{{-- configuration --}}
@php
$bootstrap_cdn = App\Models\Configuration::get('bootstrap-cdn');
@endphp

{{-- template --}}
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- bootstrap --}}
  @if ($bootstrap_cdn && $bootstrap_cdn == 'true')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  @else
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
  @endif

  {{-- google fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <title>
    @yield('title')
  </title>
  @livewireStyles
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

  {{-- include livewire --}}
  @livewireScripts

  {{-- content --}}
  @yield('content')


  {{-- bootstrap script --}}
  @if ($bootstrap_cdn && $bootstrap_cdn == 'true')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
  @else
  <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
  @endif
</body>

</html>