@extends('layout.app-voter')
@section('title', $title . ' | Halaman Pemilihan')
@section('content')
<div class="root">
  @include('vote.navbar')

  {{-- content --}}
  <div class="container">
    <div class="row mt-3 mt-md-3">
      <div class="col">
        {{-- img --}}
        <img src="{{ $cover_image ? url('storage/' . $cover_image) : asset('images/background/patternpad.svg') }}"
          class="img img-fluid w-100 rounded" style="height: 12rem; object-fit: cover">
      </div>
    </div>

    <div class="row mt-3 mt-md-5 align-items-center">
      <div class="col">
        <h1 class="d-flex d-md-none display-4 p-0 m-0" style="font-weight: bold">
          {{ $title }}
        </h1>
        <h1 class="d-none d-md-flex display-6 p-0 m-0" style="font-weight: bold">
          {{ $title }}
        </h1>
        <h3 style="font-weight: 300" class="m-0 p-0">
          {{ $subtitle }}
        </h3>
      </div>
      <div class="col-12 col-md-auto mt-3 mt-md-0">
        <button id="btn-confirmation" data-bs-toggle="modal" data-bs-target="#modal-confirmation" type="button"
          class="btn btn-primary w-100" disabled>
          Konfirmasi pilihan
        </button>
      </div>
    </div>

    {{-- list candidates --}}
    <div class="row row-cols-1 row-cols-md-6 g-2 mt-3 mb-3">
      @foreach ($candidates as $candidate)
      <div class="col">
        <div class="card h-100">
          {{-- candidate image --}}
          <img src="{{ asset('storage/' . $candidate->photo) }}" class="img card-img-top img-fluid img-candidate"
            candidate-index="{{ $loop->index }}" style="height: 16rem; object-fit: cover">

          {{-- selected candidate status --}}
          <div id="img-candidate-selected-{{ $loop->index }}"
            class="visually-hidden div-selected position-absolute w-100 card-img-top d-flex"
            style="height: 16rem; background-color: rgba(0, 0, 0, .72)">
            <div class="w-100">
              <h5 class="text-center text-white" style="position: relative; top: 50%; transform: translateY(-50%)">
                Dipilih
              </h5>
            </div>
          </div>

          {{-- candidate name --}}
          <div class="card-body d-flex flex-column">
            <div class="card-content" style="flex: 1">
              <div style="top: 50%; transform: translateY(-50%)" class="position-relative">
                <h5 class="p-0 m-0">
                  {{ $candidate->name }}
                </h5>
              </div>
            </div>
            <div class="card-button mt-3">
              <button type="button" class="btn-candidate-detail btn btn-outline-primary btn-sm w-100"
                data-bs-toggle="modal" data-bs-target="#modal-candidate-detail" candidate-index="{{ $loop->index }}">
                Visi & misi
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <hr style="opacity: .08" class="mt-4 mt-md-5">

    {{-- logo osis mpk --}}
    @if ($hide_osis_mpk == 'false')
    <p class="text-center p-0 m-0 mt-4 mt-md-5">An event organized by</p>
    <div class="row justify-content-center mt-2">
      <div class="col-auto">
        <img style="height: 3.2rem" src="{{ asset('/images/osis.png') }}" class="img me-2">
        <img style="height: 3.2rem" src="{{ asset('/images/mpk.png') }}" class="img">
      </div>
    </div>
    @endif

    {{-- logo icc --}}
    <p class="text-center p-0 m-0 mt-3 mt-md-3">Another event curated by</p>
    <div class="row justify-content-center mt-2 mb-5 mb-md-5">
      <div class="col-auto">
        <img style="height: 3.2rem" src="{{ asset('images/logo-icc.png') }}" class="img">
      </div>
    </div>
  </div>

  {{-- modal candidate detail -> vision & mission --}}
  <div class="modal fade" id="modal-candidate-detail" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Visi dan misi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row row-cols-1 row-cols-md-2 p-0 m-0">
            <div class="col-auto ps-0 ms-0">
              <img style="height: 24rem; object-fit: cover"
                class="img-candidate-detail d-flex d-md-none w-100 img img-fluid rounded">
              <img style="height: 24rem; width: 16rem; object-fit: cover"
                class="img-candidate-detail d-none d-md-flex img img-fluid rounded">
            </div>
            <div class="col">
              <h1 class="mt-3 mt-md-0" id="candidate-name" style="font-weight: 600">Nama kandidat</h1>
              <div id="candidate-detail"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- modal confirm --}}
  <div class="modal fade" id="modal-confirmation" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Konfirmasi pilihan
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-center">
            Saya <strong>{{ $voter->name }}</strong> memilih,
          </p>
          <div id="alert-selected-candidate-name" class="alert alert-primary text-center" role="alert">
            null
          </div>
          <p class="text-center">
            {{ $confirmation_message }}
          </p>
        </div>
        <div class="modal-footer">
          <form action="{{ url('vote') }}" method="POST">
            @csrf
            <input name="voter-id" id="input-voter-id" type="hidden">
            <input name="selected-candidate-id" id="input-selected-candidate-id" type="hidden">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
          </form>
        </div>
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
  
  let selectedCandidateIndex = -1
  $(document).ready(function () {
    let imgCandidates = document.querySelectorAll('.img-candidate')
    imgCandidates.forEach(imgCandidate => {
      let candidateIndex = imgCandidate.getAttribute('candidate-index')
      let imgSelectedCandidate = document.querySelector(`#img-candidate-selected-${candidateIndex}`)
      $(imgCandidate).click(() => {
        if (selectedCandidateIndex == -1) {
          $(imgSelectedCandidate).removeClass('visually-hidden')
          selectedCandidateIndex = candidateIndex
        } else {
          let currentImgSelectedCandidate = document.querySelector(`#img-candidate-selected-${selectedCandidateIndex}`)

          // unselect previous candidate
          $(currentImgSelectedCandidate).addClass('visually-hidden');

          // select new candidate
          $(imgSelectedCandidate).removeClass('visually-hidden')
          selectedCandidateIndex = candidateIndex
        }

        if (selectedCandidateIndex != -1) {
          // enable confirmation button
          document.querySelector('#btn-confirmation').disabled = false

          // change alert selected candidate name
          document.querySelector('#alert-selected-candidate-name').innerHTML = jsonCandidates[selectedCandidateIndex]['name']

          // set nis and selected candidate id input
          $('#input-voter-id').val('{{ $voter->id }}')
          $('#input-selected-candidate-id').val(jsonCandidates[selectedCandidateIndex]['id'])
        }
      });
    })

    // candidate detail
    let modalCandidateDetail = document.querySelector('#modal-candidate-detail')
    modalCandidateDetail.addEventListener('show.bs.modal', (event) => {
      let button = event.relatedTarget
      let candidateIndex = button.getAttribute('candidate-index')

      // setup candidate photo
      let imgCandidateDetails = modalCandidateDetail.querySelectorAll('.img-candidate-detail')
      imgCandidateDetails.forEach(img => {
        img.src = '{{ asset('storage') }}/' + jsonCandidates[candidateIndex]['photo']
      })

      // setup candidate name
      let elCandidateName = modalCandidateDetail.querySelector('#candidate-name')
      elCandidateName.innerHTML = jsonCandidates[candidateIndex]['name']

      // candidate detail -> visi misi
      let elCandidateDetail = modalCandidateDetail.querySelector('#candidate-detail')
      let encodedDetail = jsonCandidates[candidateIndex].detail
      let decodedDetail = $('<div />').html(encodedDetail).text()
      elCandidateDetail.innerHTML = decodedDetail
    })
  });
</script>
@endsection