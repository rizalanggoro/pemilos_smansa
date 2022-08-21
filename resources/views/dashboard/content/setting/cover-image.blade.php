@extends('dashboard.ly.dashboard', [
'active' => 'cover-image',
])

{{-- action menu --}}
@section('action-menu')
@include('dashboard.ly.menu.setting-menu', ['active' => 'cover-image'])
@endsection

@section('view')
{{-- title --}}
<h1>Setelan &#8250; Gambar sampul</h1>

<div class="mt-3 col-md-6">
  <p>Gambar sampul saat ini</p>
  <img src="{{ $cover_image->value ? url('storage/' . $cover_image->value) : url('images/background/patternpad.svg') }}"
    class="img img-fluid rounded tw-h-64 tw-object-cover tw-w-full">

  <form method="POST" action="{{ url('dashboard/setting/cover-image') }}" enctype="multipart/form-data" class="mt-3">
    @csrf
    <input name="cover_image" class="form-control" type="file" id="formFile" accept="image/*">

    {{-- button submit --}}
    <button class="btn btn-primary mt-3">Unggah</button>
  </form>

  {{-- button delete cover image --}}
  <a href="{{ url('dashboard/setting/cover-image/delete') }}" class="btn btn-danger mt-3">
    Hapus gambar sampul
  </a>
</div>
@endsection