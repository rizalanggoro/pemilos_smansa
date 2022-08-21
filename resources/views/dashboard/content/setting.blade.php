@extends('dashboard.ly.dashboard', [
'active' => 'setting',
])

{{-- action menu --}}
@section('action-menu')
@include('dashboard.ly.menu.setting-menu')
@endsection

@section('view')
{{-- title --}}
<h1>Setelan</h1>
<div class="col-md-5 mt-3">
  <form action="{{ url('dashboard/setting') }}" method="POST">
    @csrf

    {{-- title --}}
    <div class="mt-3">
      <label for="year" class="form-label">Judul website</label>
      <input type="text" class="form-control" id="year" name="title" value="{{ $title }}">
    </div>

    {{-- subtitle --}}
    <div class="mt-3">
      <label for="year" class="form-label">Subjudul website</label>
      <input type="text" class="form-control" id="year" name="subtitle" value="{{ $subtitle }}">
    </div>

    {{-- close web --}}
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" id="hide-from-public" name="hide_from_public" value="true"
        {{ $hide_from_public == 'true' ? 'checked' : '' }}>
      <label class="form-check-label" for="hide-from-public">
        Batasi web dari hadapan publik
      </label>
    </div>

    {{-- hide osis mpk --}}
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" id="hide-from-public" name="hide_osis_mpk" value="true"
        {{ $hide_osis_mpk == 'true' ? 'checked' : '' }}>
      <label class="form-check-label" for="hide-from-public">
        Sembunyikan logo OSIS MPK
      </label>
    </div>

    {{-- confirmation message --}}
    <div class="mt-3">
      <label for="year" class="form-label">Pesan konfirmasi</label>
      <input type="text" class="form-control" id="year" name="confirmation_message" value="{{ $confirmation_message }}">
    </div>

    {{-- thanks message --}}
    <div class="mt-3">
      <label for="year" class="form-label">Pesan terima kasih</label>
      <input type="text" class="form-control" id="year" name="thanks_message" value="{{ $thanks_message }}">
    </div>

    {{-- thanks page timeout --}}
    <div class="mt-3">
      <label for="year" class="form-label">Timeout halaman terima kasih (ms)</label>
      <input type="number" class="form-control" id="year" name="thanks_page_timeout" value="{{ $thanks_page_timeout }}">
    </div>

    {{-- button save --}}
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
  </form>
</div>
@endsection