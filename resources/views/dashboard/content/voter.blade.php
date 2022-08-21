@extends('dashboard.ly.dashboard', [
'active' => 'voter',
])

{{-- action menu --}}
@section('action-menu')
@include('dashboard.ly.menu.voter-menu')
@endsection

{{-- view --}}
@section('view')
@if ($voters &&$voters->count() > 0)
<div class="row align-items-center">
  <div class="col">
    {{-- title --}}
    <h1>Pemilih</h1>
  </div>
  <div class="col-auto">
    <nav>
      <ul class="pagination">
        <li @class(['page-item', 'disabled'=> $classroom_index == 0])>
          <a class="page-link" href="{{ url('dashboard/voter/' . ($classroom_index - 1)) }}">
            Sebelumnya
          </a>
        </li>
        <li @class(['page-item', 'disabled'=> $classroom_index == ($classrooms_count - 1)])>
          <a class="page-link" href="{{ url('dashboard/voter/' . ($classroom_index + 1)) }}">
            Selanjutnya
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>

{{-- table voters --}}

<table class="table mt-3">
  <thead style="background-color: #0d6efd; color: white">
    <tr>
      <th scope="col">#</th>
      <th scope="col">NIS</th>
      <th scope="col">Nama</th>
      <th scope="col">Kode akses</th>
      <th scope="col">Kelas</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($voters as $voter)
    <tr>
      <th scope="row">{{ ($loop->index + 1) }}</th>
      <td>{{ $voter->nis }}</td>
      <td>{{ $voter->name }}</td>
      <td>{{ $voter->access_code }}</td>
      <td>{{ $classroom->name }}</td>
      <td>{{ $voter->vote()->first() ? 'Sudah' : 'Belum' }} memilih</td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
{{-- title --}}
<h1>Pemilih</h1>
<p>Data pemilih tidak ditemukan!</p>
@endif
@endsection