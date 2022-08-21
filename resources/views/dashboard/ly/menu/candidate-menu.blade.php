<p class="p-0 m-0 text-primary fw-bold mt-3 ms-3">Lainnya</p>
<div class="list-group mt-1">
  <a href="{{ url('dashboard/candidate/create') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'create'])>
    Tambah kandidat
  </a>
  <a href="{{ url('dashboard/candidate/delete-all') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'delete-all'])>
    Hapus semua kandidat
  </a>
</div>