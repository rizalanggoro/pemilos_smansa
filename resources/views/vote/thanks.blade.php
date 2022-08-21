@extends('layout.app-voter')
@section('title', 'Pemilos SMANSA | Thanks')
@section('content')
<div class="root">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="alert alert-primary mt-3 mt-md-4" role="alert">
          {{ $thanks_message }}
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  setTimeout(() => {
    location.href = '{{ url('/') }}';
  }, {{ $thanks_page_timeout }})
</script>
@endsection