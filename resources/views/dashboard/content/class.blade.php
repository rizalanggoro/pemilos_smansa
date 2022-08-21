@extends('dashboard.ly.dashboard', [
'active' => 'class',
])

@section('view')
{{-- title --}}
<h1>Kelas</h1>

@if ($classrooms->count() == 0)
<p>Data kelas tidak ditemukan</p>
@else
{{-- table classrooms --}}
<table class="table mt-3">
  <thead style="background-color: #0d6efd; color: white">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nama</th>
      <th scope="col">Kelas</th>
      <th scope="col">Anggota</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($classrooms as $classroom)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $classroom->name }}</td>
      <td>{{ $classroom->grade }}</td>
      <td>{{ $classroom->voters()->get()->count() }}</td>
      <td>
        <a type="button" class="btn btn-sm btn-warning"
          href="{{ url('dashboard/class/clear/' . $classroom->id) }}">Hapus anggota</a>
        <a type="button" class="btn btn-sm btn-danger"
          href="{{ url('dashboard/class/delete/' . $classroom->id) }}">Hapus kelas</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif
@endsection