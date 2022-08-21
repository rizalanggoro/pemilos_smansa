@extends('layout.app-local')
@section('title', 'Pemilos SMANSA | Perolehan Suara Total')
@section('content')
{{-- script --}}
<script>
  function initializeImageCandidate() {
    let els = document.querySelectorAll('.img-candidate')

    let candidateCount = {{ count($candidates) }}
    let rowCols = 2
    let rowCount = Math.round(candidateCount / rowCols)

    let windowHeight = window.innerHeight
    let rowHeight = (windowHeight / rowCount) * 11 / 12

    els.forEach(el => {
      $(el).height(rowHeight)
      $(el).width('100%')
    })
  }

  function startCount() {
    // hide button start count
    $('#btn-start-count').hide()

    let jsonString = '{!! $candidates !!}'
    jsonString = jsonString.replace(/\n/g, "\\n")
      .replace(/\r/g, "\\r")
      .replace(/\t/g, "\\t")
      .replace(/\f/g, "\\f")
    let arrayCandidates = JSON.parse(jsonString)

    // let arrayCandidates = JSON.parse('{!! json_encode($candidates) !!}')
    let arrayVotes = JSON.parse('{!! json_encode($votes) !!}')

    let arrayVotesCount = []
    for (let i = 0; i < arrayCandidates.length; i++) {
      let candidate = arrayCandidates[i]
      arrayVotesCount.push(arrayVotes[candidate.id])
    }

    let arrayFinishedService = []
    let service = setInterval(() => {
      for (let i = 0; i < arrayCandidates.length; i++) {
        let candidate = arrayCandidates[i]
        let el = document.querySelector(`#count-candidate-${candidate.id}`)

        let val = $(el).html()
        let valNumber = Number(val)
        let voteCount = arrayVotesCount[i]
        if (valNumber < voteCount) {
          valNumber += 1
        } else {
          if (arrayFinishedService.indexOf(candidate.id) === -1) {
            arrayFinishedService.push(candidate.id)

            if (arrayFinishedService.length === arrayCandidates.length) {
              // change to button success
              $(el).removeClass('btn-primary')
              $(el).addClass('btn-success')
            } else if (arrayFinishedService.length === arrayCandidates.length - 1) {
              // change to button warning
              $(el).removeClass('btn-primary')
              $(el).addClass('btn-danger')
            } else {
              // change to button danger
              $(el).removeClass('btn-primary')
              $(el).addClass('btn-danger')
            }
          }
        }

        $(el).html(valNumber)
      }
      console.log('called')

      // finish service
      if (arrayFinishedService.length >= arrayCandidates.length) {
        clearInterval(service)
      }
    }, 1000)
  }
</script>

{{-- template --}}
<div class="root">
  <div class="container-fluid">
    <div class="row">
      {{-- list menu --}}
      <div class="col-md-3 mt-md-3">
        <div class="list-group">
          @foreach ($menus as $menu)
          <a href="{{ url($menu['href']) }}" @class(['list-group-item', 'list-group-item-action' , 'active'=>
            $loop->index ==
            (count($menus) - 2), ])>
            {{ $menu['title'] }}
          </a>
          @endforeach
        </div>
      </div>

      {{-- content --}}
      <div class="col mt-md-3">
        <button id="btn-start-count" onclick="startCount()" type="button" class="btn btn-primary w-100 mb-md-3">Mulai
          perhitungan</button>
        <div class="row row-cols-md-2 g-3">
          @foreach ($candidates as $candidate)
          <div class="col">
            <div class="row align-items-center">
              <div class="col">
                <img src="{{ url('storage/' . $candidate->photo) }}" class="img-candidate img img-fluid rounded"
                  style="object-fit: cover">
              </div>
              <div class="col-md-7">
                <h4>{{ $candidate->name }}</h4>
                <button id="count-candidate-{{ $candidate->id }}" type="button" class="btn btn-primary w-100"
                  style="opacity: 1" disabled>0</button>
              </div>
            </div>
          </div>
          @endforeach

          {{-- script --}}
          <script>
            initializeImageCandidate()
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection