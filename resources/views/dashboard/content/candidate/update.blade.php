@extends('dashboard.ly.dashboard', [
'active' => 'create-candidate',
])

@section('action-menu')
@include('dashboard.ly.menu.candidate-menu', ['active' => 'update'])
@endsection

@section('view')
{{-- title --}}
<h1>Kandidat &#8250; Ubah kandidat</h1>
<div class="col-md-6">
  {{-- form create candidate --}}
  <form action="{{ url('dashboard/candidate/update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    {{-- candidate id --}}
    <input type="hidden" value="{{ $candidate->id }}" name="id">

    {{-- candidate name --}}
    <label for="candidate-name" class="form-label p-0 mb-1">
      Nama kandidat
    </label>
    <input autocomplete="off" name="name" type="text" class="form-control" id="candidate-name"
      value="{{ $candidate->name }}">

    {{-- candidate no --}}
    <label for="candidate-no" class="form-label mt-2 p-0 mb-1">
      Nomor kandidat
    </label>
    <input autocomplete="off" name="no" type="number" class="form-control" id="candidate-no"
      value="{{ $candidate->no }}">

    {{-- candidate color --}}
    <label for="candidate-color" class="form-label mt-2 p-0 mb-1">
      Warna kandidat
    </label>
    <input autocomplete="off" name="color" type="color" class="form-control form-control-color" id="candidate-color"
      value="{{ $candidate->color }}" title="Choose your color">
    <p class="mt-2">
      <strong>Perhatian!</strong> Jangan menggunakan warna merah sebagai warna kandidat. Warna merah akah digunakan
      sebagai warna pemilih yang absen.
    </p>

    {{-- candidate photo --}}
    <label for="candidate-photo" class="form-label mt-2 p-0 mb-1">
      Foto kandidat
    </label>
    <input autocomplete="off" name="photo" class="form-control" type="file" id="candidate-photo" accept="image/*">
    <p class="mt-2">
      <strong>Perhatian!</strong> Jika foto kandidat dibiarkan kosong, maka akan menggunakan foto kandidat yang telah
      ada sebelumnya.
    </p>

    {{-- candidate detail -> vision & mission --}}
    <label for="candidate-detail" class="form-label mt-2 p-0 mb-1">
      Detail kandidat (visi dan misi)
    </label>
    <textarea autocomplete="off" name="detail" class="form-control" id="candidate-detail"
      rows="5">{{ html_entity_decode($candidate->detail) }}</textarea>

    {{-- button submit --}}
    <div class="d-flex mt-3">
      <div class="spacer" style="flex: 1"></div>
      <button type="submit" class="btn btn-primary">Simpan perubahan</button>
    </div>
  </form>
</div>
@endsection