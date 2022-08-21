@extends('dashboard.ly.dashboard')

@section('action-menu')
@include('dashboard.ly.menu.voter-menu', ['active' => 'export'])
@endsection

@section('view')
{{-- title --}}
<h1>Pemilih &#8250; Ekspor data</h1>
<div class="col-md-6">
  <p>
    Data pemilih akan diekspor sesuai dengan nama kelas yang berisi data NIS, nama, dan kode akses.
  </p>
  <a href="{{ url('dashboard/voter/export/all') }}" class="btn btn-primary">Ekspor data pemilih</a>
</div>

{{-- list voters --}}
<h3 class="mt-5">Daftar berkas pemilih</h3>
<div class="col-md-6">
  <p>
    Semua berkas pemilih akan diunduh dalam bentuk zip.
  </p>
  <div class="row">
    <div class="col-auto">
      <a href="{{ url('dashboard/voter/export/download/all') }}" @class(['btn btn-primary', 'disabled'=>
        count($voters) == 0])>
        Unduh semua berkas
      </a>
    </div>
    <div class="col-auto p-0 m-0">
      <form action="{{ url('dashboard/voter/export/all') }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" @class(['btn btn-outline-danger', 'disabled'=> count($voters) == 0])>
          Hapus semua berkas
        </button>
      </form>
    </div>
  </div>
</div>

<div class="col-md-6 mt-4">
  @foreach ($voters as $voter)
  <div @class(['card', 'mt-1'=> $loop->index > 0])>
    <div class="row p-3 align-items-center">
      <div class="col">
        <h6 class="p-0 m-0">
          {{ str_replace('exports/voters/', '', $voter) }}
        </h6>
      </div>
      <div class="col-auto">
        <a href="{{ asset('storage/' . $voter) }}" class="btn btn-sm btn-success">Unduh</a>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection