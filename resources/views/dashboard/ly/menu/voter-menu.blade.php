<p class="p-0 m-0 text-primary fw-bold mt-3 ms-3">Lainnya</p>
<div class="list-group mt-1">
  <a href="{{ url('dashboard/voter/import') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'import'])>
    Impor data pemilih
  </a>
  <a href="{{ url('dashboard/voter/export') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'export'])>
    Ekspor data pemilih
  </a>
  <a href="{{ url('dashboard/voter/delete/all') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'delete-all'])>
    Hapus semua data pemilih
  </a>
</div>