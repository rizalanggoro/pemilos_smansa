<p class="p-0 m-0 text-primary fw-bold mt-3 ms-3">Lainnya</p>
<div class="list-group mt-1">
  <a href="{{ url('dashboard/setting/cover-image') }}" @class(['list-group-item list-group-item-action', 'active'=>
    isset($active) && $active == 'cover-image'])>
    Gambar sampul
  </a>
</div>