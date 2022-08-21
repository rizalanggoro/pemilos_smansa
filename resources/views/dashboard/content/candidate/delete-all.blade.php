@extends('dashboard.ly.dashboard', [
'active' => 'delete-all-candidate',
])

@section('action-menu')
@include('dashboard.ly.menu.candidate-menu', ['active' => 'delete-all'])
@endsection

@section('view')
{{-- title --}}
<h1>Kandidat &#8250; Hapus semua kandidat</h1>

{{-- content --}}
<div class="col-md-6">
  <p>
    Hapus semua kandidat dari database? <strong>Perhatian!</strong> Tindakan ini tidak dapat diurungkan.
  </p>

  {{-- button delete --}}
  <form action="{{ url('dashboard/candidate/delete-all') }}" method="POST">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-danger">
      Hapus semua kandidat
    </button>
  </form>
</div>
@endsection