@extends('dashboard.ly.dashboard', [
'active' => 'candidate',
])

@section('action-menu')
@include('dashboard.ly.menu.candidate-menu')
@endsection

@section('view')
{{-- title --}}
<h1>Kandidat</h1>

{{-- if candidate empty --}}
@if ($candidates->count() == 0)
<p>Data kandidat tidak ditemukan!</p>
@endif

{{-- list candidate --}}
@foreach ($candidates as $candidate)
<div @class([ 'card' , 'mt-2'=> $loop->index > 0,
  'mt-3' => $loop->index == 0,
  ])>
  <div class="row align-items-center">
    <div class="col-auto">
      {{-- candidate no --}}
      <small>
        <p class="position-absolute px-3 py-1 rounded mt-1 ms-1"
          style="background-color: rgba(255, 255, 255, .72); font-weight: 600">
          {{ $candidate->no }}
        </p>
      </small>

      {{-- candidate image --}}
      <img src="{{ asset('storage/' . $candidate->photo) }}" class="img img-fluid rounded-start"
        style="height: 8rem; object-fit: cover">
    </div>
    <div class="col">
      <h4>{{ $candidate->name }}</h4>
      <div class="row p-0 m-0">
        <div class="col-auto p-0 me-2">
          <button class="btn btn-sm text-white" disabled style="opacity: 1; background-color: {{ $candidate->color }}">
            {{ $candidate->color }}
          </button>
        </div>
        <div class="col-auto p-0">
          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-candidate-detail"
            candidate-index="{{ $loop->index }}">Visi & misi</button>
        </div>
      </div>
    </div>

    {{-- col action --}}
    <div class="col-auto me-4">
      <a href="{{ url('dashboard/candidate/update/' . $candidate->id) }}" type="button" class="btn btn-warning">Ubah</a>
      <a href="{{ url('dashboard/candidate/delete/' . $candidate->id) }}" type="button" class="btn btn-danger">Hapus</a>
    </div>
  </div>
</div>
@endforeach

{{-- modal candidate detail --}}
<div class="modal fade" id="modal-candidate-detail" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Visi dan Misi Kandidat
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            {{-- candidate photo --}}
            <img id="candidate-photo" class="img img-fluid rounded" style="height: 18rem; object-fit: cover">
          </div>

          {{-- candidate detail -> visi misi --}}
          <div class="col">
            <h2 id="candidate-name">...</h2>
            <div class="mt-3" id="candidate-detail"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- script --}}
<script>
  let jsonString = '{!! $candidates !!}'
  jsonString = jsonString.replace(/\n/g, "\\n")
    .replace(/\r/g, "\\r")
    .replace(/\t/g, "\\t")
    .replace(/\f/g, "\\f")
  let jsonCandidates = JSON.parse(jsonString)

  let modalCandidateDetail = document.querySelector('#modal-candidate-detail')
  modalCandidateDetail.addEventListener('show.bs.modal', (event) => {
    let candidateIndex = event.relatedTarget.getAttribute('candidate-index')
    let jsonCandidate = jsonCandidates[candidateIndex]

    let candidateName = modalCandidateDetail.querySelector('#candidate-name')
    let candidatePhoto = modalCandidateDetail.querySelector('#candidate-photo')
    let candidateDetail = modalCandidateDetail.querySelector('#candidate-detail')

    candidateName.innerHTML = jsonCandidate.no + '. ' + jsonCandidate.name
    candidatePhoto.src = '{{ asset('storage') }}/' + jsonCandidate.photo

    let encodedDetail = jsonCandidate.detail
    let decodedDetail = $('<div />').html(encodedDetail).text()
    candidateDetail.innerHTML = decodedDetail
  })
</script>
@endsection