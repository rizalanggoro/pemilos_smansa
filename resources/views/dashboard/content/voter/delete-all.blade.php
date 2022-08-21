@extends('dashboard.ly.dashboard', [
'active' => 'create-candidate',
])

@section('action-menu')
@include('dashboard.ly.menu.voter-menu', ['active' => 'delete-all'])
@endsection

@section('view')
{{-- title --}}
<h1>Pemilih &#8250; Hapus semua data</h1>

<div class="col-md-6">
  <p>
    Hapus semua data pemilih dari database? Penghapusan ini akan menyertakan penghapusan semua data kelas. Tindakan ini
    tidak dapat diurungkan.
  </p>
  <form action="{{ url('dashboard/voter/delete/all') }}" method="POST">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger">
      Hapus semua data pemilih
    </button>
  </form>
</div>
@endsection