@extends('dashboard.ly.dashboard', [
'active' => 'create-candidate',
])

@section('action-menu')
@include('dashboard.ly.menu.voter-menu', ['active' => 'import'])
@endsection

@section('view')
{{-- title --}}
<h1>Pemilih &#8250; Impor data</h1>
<div class="col-md-6">
  <p>
    <strong>Perhatian!</strong> Data yang diimpor harus berformat excel (.xlsx) dan dipisah - pisah setiap kelas.
  </p>
  <p>
    Data yang diimpor harus berisi "nis" dan "nama". Nama
    kelas akan diambil dari nama file yang diimpor.
  </p>

  <form action="{{ url('dashboard/voter/import') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- input --}}
    <label for="formFileMultiple" class="form-label">
      Data pemilih
    </label>
    <input name="voter_files[]" id="input-voter" class="form-control" type="file" multiple
      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" oninput="onInput()">

    {{-- list selected files --}}
    <ul class="list-group mt-3" id="list-selected-files">
    </ul>

    {{-- button import --}}
    <button type="submit" id="btn-import" class="btn btn-primary mt-3">
      Impor data
    </button>
  </form>
</div>

{{-- script --}}
<script>
  $(document).ready(function () {
    $('#list-selected-files').hide();
    $('#btn-import').hide();
  });

  function onInput() {
    let listSelectedFiles = document.querySelector('#list-selected-files')
    let files = document.querySelector('#input-voter').files
    
    if (files.length > 0) {
      $('#list-selected-files').show();
      $('#btn-import').show();

      for (let i = 0; i < files.length; i++) {
        let file = files[i]
        listSelectedFiles.innerHTML += `
          <li class="list-group-item">${file.name}</li>
        `
      }
    }
  }
</script>
@endsection