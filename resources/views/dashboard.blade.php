@php

$groupedLogs = $logs->groupBy('visitor_id')->map(function ($entries) {
    return [
        'visitor_id' => $entries->first()->visitor_id,
        'visit_count' => $entries->count(),
        'visitor_name' => $entries->first()->visitor->first_name . ' ' . $entries->first()->visitor->last_name,
    ];
})->sortByDesc('visit_count');

$visitorsToday = $logs->filter(function ($log) {
    return Carbon\Carbon::parse($log->visited_at)->isToday();
});
$visitorsWeekly = $logs->filter(function ($log) {
    $visitedAtWeek = Carbon\Carbon::parse($log->visited_at);

    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

    return $visitedAtWeek->between($startOfWeek, $endOfWeek);
});

$visitorsMonthly = $logs->filter(function ($log) {
    $visitedAtMonth = Carbon\Carbon::parse($log->visited_at);

    $startOf = Carbon\Carbon::now()->startOfMonth();
    $endOf = Carbon\Carbon::now()->endOfMonth();

    return $visitedAtMonth->between($startOf, $endOf);
});


$visitorsYearly = $logs->filter(function ($log) {
    $visitedAtYear = Carbon\Carbon::parse($log->visited_at);

    $startOf = Carbon\Carbon::now()->startOfYear();
    $endOf = Carbon\Carbon::now()->endOfYear();

    return $visitedAtYear->between($startOf, $endOf);
});

$countVisYear = $visitorsYearly->count();
$countVisMonth = $visitorsMonthly->count();
$countVisWeek = $visitorsWeekly->count();
$countVisToday = count($visitorsToday);

$segmentUrl = request()->segment(2);

$currentYear = Carbon\Carbon::now()->year;
$getAuthUser = auth()->user();
@endphp
<!DOCTYPE html>
<html {{ request()->cookie('theme', 'light') }} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>
        <link rel="icon" type="image/x-icon" href="{{asset('storage/images/imus_logo.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Fonts -->

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css /html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5},:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        */
        body {
            background-color: rgb(214, 236, 255);
        }
        </style> 
        <link rel="stylesheet" href="{{ asset('/css/css.css') }}"/>
<body>
    
    @if(is_null($getAuthUser->dept_id))
        @include('partials.firstlogin')
    @else

    @auth
    <section>
        <div class="d-flex " style="height: 100vh">
            @include('partials.sidebar')
        </div>

        @include('partials.alertmsg')

        <div class="w-100">
            <div class="container bg-white rounded mt-3 p-4 pt-2" style="height: fit-content; width: 90%;">
                <div class="d-flex justify-content-between">
                <h4>
                    Department Overview 
                </h4>
                <select id="deptChange" class="form-select" style="width: 25%"

                @if($getAuthUser->dept_id != 0)
                hidden
                @endif data-bs-toggle="tooltips" data-bs-placement="left" title="Choose a department to show statistics of">
                    <option value="0">All</option>
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}" 
                            @if ($segmentUrl == $department->id)
                                selected
                            @endif>{{$department->dept_name}}</option>
                    @endforeach
                </select>
                </div>
                <div class="row justify-content-center">
                <a class="TotalVisitorsToday rounded btnclass m-3 p-3" href="{{route('search.spfilterlogs', ['DateSearch' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                    Visitors Today
                    <p class="TotalTVT m-2 fs-3">{{$countVisToday}}</p>
                </a>
                <a class="CurrentCheckins rounded btnclass m-3 p-3" href="{{route('search.spfilterlogs', ['weekSearch' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                    Visitors This Week
                    <p class="TotalCCI m-2 fs-3">{{$countVisWeek}}</p>
                </a>
                <a class="ExpectedVisitors rounded btnclass m-3 p-3" href="{{route('search.spfilterlogs', ['monthSearch' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                    Visitors This Month
                    <p class="TotalEV m-2 fs-3">{{$countVisMonth}}</p>
                </a>
                <a class="FlaggedVisitors rounded btnclass m-3 p-3" href="{{route('search.spfilterlogs', ['yearSearch' => \Carbon\Carbon::now()->format('Y-m-d')])}}">
                    Visitors This Year
                    <p class="TotalFV m-2 fs-3">{{$countVisYear}}</p>
                </a>
                </div>
            </div>
            <div class="container bg-white rounded mt-4 p-4 pt-2" style="height: fit-content; width: 90%;">
                <h3 class="p-2">Visitor Statistics</h3>
                <section class="d-flex">
                <div class="chart-container" style="width: 70%;">
                    
                <h3 style="text-align: center">Total Visits</h3>
                <div class="d-flex justify-content-center nav nav-tabs pb-0" role="tablist">
                    <li class="nav-item">
                    <button class="nav-link active dailyVisits m-2 mb-0 rounded" id="dailyVisit" type="button" role="presentation" data-bs-toggle="tab" data-bs-target="#chartDaily">
                        Daily 
                    </button>
                    </li>
                    <li class="nav-item">
                    <button class="nav-link monthlyVisits m-2 mb-0 rounded" id="monthlyVisit" type="button" role="presentation" data-bs-toggle="tab" data-bs-target="#chartMonth">
                        Monthly 
                    </button>
                    </li>
                    <li class="nav-item">
                    <button class="nav-link yearlyVisits m-2 mb-0 rounded" id="yearlyVisit" type="button" role="presentation" data-bs-toggle="tab" data-bs-target="#chartYear">
                        Yearly 
                    </button>
                    </li>
                </div>
                <div class="tab-content">
                <div class="tab-pane fade show active" id="chart" role="tabpanel"></div>
                <div class="tab-pane fade" id="chartMonth" role="tabpanel"></div>
                <div class="tab-pane fade" id="chartYear" role="tabpanel"></div>
                </div>
                </div>
                <div class="p-2 m-4 mt-0" style="width: 30%">
                    <h4>Visit Log</h4>
                    <div class="visitorLogs">
                        @if($logs->count() !==0)
                        <!-- if $visitor log status then change color-->
                    @for ($i = 0; $i < min(20, $logs->count()); $i++)

                        <p class="statusGood p-1">{{$logs[$i]->visitor->last_name}}, {{$logs[$i]->visitor->first_name}} | {{$logs[$i]->purpose}} | {{ \Carbon\Carbon::parse($logs[$i]->visited_at)->format('m-d H:i:s') }}</p>
                    @endfor
                        @else
                        <p class="p-3 text-primary">Nothing</p>
                        @endif
                    <a href="{{route('view.logs')}}" class="ms-2">See more...</a>
                    </div>
                    <h4 class="mt-3">Frequent Visitors</h4>
                    <div class="frequentVisits">
                        @if($groupedLogs->count() !== 0)
                    @foreach ($groupedLogs as $log)
                        <p class="VisitorFrqMssg p-2">{{$log['visitor_name']}} | {{$log['visit_count']}} times</p>
                    @endforeach
                        @else
                            Nothing
                        @endif
                        </div>
                    </div>
                </div>
                </section>
                    
            </div>
            
        </div>

    </section>
    @else

    @include('partials.invalid-perms')

    @endauth
    @endif

</body>


<script>
    $(function(){
      $('#deptChange').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) {
              window.location = "/dashboard/" + url; // redirect
          }
          return false;
      });
    });
</script>

<script>
    let currentperiod = 'daily';
    const options = {
        chart: { 
            type: 'line', 
            animation: {
                enabled: true,
                easing: 'linear',
                speed: 300,
            },
            zoom: {
                enabled: true
            
            },
            toolbar: {
                show: true
            }
        },
        xaxis: {type: 'datetime',
                labels: {
                    showDuplicates: false,
                    formatter: function (value, timestamp, opts) {
                    const period = currentperiod;
                    const date = new Date(timestamp);
                    if(period == 'yearly'){
                       return date.getUTCFullYear();
                    } else if (period == 'monthly') {
                        return date.toLocaleString('default', { month: 'short' , year: 'numeric'});
                    } else {
                        return date.toLocaleDateString();
                    }
                },
                
                },
        },
        yaxis: {
            labels: {
                tickAmount: 5,
                forceNiceScale: true,
                formatter: function (value) {
                    return Number.isInteger(value) ? value : '';
                },
            }
        },
        series: [{ name: 'Visits', data: []}]
    };

    const chart = new ApexCharts(document.querySelector('#chart'), options);
    chart.render();

    function updateChart (deptId = null, period = 'daily'){
        currentperiod = period;
        let url = deptId ? `/api/visits/${deptId}?period=${period}` : '/api/visits/0';
        fetch(url)
        .then(res => res.json())
        .then(data => {
            chart.updateSeries([{ data}]);
            const now = new Date();
            let min, max;

            if(data.length > 0) {
                if (period === 'yearly'){
                    const starts = new Date(now.getFullYear() - 2, 0, 1);
                    const end = new Date(now.getFullYear() + 1, 0, 1);
                    min = starts.getTime();
                    max = end.getTime();  
                    ticks = 5;
                }else if(period === 'monthly'){
                    const starts = new Date(now.getFullYear(), 0, 1);
                    const end = new Date(now.getFullYear(), 11, 31);
                    min = starts.getTime();
                    max = end.getTime();
                    ticks = 12;
                }else {
                    const starts = new Date(now.getFullYear(), now.getMonth(), 1);
                    const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                    min = starts.getTime();
                    max = end.getTime();
                    ticks = 10;
                }
                chart.zoomX(min, max);
                chart.updateOptions({
                    xaxis: {
                        tickAmount: ticks,
                    }
                });
            }
        });
    }

    getIdd = $('#deptChange').val();
    updateChart(getIdd, 'daily');
    
    document.getElementById('dailyVisit').addEventListener('click', function() {
        updateChart(getIdd, 'daily');
    });

    document.getElementById('monthlyVisit').addEventListener('click', function() {
        updateChart(getIdd, 'monthly');
    });
    document.getElementById('yearlyVisit').addEventListener('click', function() {
        updateChart(getIdd, 'yearly');
        
    });

    $(function () {
    $('[data-bs-toggle="tooltips"]').tooltip();
    
    $('[data-toggle="tooltips"]').tooltip();
});

</script>


</html>