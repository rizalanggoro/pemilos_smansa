@extends('layout.app-voter')
@section('title', $title . ' | Masuk')
@section('content')
{{-- style --}}
<style>
  ::-webkit-scrollbar {
    display: none;
  }
</style>

{{-- template --}}
{{-- sm --}}
<div class="d-flex d-md-none root">
  <div class="container-fluid p-0 m-0">
    {{-- row image --}}
    <div class="row mt-1 mx-1">
      <div class="col p-0 m-0">
        <img src="{{ $cover_image ? url('storage/' . $cover_image) : asset('images/background/patternpad.svg') }}"
          class="img img-fluid w-100 rounded" style="object-fit: cover; object-position: center">
      </div>
    </div>

    {{-- row form --}}
    <div class="container mt-3">
      <div class="row">
        <div class="col">
          <h1 style="font-weight: 700" class="display-4">
            {{ $title }}
          </h1>
          <p class="p-0 m-0 mb-3" style="font-weight: normal">
            {{ $subtitle }}
          </p>

          {{-- alert --}}
          @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
          </div>
          @endif

          {{-- form login --}}
          <form action="{{ url('login') }}" method="POST" autocomplete="off">
            @csrf
            <input name="nis" type="text" class="form-control" id="nis" placeholder="Nomor induk siswa"
              value="{{ old('nis') }}">
            <input name="access_code" type="text" class="form-control mt-1" id="access_code" placeholder="Kode akses"
              value="{{ old('access_code') }}">

            {{-- button login --}}
            <button type="submit" class="btn btn-primary w-100 mt-3 text-white">
              Masuk
            </button>
          </form>

          <hr style="opacity: .08" class="mt-4">

          {{-- logo osis mpk --}}
          @if ($hide_osis_mpk == 'false')
          <p class="p-0 m-0 text-center mt-4 text-muted">
            An event organized by
          </p>
          <div class="row justify-content-center mt-2">
            <div class="col-auto">
              <img style="height: 2.8rem" src="{{ asset('images/osis.png') }}" class="me-2">
              <img style="height: 2.8rem" src="{{ asset('images/mpk.png') }}">
            </div>
          </div>
          @endif

          {{-- logo icc --}}
          <p class="p-0 m-0 text-center mt-4 text-muted">
            Another project curated by
          </p>
          <div class="row justify-content-center mt-2 mb-4">
            <div class="col-auto">
              <img style="height: 2.8rem" src="{{ asset('images/logo-icc.png') }}">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- >= md --}}
<div class="d-none d-md-flex root vh-100 w-100 bg-white" style="overflow-y: hidden">
  <div class="container-fluid p-0 m-0 h-100">
    <div class="row m-0 h-100 w-100 row-cols-1 row-cols-md-2">
      {{-- col image --}}
      <div class="col col-md-7 p-0 h-100 p-2">
        <img src="{{ $cover_image ? url('storage/' . $cover_image) : asset('images/background/patternpad.svg') }}"
          class="img img-fluid w-100 h-100 rounded" style="object-fit: cover; object-position: center">
      </div>

      {{-- col form --}}
      <div class="col col-md-5 p-0 h-100" style="overflow-y: auto">
        <div class="container">
          <div class="row">
            <div class="col my-3 px-lg-5 my-md-5">
              <h1 style="font-weight: 700">
                {{ $title }}
              </h1>
              <p class="fs-5 mb-3 mb-md-5" style="font-weight: normal">
                {{ $subtitle }}
              </p>

              {{-- alert --}}
              @if ($errors->any())
              <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
              </div>
              @endif

              {{-- form login --}}
              <form action="{{ url('login') }}" method="POST" class="mb-3 mb-md-5" autocomplete="off">
                @csrf
                <input name="nis" type="text" class="form-control" id="nis" placeholder="Nomor induk siswa"
                  value="{{ old('nis') }}">
                <input name="access_code" type="text" class="form-control mt-2" id="access_code"
                  placeholder="Kode akses" value="{{ old('access_code') }}">

                {{-- button login --}}
                <button type="submit" class="btn btn-primary w-100 mt-3 text-white">
                  Masuk
                </button>
              </form>

              <hr style="opacity: .16" class="mt-3">

              {{-- logo osis mpk --}}
              @if ($hide_osis_mpk == 'false')
              <p class="p-0 m-0 text-center mt-md-4 text-muted">
                An event organized by
              </p>
              <div class="row justify-content-center mt-2">
                <div class="col-auto">
                  <img style="height: 3.2rem" src="{{ asset('images/osis.png') }}" class="me-2">
                  <img style="height: 3.2rem" src="{{ asset('images/mpk.png') }}">
                </div>
              </div>
              @endif

              {{-- logo icc --}}
              <p class="p-0 m-0 text-center mt-md-4 text-muted">
                Another project curated by
              </p>
              <div class="row justify-content-center mt-2">
                <div class="col-auto">
                  <img style="height: 3.2rem" src="{{ asset('images/logo-icc.png') }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection