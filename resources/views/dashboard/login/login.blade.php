@extends('layout.app-local')
@section('title', 'Pemilos SMANSA | Login dashboard')

@section('content')
<div class="root">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h1 class="mt-3">Dashboard</h1>

        {{-- alert --}}
        @if ($errors->any())
        <div class="alert alert-danger mt-3" role="alert">
          {{ $errors->first() }}
        </div>
        @endif

        {{-- login form --}}
        <form action="{{ url('dashboard/login') }}" method="POST" class="mt-3">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">
              Alamat email
            </label>
            <input name="email" type="email" class="form-control" id="email" value="{{ old('email') }}">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">
              Kata sandi
            </label>
            <input name="password" type="password" class="form-control" id="password" value="{{ old('password') }}">
          </div>

          {{-- button login --}}
          <button type="submit" class="btn btn-primary w-100">
            Masuk
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection