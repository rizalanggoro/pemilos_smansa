@extends('layout.app-local')
@section('title', 'Pemilos SMANSA | Halaman test')
@section('content')
<div class="root vh-100">
  <div class="container-fluid">
    <div class="row">
      {{-- list menu --}}
      <div class="col-md-3 mt-md-3">
        <div class="list-group">
          @foreach ($menus as $menu)
          <a href="{{ url($menu['href']) }}" @class(['list-group-item', 'list-group-item-action' , 'active'=>
            $loop->index ==
            0, ])>
            {{ $menu['title'] }}
          </a>
          @endforeach
        </div>
      </div>

      {{-- content --}}
      <div class="col mt-md-3">
        <h1>
          Hasil pemilihan ketua OSIS SMA Negeri 1 Magelang
        </h1>
      </div>
    </div>
  </div>
</div>
@endsection