@php

$segmentUrl = request()->segment(3);
$segmentUrlSec = request()->segment(2);

$currentSort = request('sort') === 'asc' ? 'desc' : 'asc';
$requestBy = request('by');
$currentYear = now()->format('Y');
$currentmaxYear = $currentYear + 20;
$id = request()->route('id');
$userId = auth()->user()->dept_id;
@endphp

<!DOCTYPE html>
<html {{ cookie('theme', 'light') }} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Visitor Logs</title>
        <link rel="icon" type="image/x-icon" href="{{asset('storage/images/imus_logo.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Fonts -->

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.css">
        <!-- Styles -->
        
        <link rel="stylesheet" href="{{ asset('/css/css.css') }}"/>
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css /html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5},:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        */

        </style>
    </head>
<body>

    
  @if(is_null(auth()->user()->dept_id))
      @include('partials.firstlogin')
    @else

    @auth
          
    <section>
        <div class="d-flex " style="height: 100vh">
        @include('partials.sidebar')
        </div>

        @include('partials.alertmsg')

        <div class="w-100">
            <div class="container bg-white rounded mt-3 p-4 pt-4" style="height: fit-content; width: 90%;">
                <div class="d-flex justify-content-between">
                <h3>
                  @foreach ($departments as $department)
                      @if($department->id == auth()->user()->dept_id)
                          {{$department->dept_name}} |
                      @endif
                  @endforeach
                  Logs</h3>
                <div class="d-flex" style="gap:5px">
                <button type="button" class="btn btn-primary addButton" data-bs-target=".modalviewaddlog" data-bs-toggle="modal" href="#"  data-toggle="tooltips" data-bs-placement="right" title="Add a log"><i class="fa-solid fa-plus"></i></button>
                <form method="POST" action="{{route('download.log', ['id' => auth()->user()->dept_id, 'getDeptAdmin' => request()->route('id')])}}">
                  @csrf
                <button type="submit" class="btn btn-muted" data-bs-toggle="tooltips" data-bs-placement="right" title="Download Excel file"><i class="fa-solid fa-download" aria-hidden="true"></i></button>
                </form>
                
                @if(auth()->user()->dept_id == 0)
                  <div class="input-group" style="height:37.5px">
                    <label for="departmentSelect" id="departmentSelectLabel" class="input-group-text p-2 fw-bold" style="height:37.5px"><i class="fa-solid fa-building-user"></i>&nbsp; Department</label>
                    <select id="deptChange" class="form-select">
                      <div class="overflow-auto">
                          <option value="0">All</option>
                          @foreach ($departments as $department)
                              <option value="{{$department->id}}" 
                                  @if ($segmentUrl == $department->id || $segmentUrlSec == $department->id)
                                      selected
                                  @endif>{{$department->dept_name}}</option>
                          @endforeach
                      </div>
                    </select>
                  </div>
                @endif
                </div>
                </div>

                <div>
                    <form method="GET" class="mt-2 form-inline d-flex" id="searchFilterLogs" action="{{ route('search.filterlogs')}}" class="d-flex">
                        <div class="input-group">
                        <input class="form-control mr-sm-2 rounded-end-0" type="search" name="search" placeholder="Search" aria-label="Search">
                        @if(url()->current() !== route('view.logs'))
                        <a href="{{route('view.logs')}}" type="button" class="close btn bg-transparent" style="margin-left: -40px; z-index: 1;">
                          <span aria-hidden="true" style=" font-size: larger;">&times;</span>
                        </a>
                      @endif
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-lg  rounded-start-0" type="submit">
                            Search
                        </button>
                        <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                    </form>
    
                    <div class="dropdown-menu">
                        <form class="px-4 py-3" action="{{ request()->route('id') == null ? route('search.spfilterlogs') : route('search.spfilterlogsadmin', ['id' => request()->route('id')])}}" method="GET" id="searchFilterLogsSp">
                          <div class="form-group">
                            <label for="firstNameSearch">First Name</label>
                            <input type="text" class="form-control" id="firstNameSearch" name="firstNameSearch" placeholder="First Name">
                          </div>
                          <div class="form-group">
                            <label for="lastNameSearch">Last Name</label>
                            <input type="text" class="form-control" id="lastNameSearch" name="lastNameSearch" placeholder="Last Name">
                          </div>
                          <div class="form-group">
                            <label for="idSearch">ID</label>
                            <input type="number" class="form-control" id="idSearch" name="idSearch" placeholder="Log ID">
                          </div>
                          <div class="form-group">
                            <label for="emailSearch">Email</label>
                            <input type="text" class="form-control" id="emailSearch" name="emailSearch" placeholder="Visitor Email">
                          </div>
                          <div class="form-group">
                            <label for="contactSearch">Contact</label>
                            <input type="number" class="form-control" id="contactSearch" name="contactSearch" placeholder="Visitor's Contact Number" title="Only numbers allowed" pattern="^[0-9]+$"                            >
                          </div>
                            <div class="form-group mb-3">
                              <label class="form-label mb-0">Visit Date</label>
                              <div class="d-flex align-items-center">
                            
                                <div class="btn-group btn-group-sm me-2" role="group" data-bs-auto-close="outside">
                                  <input type="radio" class="btn-check" name="dateMode" id="modeDay"  value="day"  autocomplete="off" checked>
                                  <label class="btn btn-outline-primary" for="modeDay" onclick="changeDateSearch('day'); event.stopPropagation();">Day</label>
                            
                                  <input type="radio" class="btn-check" name="dateMode" id="modeWeek" value="week" autocomplete="off">
                                  <label class="btn btn-outline-primary" for="modeWeek" onclick="changeDateSearch('week'); event.stopPropagation();">Week</label>
                            
                                  <input type="radio" class="btn-check" name="dateMode" id="modeMonth" value="month" autocomplete="off">
                                  <label class="btn btn-outline-primary" for="modeMonth" onclick="changeDateSearch('month'); event.stopPropagation();">Month</label>
                            
                                  <input type="radio" class="btn-check" name="dateMode" id="modeYear" value="year" autocomplete="off">
                                  <label class="btn btn-outline-primary" for="modeYear" onclick="changeDateSearch('year'); event.stopPropagation();">Year</label>
                                </div>

                                <input
                                  type="date"
                                  class="form-control form-control-sm"
                                  id="DateSearch"
                                  name="DateSearch"
                                  onclick="event.stopPropagation()"
                                />

                                <input type="week" class="form-control form-control-sm" name="weekSearch" id="weekSearch">
                                <input type="month" class="form-control form-control-sm" name="monthSearch" id="monthSearch">
                                <input type="number" class="form-control form-control-sm" style="width: 137px" name="yearSearch" max="{{$currentmaxYear}}" step="1" value="{{$currentYear}}" id="yearSearch">

                              </div>
                          </div>
                            
                        <div class="dropdown-divider"></div>
                          <button type="submit" class="btn btn-primary ms-auto-right">Search</button>
                          
                        </form>
                      </div>
                    <!-- btn-group-->                  
                    </div>

                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th>
                          <a class="text-black text-decoration-none" href="{{ request()->fullUrlWithQuery(['by' => 'visitor_logs.id', 'sort' => $currentSort]) }}">
                            ID
                            <i @if($requestBy !== 'visitor_logs.id')
                              hidden
                              @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'visitor_logs.id' ? 'up' : 'down'}}"></i>
                          </a>
                        </th>
                        <th>
                          <a class="text-black text-decoration-none" href="{{ request()->fullUrlWithQuery(['by' => 'visited_at', 'sort' => $currentSort]) }}">
                            Check-in Time
                            <i @if($requestBy !== 'visited_at')
                              hidden
                              @endif 
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'visited_at' ? 'up' : 'down'}}"></i></a>
                        </th>
                        <th>                 
                          <a class="text-black text-decoration-none" href="{{ request()->fullUrlWithQuery(['by' => 'last_name', 'sort' => $currentSort]) }}">
                            Visitor Name 
                            <i @if($requestBy !== 'last_name') 
                            hidden 
                            @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'last_name' ? 'up' : 'down'}}"></i></a></th>
                        <th>Purpose</th>
                        <th 
                        @if(auth()->user()->dept_id !== 0)
                        hidden
                        @endif
                        >Department</th>
                        <th>                 
                          <a class="text-black text-decoration-none" href="{{ request()->fullUrlWithQuery(['by' => 'visitor_logs.updated_at', 'sort' => $currentSort]) }}" data-bs-placement="right" data-bs-toggle="tooltips" title="Click to order by updated">
                          Actions
                          <i @if($requestBy !== 'visitor_logs.updated_at')
                            hidden
                            @endif 
                          class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' ? 'up' : 'down'}}"></i></a></th>
                        
                        </tr>
                        </thead>
                        @if($logs->isEmpty())
                            <tr>
                              <td colspan="{{ auth()->user()->dept_id !== 0 ? 4 : 5 }}" class="text-center">No logs found.</td>
                          </tr>
                        @else

                        @foreach ($logs as $log)
                            <tr
                            @if($log->user && $log->user->id == auth()->user()->id)
                            class="trCreatedBy"
                            @endif
                            >
                                <td>{{$log->id}}</td>
                                <td>{{$log->visited_at}}</td>
                                <td>{{$log->visitor->last_name}}, {{$log->visitor->first_name}}</td>
                                <td>{{$log->purpose}}</td>
                                <td
                                @if(auth()->user()->dept_id !== 0)
                                hidden 
                                @endif
                                >{{$log->department->dept_name}}</td>
                                <td><div class="cbtn-group gap-1"><button type="button" id="btn-view-log" class="btn btn-primary" data-bs-target=".modalviewlog" data-bs-toggle="modal" href="#"
                                    data-first-name="{{$log->visitor->first_name}}"                   
                                    data-last-name="{{$log->visitor->last_name}}"
                                    data-lvaffiliation="{{$log->visitor->affiliation}}"
                                    data-email="{{$log->visitor->email}}"
                                    data-lvcontact="{{$log->visitor->contact}}"
                                    data-address="{{$log->visitor->address}}"
                                    data-id="{{$log->visitor_id}}"
                                    data-visited="{{$log->visited_at}}"
                                    data-l-id="{{$log->id}}"
                                    data-l-purpose="{{$log->purpose}}"
                                    data-dept="{{$log->department->dept_name}}"
                                    data-dept-id="{{$log->department->id}}"
                                    data-l-created="{{$log->created_at}}"
                                    data-l-updated="{{$log->updated_at}}"
                                    data-lv-created="{{$log->visitor->created_at}}"
                                    data-lv-updated="{{$log->visitor->updated_at}}"
                                    data-added-by="{{$log->user->name}}"
                                    data-image-profile="{{$log->visitor->profile_image ? asset('storage/' . $log->visitor->profile_image) : ""}}"
                                    >
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                    <button type="button" class="btn btn-muted" id="btn-edit" data-bs-target=".modalviewlog" data-bs-toggle="modal" href="#"
                                      data-first-name="{{$log->visitor->first_name}}"                   
                                      data-last-name="{{$log->visitor->last_name}}"
                                      data-lvaffiliation="{{$log->visitor->affiliation}}"
                                      data-email="{{$log->visitor->email}}"
                                      data-lvcontact="{{$log->visitor->contact}}"
                                      data-address="{{$log->visitor->address}}"
                                      data-id="{{$log->visitor_id}}"
                                      data-visited="{{$log->visited_at}}"
                                      data-l-id="{{$log->id}}"
                                      data-l-purpose="{{$log->purpose}}"
                                      data-dept="{{$log->department->dept_name}}"
                                      data-dept-id="{{$log->department->id}}"
                                      data-l-created="{{$log->created_at}}"
                                      data-l-updated="{{$log->updated_at}}"
                                      data-lv-created="{{$log->visitor->created_at}}"
                                      data-lv-updated="{{$log->visitor->updated_at}}"
                                      data-added-by="{{$log->user->name}}"
                                      data-image-profile="{{$log->visitor->profile_image ? asset('storage/' . $log->visitor->profile_image) : ""}}"
                                    ><i class="fa-solid fa-file-pen"></i> Edit</button>
                                </div></td>
                            </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
                    {{$logs->links('vendor.pagination.bootstrap-5')}}
            </div>
        </div>
    </section>

    <div class="modal fade bd-modal-lg modalviewaddlog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg d-flex">
          <div class="modal-content" id="modaltoview" style="min-width: 65vh;">
            <div class="modal-divider d-flex" style="justify-content:space-between">
                <div style="min-width:50%;">
            <div class="modal-header" style="border-bottom:0;">
                <h5 class="modal-title">Visitor Details</h5>
                </div>
                <div class="top-part d-flex">
                <div class="p-1" style="padding-left: 5% !important">
                <img id="get-image" src="" height="125px" width="auto">
                <i id="icon-on-image-view" class="fa-solid fa-circle-user text-secondary" style="font-size:100px;" aria-hidden="true"></i>
                </div>
                <div class="p-3">
                <div class="d-flex" style="height: fit-content; width: 100%;">
                </div>
                
                <h4 id="name" class="m-2">Visitor Name</h4>
                </div>
                </div>
            <div class="mid-part pt-2" style="padding-left: 5% !important">
                Email
                <p class="text-primary" id="email">example.com</p>
                Contact
                <p class="text-primary" id="contact">000000000</p>
                Address
                <p class="text-primary" id="address">N/A</p>
                Affiliation
                <p class="text-primary" id="affiliation">N/A</p>
                
                
            </div>
            <div class="footer pt-2 d-flex justify-content-between p-2" style="padding-left: 4% !important; color:gray;">
                <p id="created">Added Date: 00-00-0000</p>
            </div>
                </div>

            <div class="modal-logs rounded">
                <div class="justify-content-between d-flex pt-2">
                    <div class="p-2">
                        <h5>Visitor Log</h5>
                    </div>
                <button type="button" class="close text-end pb-3" data-bs-dismiss="modal" aria-label="Close" style="font-size: large;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                  <div class="table-responsive">
                  <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                      <thead>
                          <tr>
                              <td class="">Date</td>
                              <td class="">Activity</td>
                              <td
                              @if (auth()->user()->dept_id != 0)
                              hidden
                              @endif>Department</td>
                              <td class="justify-content-center d-flex">By</td>
                          </tr>
                      </thead>
                      <tbody id="log-list">
                      </tbody>
                  </table>
                  </div>
              </div>
              
            </div>
            <!-- Modal Divider-->
            </div>

            <div class="bottom-add-log p-4 border-top border-gray-700">
              
              <form method="POST" action="{{route('add.log')}}">
                @csrf

              <h5>Add a Log</h5>
                Visitor

              <select class="form-control js-choice" id="selectVisitor" data-live-search="true" name="visitor_id">
                  @foreach ($visitors as $visitor)
                      <option value="{{$visitor->id}}"
                        data-first-name="{{$visitor->first_name}}"
                        data-last-name="{{$visitor->last_name}}"
                        data-email="{{$visitor->email}}"
                        data-created-at="{{$visitor->created_at}}"
                        data-updated-at="{{$visitor->updated_at}}"
                        data-profile-image="{{$visitor->profile_image ? asset(path: 'storage/'. $visitor->profile_image) : ""}}"
                        data-affiliation="{{$visitor->affiliation}}"
                        data-contact="{{$visitor->contact}}"
                        data-address="{{$visitor->address}}"
                        data-logs="{{json_encode($visitor->logs)}}"
                        data-get-id="{{$visitor->id}}"
                        >{{$visitor->id}} | {{$visitor->last_name}} {{$visitor->first_name}}</option>
                  @endforeach
              </select>
              
                Select Time
                <input type="datetime-local" name="visited_at" class="form-control mb-3" id="getDate">
                Purpose
                <input type="text" name="purpose" class="form-control mb-3">
                Department
                <select name="dept_id" class="form-select mb-3"
                    @if(@auth()->user()->dept_id != 0)
                      disabled
                    @endif
                    >
                  @foreach ($departments as $department)
                    <option value="{{$department->id}}" 
                      @if (@auth()->user()->dept_id == $department->id)
                        selected
                      @endif
                      >{{$department->dept_name}}</option>
                  @endforeach
                </select>

                  <!-- Buttons-->
                  <div class="d-flex justify-content-end" style="gap:5px">
                    <button type="submit" class="btn btn-primary">Add Log</button>
                    <button type="button" class="btn-secondary btn" data-bs-dismiss="modal">Cancel</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade modaldeletepopup fit-content" id="modaldeletepopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg d-flex justify-content-center">
          <div class="modal-content" id="modaltopopup" style="max-width: 500px">
            <div class="">
              <form method="POST" action="{{route('delete.log')}}">
                @csrf
              <input type="hidden" name="id" id="inputValDelete">
              <div class="p-3 modal-header">
                <h5>Delete Warning</h5>
                
                <button type="button" class="close position-absolute end-0 top-0 fs-3" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

                <p class="p-3">Are you sure you want to delete this log?
                </p>
                <div class="p-2 modal-footer">
                <button type="submit"class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".modalviewlog">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade bd-modal-lg modalviewlog fit-content" id="modalviewlog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg d-flex">
          <div class="modal-content" id="modaltoview" style="min-width: auto">
            
            <button type="button" class="close text-end position-absolute end-0 fs-4" data-bs-dismiss="modal" aria-label="Close" style="font-size: large;">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-divider d-flex flex-column-reverse flex-lg-row justify-content-between" id="modaldivider">
            <div class="modal-header d-flex justify-content-between position-absolute top-0 start-0 border-bottom-0">
                <h5 class="modal-title">Visitor Log Details</h5>
                </div>
              <!-- Modal Divider-->
              
            <div class="modal-left-view p-4">
              <form method="POST" action="" id="editlogview">
                @csrf
                @method('PUT')
              <h1 class="m-1 p-2"></h1>
              
              <input type="text" hidden id="editlviewId" name="id" value="">
                <p class="mb-0">Purpose</p>
                <p class="text-primary" id="lviewPurpose">N/A</p>
                <input type="text" class="text-primary form-control mb-1" id="editlviewPurpose" name="purpose">
                <p class="mb-0">Visited At</p>
                <p class="text-primary" id="lviewVisited">N/A</p>
                <input type="datetime-local" class="text-primary form-control mb-1" id="editlviewVisited" name="visited_at">
                <p class="mb-0">Department</p>
                <p class="text-primary" id="lviewDept">N/A</p>
                <select name="dept_id" class="text-primary form-control mb-1" id="editlviewDept"
                  @if(auth()->user()->dept_id != 0)
                    disabled
                  @endif
                  >
                  @foreach ($departments as $department)
                    <option value="{{$department->id}}"
                      
                      @if($department->id == auth()->user()->dept_id)
                      selected
                      @endif

                      >{{$department->dept_name}}
                    </option>
                  @endforeach
                </select>
                <p class="mb-0">Added by</p>
                <p class="text-primary mb-5 pb-5" id="lviewAdded">N/A</p>
              
              <div class="align-items-end m-3 ms-4 mt-5 position-absolute bottom-0 start-0" style="gap:5px;">
              
                <div class="d-flex" style="gap: 5px">
                  <button type="button" class="btn btn-primary mb-3" style="width: 8vh;" id="edit-btn">Edit</button>
                  <button type="submit" class="btn btn-primary mb-3" style="width: 8vh;" id="save-btn">Save</button>
                  <button type="button" class="btn btn-secondary mb-3" id="back-btn">Back</button> 
                  <button type="button" class="btn btn-secondary mb-3" style="width: 9vh;" data-bs-dismiss="modal">Close</button>
                <button type="button" data-bs-toggle="modal" class="btn-danger btn mb-3" data-bs-target="#modaldeletepopup"><i class="fa-solid fa-trash-can"></i></button>
                  </div>
              <div class="d-flex" style="gap:5px">
              <p class="text-secondary mb-0 fs-tiny" id="lviewCreated">Added In: 0000-00-00</p>
              <p class="text-secondary mb-0 fs-tiny" id="lviewUpdated">Updated in: 0000-00-00</p>
              </div>
              </div>
              </form>
            </div>
              <div id="viewLogDetailsRight" class="viewaligntoCenter border border-top-0 border-bottom-0 border-end-0">
              
              
              <div class="justify-content-center align-items-center d-flex m-5 mt-3 mb-0" id="right-box" style="min-width: fit-content; flex-direction:column">
                <h5 class="pt-4">Logged Visitor</h5>
                <a href="" id="clickable-prof-lview">
                <img src="" id="image-profile-lview" height="auto" width="140px">
                </a>
                <i id="icon-on-image-lview" class="fa-solid fa-circle-user text-secondary" style="font-size:100px;" aria-hidden="true"></i>
                <h4 class="mt-1" id="showVisitorName">Visitor Name</h4>
              </div>
                
                <div class="justify-content-center">
                <div id="container" class="d-flex flex-wrap align-items-start" style="gap: 10px; flex-wrap: wrap !important; justify-content: flex-start; padding-left: 10%; padding-right: 10%;">
                  <div class="infoColumn">
                  <div class="item">Email
                    <p class="text-primary" id="lvemail">N/A</p>
                  </div>

                  <div class="item">Contact
                    <p class="text-primary" id="lvcontact">N/A</p>
                  </div>

                  </div>

                  <div class="infoColumn">
                  <div class="item">Address
                    <p class="text-primary" id="lvaddress">N/A</p>
                  </div>
                  <div class="item">Affiliation
                    <p class="text-primary" id="lvaffiliation">N/A</p>
                  </div>
                  </div>
                </div>    
                </div>
                
                <p class="text-secondary text-center fs-tiny mb-0" id="lvcreated">Added: 0000-00-00</p>   
                <p class="text-secondary text-center fs-tiny" id="lvupdated">Updated: 0000-00-00</p>   
              </div>
            </div>
          </div>
        </div>
      </div>
      @else

      @include('partials.invalid-perms');

      @endauth
      
      @endif
</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


<script>
  $(function(){
    $('#deptChange').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) {
            window.location = "/logs/" + url; // redirect
        }
        return false;
    });
  });
</script>

@php
$currentUrl = url()->current()
@endphp
@if($currentUrl !== route('view.logs'))
  @if(isset($getDeptId) && $currentUrl == route('view.logsadmin', ['id' => (int)$getDeptId]))
  <script>
    let searchFilterLogs = document.getElementById('searchFilterLogs');
    let searchFilterLogsSp = document.getElementById('searchFilterLogsSp');
    var getDeptId = {{$getDeptId}}
    
    searchFilterLogs.action = '/logs/filter/' + getDeptId;
    searchFilterLogsSp.action = '/logs/spfilter/' + getDeptId;

  </script>
  @endif
@endif

<script>
  let visitorLogView = document.getElementById('viewLogDetailsRight');
  let departmentSelectLabel = document.getElementById('departmentSelectLabel');


  function removeBorder(){
    if(window.innerWidth <= 991.20){
      visitorLogView.classList.add('border-0');
      visitorLogView.classList.remove('viewaligntoCenter');
    }else{
      visitorLogView.classList.remove('border-0');
      visitorLogView.classList.add('viewaligntoCenter');
    }
  }

  window.addEventListener('resize', function(){
    removeBorder();
    DepartmentSelectorSize();
  });  

  $('#weekSearch').hide();
  $('#monthSearch').hide();
  $('#yearSearch').hide();

  document.getElementById('yearSearch').addEventListener('input', function() {
    const min = parseInt(1);
    const max = parseInt(this.max);
    const value = parseInt(this.value);
    const alertsContainer = document.getElementById('alerts');

    if (value < min || value > max) {
        this.classList.add('is-invalid');
        if (value < min) {
            alertsContainer.insertAdjacentHTML('beforeend', `
                <div class="alert alert-warning alert-dismissible fade show">
                    Cannot go under the minimum value of ${min}!
                    <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `);
        } else if (value > max) {
            alertsContainer.insertAdjacentHTML('beforeend', `
                <div class="alert alert-warning alert-dismissible fade show">
                    Cannot go above the maximum value of ${max}!
                    <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `);
        }
    } else {
        this.classList.remove('is-invalid');
    }

    var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.classList.remove('show');
                alert.classList.add('fade');

                setTimeout(function(){
                    alert.remove();
                    
                }, 1000);
            }, 5000);
            
        });

  });

  function changeDateSearch(searchPicked){
    switch(true)
    {
      case searchPicked == "day":
        $('#weekSearch').hide();
        $('#monthSearch').hide();
        $('#yearSearch').hide();
        $('#DateSearch').show();
        break;
      case searchPicked == "week":
        $('#DateSearch').hide();
        $('#weekSearch').show();
        $('#monthSearch').hide();
        $('#yearSearch').hide();
        break;
      case searchPicked == "year":
        $('#DateSearch').hide();
        $('#weekSearch').hide();
        $('#monthSearch').hide();
        $('#yearSearch').show();
        break;
      case searchPicked == "month":
        $('#DateSearch').hide();
        $('#weekSearch').hide();
        $('#monthSearch').show();
        $('#yearSearch').hide();
        break;
      default:
        $('#weekSearch').hide();
        $('#monthSearch').hide();
        $('#yearSearch').hide();
        $('#DateSearch').show();
        break;
    }
  }

  $('#get-image').hide();

  $(document).on('change', '#selectVisitor', function(e){
    
    document.getElementById("getDate").value = toLocalISOString(new Date());
    let selectedOption = $(this).find('option:selected');

    let imageprof = selectedOption.data('profile-image');
    let firstName = selectedOption.data('first-name') || "Name";
    let lastName = selectedOption.data('last-name') || "Visitor";
    let email = selectedOption.data('email') || "N/A";
    let contact = selectedOption.data('contact') || "Not Set";
    let createdAt = selectedOption.data('created-at') || "0000-00-00";
    let address = selectedOption.data('address') || "Not Set";
    let updatedAt = selectedOption.data('updated-at') || "N/A";
    let affiliation = selectedOption.data('affiliation') || "N/A";

    const logs = selectedOption.data('logs');
    console.log(logs);

    const logTb = document.getElementById('log-list');
    
    logTb.innerHTML = '';

    $('#email').text(email);
    $('#name').text(lastName + ", " + firstName);
    $('#contact').text(contact);
    $('#created').text("Added in: "+ createdAt);
    $('#updated').text("Updated in: "+ updatedAt);
    $('#address').text(address);

    


    if(imageprof && imageprof.trim() !== ""){
    $('#get-image').attr('src', imageprof).show();
    $('#icon-on-image-view').hide();
    }else{
      $('#get-image').hide();
      $('#icon-on-image-view').show();
    }

    if(checkUserDeptId == 0){
      if(logs){
        //console.log('Ran deptId 0' + checkUserDeptId);
      logs.forEach(log => {
        
        const logRow = document.createElement('tr');

        const dateCell = document.createElement('td');
        dateCell.textContent = log.visited_at;
        logRow.appendChild(dateCell);
        const purpCell = document.createElement('td');
        purpCell.textContent = log.purpose;
        logRow.appendChild(purpCell);
        
        const deptCell = document.createElement('td');
        deptCell.textContent = log.department.dept_name;
        logRow.appendChild(deptCell);
        const byCell = document.createElement('td');
        byCell.textContent = log.user ? log.user.name + " | " +log.user.id : "N/A";
        logRow.appendChild(byCell);
        logTb.appendChild(logRow);
        
        });
      }
    }else{
    if(logs){
    logs.forEach(log => {
      
      const logRow = document.createElement('tr');

      const dateCell = document.createElement('td');
      dateCell.textContent = log.visited_at;
      logRow.appendChild(dateCell);
      const purpCell = document.createElement('td');
      purpCell.textContent = log.purpose;
      logRow.appendChild(purpCell);
      const byCell = document.createElement('td');
      byCell.textContent = log.user ? log.user.name + " | " +log.user.id : "N/A";
      logRow.appendChild(byCell);
      logTb.appendChild(logRow);
      
      });
      }
    }
    
  });

  function toLocalISOString(date) {
    const localDate = new Date(date - date.getTimezoneOffset() * 60000);
    
    localDate.setSeconds(null);
    localDate.setMilliseconds(null);
      return localDate.toISOString().slice(0, -1);
  }

  window.addEventListener("load", () => {
    document.getElementById("getDate").value = toLocalISOString(new Date());
  });

  let checkUserDeptId = @json($userId);

  $(document).on('click', '#btn-view-log, #btn-edit', function(e){

    $('#save-btn').hide();
        
      $('#editlviewPurpose').hide();
      $('#lviewPurpose').show();
      
      $('#editlviewDept').hide();
      $('#lviewDept').show();

      $('#editlviewVisited').hide();
      $('#lviewVisited').show();
      $('#back-btn').hide();

      $('#edit-btn').show();
    
    let lvImageProf = $(this).data('image-profile');
    let lFirstName = $(this).data('first-name');
    let lLastName = $(this).data('last-name');
    let lAffiliation = $(this).data('lvaffiliation') || "N/A";
    let lEmail = $(this).data('email');
    let lContact = $(this).data('lvcontact') || "Not Set";
    let lAddress = $(this).data('address') || "Not Set";
    let lVisId = $(this).data('id');
    let lVisited = $(this).data('visited');
    let lCreated = $(this).data('l-created');
    let lUpdated = $(this).data('l-updated') || "N/A";
    let lVCreated = $(this).data('lv-created');
    let lVUpdated = $(this).data('lv-updated') || "N/A";
    let lDept = $(this).data('dept');
    let lPurp = $(this).data('l-purpose');
    let lLogId = $(this).data('l-id');
    let addedBy = $(this).data('added-by');

    let lDeptId = $(this).data('dept-id');

    if(lvImageProf || lvImageProf !== ""){
      $('#image-profile-lview').attr('src', lvImageProf).show();
      $('#icon-on-image-lview').hide();
      $('#clickable-prof-lview').attr('href', lvImageProf);
      //console.log('Shown Image');
    }else{
      //console.log('Hide Image');
      $('#image-profile-lview').attr('src', "").hide();
      $('#icon-on-image-lview').show();
    }

    $('#showVisitorName').text(lLastName + ", " + lFirstName);
    $('#lvaffiliation').text(lAffiliation);
    $('#lvemail').text(lEmail);
    $('#lvcontact').text(lContact);
    $('#lvaddress').text(lAddress);
    $('#lvId').text(lVisId);
    $('#lvcreated').text("Added: "+lVCreated);
    $('#lvupdated').text("Edited: "+lVUpdated);

    $('#lviewCreated').text("Added: "+lCreated);
    $('#lviewUpdated').text("Edited: "+lUpdated);
    $('#lviewDept').text(lDept);
    $('#lviewPurpose').text(lPurp);
    $('#lviewLogId').text(lLogId);
    $('#lviewAdded').text(addedBy);
    $('#lviewVisited').text(lVisited);

    $('#editlviewId').val(lLogId);
    $('#inputValDelete').val(lLogId);

    let actionURL = '/logs/edit/';

    $('#editlogview').attr('action', actionURL);

    let fas = document.getElementById('editlogview');

    $('#editlviewDept').val(lDeptId);
    $('#editlviewPurpose').attr('value', lPurp);
    $('#editlviewVisited').attr('value', lVisited);
  });

  $(document).on('click', '#edit-btn, #btn-edit', function(e){

    $('#editlviewPurpose').show();
    $('#lviewPurpose').hide();
    $('#back-btn').show();
    
    $('#editlviewDept').show();
    $('#lviewDept').hide();

    $('#editlviewVisited').show();
    $('#lviewVisited').hide();

    $('#save-btn').show();
    $('#edit-btn').hide();
  });

  $(document).on('click', '#back-btn', function(e){
    $('#editlviewPurpose').hide();
    $('#lviewPurpose').show();
    $('#back-btn').hide();
    
    $('#editlviewDept').hide();
    $('#lviewDept').show();

    $('#editlviewVisited').hide();
    $('#lviewVisited').show();

    $('#save-btn').hide();
    $('#edit-btn').show();
  });

  </script>

  
<script>
  const choices = new Choices('.js-choice', {
      searchEnabled: true,
      removeItemButton: true,
      placeholder: true,
      placeholderValue: 'Select Visitor...',
      maxItemCount: 2,
      shouldSort: false,
      allowHTML: true,
  });

  const selectVisitor = document.getElementById("selectVisitor");

selectVisitor.addEventListener('change', function(e) {

  const selectedItem = e.target.value;
  const currentItem = choices.getValue(true);

  if (selectedItem !== currentItem[0]){
    choices.removeActiveItems();
    choices.setChoiceByValue(selectedItem);
  }

});

function DepartmentSelectorSize(){
    if (window.innerWidth <= 420) {
      departmentSelectLabel.innerHTML = '<i class="fa-solid fa-building-user"></i>';
    }else{
      departmentSelectLabel.innerHTML = '<i class="fa-solid fa-building-user"></i>&nbsp; Department';
    }
  }

  window.onload = removeBorder(), DepartmentSelectorSize();

$(function () {
    $('[data-bs-toggle="tooltips"]').tooltip();
    
    $('[data-toggle="tooltips"]').tooltip();
});



</script>