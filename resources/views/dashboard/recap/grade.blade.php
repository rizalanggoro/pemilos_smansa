@extends('layout.app-local')
@section('title', 'Pemilos SMANSA | Halaman test')
@section('content')
{{-- script --}}
<script>
  let chartContext = null
  let chart = null

  let jsonString = '{!! $candidates !!}'
  jsonString = jsonString.replace(/\n/g, "\\n")
    .replace(/\r/g, "\\r")
    .replace(/\t/g, "\\t")
    .replace(/\f/g, "\\f")
  let arrayCandidates = JSON.parse(jsonString)

  // let arrayCandidates = JSON.parse('{!! $candidates !!}')
  let arrayVotes = JSON.parse('{!! json_encode($votes) !!}')
  
  let chartData = []
  let chartLabels = []
  let chartBackgroundColors = []

  function loadChartData() {
    for(let i = 0; i < arrayCandidates.length; i++) {
      let candidate = arrayCandidates[i]
      let candidateId = candidate['id']

      chartLabels.push(candidate.name)
      chartBackgroundColors.push(candidate.color)

      let votesCount = arrayVotes[candidateId] ? arrayVotes[candidateId].length : 0
      chartData.push(votesCount)
    }

    // for non select
    chartData.push({{ ($voters_count - $votes_count) }})
    chartLabels.push('Tidak memilih')
    chartBackgroundColors.push('#f44336')
  }

  function initializeChart() {
    chartContext = document.querySelector('#chart').getContext('2d')
    chart = new Chart(chartContext, {
      type: 'doughnut',
      data: {
        labels: chartLabels,
        datasets: [{
          data: chartData,
          backgroundColor: chartBackgroundColors,
        }]
      },
      options: {
        responsive: false,
        plugins: {
          legend: false,
        }
      }
    })
  }

  function percent(id, count) { 
    let percent = (count / {{ $voters_count }}) * 100
    percent = percent.toFixed(1)
    let el = document.querySelector(id)
    el.innerHTML = `${percent}%`
  }

  function showChartLegend() {
    let chartLegendEl = document.querySelector('#chart-legend')
    let btnToggleChartLegend = document.querySelector('#btn-toggle-chart-legend')
    if (chartLegendEl) {
      btnToggleChartLegend.classList.add('tw-hidden')

      chartLegendEl.classList.remove('tw-hidden')
      chartLegendEl.classList.add('block')

      loadChartData()
      if (chart) {
        chart.destroy()
      }
      initializeChart()
    }
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
            $loop->index == ($grade_index + 1)])>
            {{ $menu['title'] }}
          </a>
          @endforeach
        </div>
      </div>

      {{-- content --}}
      <div class="col mt-md-3">
        <div class="container-fluid">
          {{-- title and navigation --}}
          <div class="row align-items-center">
            <div class="col">
              <h1>
                {{ $classroom->name }}
              </h1>
            </div>
            <div class="col-auto">
              <nav>
                <ul class="pagination">
                  <li @class(['page-item', 'disabled'=> $classroom_index == 0])>
                    <a @class(['page-link'])
                      href="{{ url('/dashboard/recap/grade/' . $grade . '/class/' . ($classroom_index - 1)) }}">
                      Sebelumnya
                    </a>
                  </li>
                  <li @class(['page-item', 'disabled'=> $classroom_index == ($classrooms_count - 1)])>
                    <a @class(['page-link'])
                      href="{{ url('/dashboard/recap/grade/' . $grade . '/class/' . ($classroom_index + 1)) }}">
                      Selanjutnya
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>

          {{-- button show chart and legend --}}
          <div id="btn-toggle-chart-legend">
            <button class="btn btn-primary" onclick="showChartLegend()">
              Tampilkan hasil dari kelas {{ $classroom->name }}
            </button>
          </div>

          {{-- chart and legend / detail --}}
          <div id="chart-legend" class="row tw-hidden">
            {{-- chart --}}
            <div class="col-md-7 d-flex">
              <div style="flex: 1"></div>
              <canvas id="chart" width="500" height="500"></canvas>
              <div style="flex: 1"></div>

              {{-- script --}}
              <script>
                // if (chart) {
                //   chart.destroy()
                // }
                // initializeChart()
              </script>
            </div>

            {{-- legend / detail --}}
            <div class="col">
              <div class="container-fluid">
                @foreach ($candidates as $candidate)
                <div @class(['row', 'mt-1'=> $loop->index > 0]) style="background-color: {{ $candidate->color }}">
                  <div class="row">
                    <div class="col-auto py-3" style="width: 3.2rem">
                      <h4 class="text-white text-center m-0 p-0">
                        {{ $candidate->no }}.
                      </h4>
                    </div>
                    <div class="col py-3">
                      <h4 class="text-white m-0 p-0">{{ $candidate->name }}</h4>
                    </div>
                  </div>
                  <div class="row m-0 p-0">
                    <div class="col-auto" style="width: 3.2rem"></div>
                    <div class="col bg-white py-2">
                      <div class="row">
                        <div class="col">
                          @if (array_key_exists($candidate->id, $votes))
                          <h4 class="m-0 p-0" style="font-weight: normal">
                            {{ count($votes[$candidate->id]) }} suara
                          </h4>
                          @else
                          <h4 class="m-0 p-0" style="font-weight: normal">
                            0 suara
                          </h4>
                          @endif
                        </div>
                        <div class="col">
                          @if (array_key_exists($candidate->id, $votes))
                          <h4 id="percent-{{ $candidate->id }}" class="m-0 p-0" style="font-weight: normal"></h4>
                          <script>
                            percent('#percent-{{ $candidate->id }}', {{ count($votes[$candidate->id]) }})
                          </script>
                          @else
                          <h4 id="percent-{{ $candidate->id }}" class="m-0 p-0" style="font-weight: normal">0%</h4>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                {{-- non select --}}
                <div @class(['row', 'mt-1' ]) style="background-color: #f44336">
                  <div class="row">
                    <div class="col-auto py-3" style="width: 3.2rem"></div>
                    <div class="col py-3">
                      <h4 class="text-white m-0 p-0">
                        Tidak memilih
                      </h4>
                    </div>
                  </div>
                  <div class="row m-0 p-0">
                    <div class="col-auto" style="width: 3.2rem"></div>
                    <div class="col bg-white py-2">
                      <div class="row">
                        <div class="col">
                          <h4 class="m-0 p-0" style="font-weight: normal">
                            {{ ($voters_count - $votes_count) }} suara
                          </h4>
                        </div>
                        <div class="col">
                          <h4 id="percent-abcent" class="m-0 p-0" style="font-weight: normal">
                          </h4>

                          {{-- script --}}
                          <script>
                            percent('#percent-abcent', {{ ($voters_count - $votes_count) }})
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection