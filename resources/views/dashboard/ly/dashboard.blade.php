@extends('layout.app-local')
@section('title', \App\Models\Configuration::get('title') . ' | Dashboard')
@section('content')
{{-- template --}}
<div id="root" class="root w-100">
  {{-- navbar --}}
  <div class="root" id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container">
        <a class="navbar-brand">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ session()->get('email') }}
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li>
                  <a class="dropdown-item" href="{{ url('dashboard/logout') }}">
                    Keluar
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    {{-- divider --}}
    <div class="bg-secondary w-100" style="height: .06rem; opacity: .12;"></div>
  </div>

  {{-- content --}}
  <div class="container">
    <div class="row">
      {{-- menu --}}
      <div class="col-md-3 mt-3">
        <div class="list-group">
          <a href="{{ url('dashboard') }}" @class(['list-group-item list-group-item-action', 'active'=> isset($active)
            && $active ==
            'candidate'])>
            Kandidat
          </a>
          <a href="{{ url('dashboard/voter/0') }}" @class(['list-group-item list-group-item-action', 'active'=>
            isset($active)
            && $active
            == 'voter'])>
            Pemilih
          </a>
          <a href="{{ url('dashboard/class') }}" @class(['list-group-item list-group-item-action', 'active'=>
            isset($active)
            && $active
            == 'class'])>
            Kelas
          </a>
          <a href="{{ url('dashboard/setting') }}" @class(['list-group-item list-group-item-action', 'active'=>
            isset($active)
            && $active == 'setting'])>
            Setelan
          </a>
        </div>

        <div class="list-group mt-2">
          <a href="{{ url('dashboard/recap') }}" target="__blank" @class(['list-group-item list-group-item-action'])>
            Rekapitulasi
          </a>
        </div>

        {{-- action --}}
        @yield('action-menu')
      </div>

      {{-- view --}}
      <div class="col my-3">
        @yield('view')
      </div>
    </div>
  </div>
</div>
@endsection