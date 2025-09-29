@php
$currentdate = now();
$currentSort = request('sort') === 'asc' ? 'desc' : 'asc';
$requestBy = request('by');

$currentYear = now()->format('Y');
$currentmaxYear = $currentYear + 25;
$authId = auth()->user()->dept_id;

$getOptionDID = $_COOKIE['getDID'] ?? null;
$toggleOptionDID = 0;


if($authId != 0 && $getOptionDID != $authId){
  $getOptionDID = 0;
}


if($getOptionDID == 0){
  $toggleOptionDID = $authId;
}



@endphp

<!DOCTYPE html>
<html {{ request()->cookie('theme', 'light') }} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Visitors</title>
        <link rel="icon" type="image/x-icon" href="{{asset('storage/images/imus_logo.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.css">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <!-- Styles -->
        
        <link rel="stylesheet" href="{{ asset('/css/css.css') }}"/>
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css /html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5},:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        */
          .table td{
            height: 67px;
          }
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
        <div class="container bg-white rounded mt-3 p-4 pt-2" style="height: fit-content; width: 90%;">
            <div class="d-flex flex-grow justify-content-between p-2">
            <h2 class="mt-2">Visitors</h2>
            <div class="d-flex gap-2" style="height:37.5px">
              <button type="button" class="btn btn-primary addButton" data-bs-target=".modalviewaddvisitor" data-bs-toggle="modal" href="#" id="addvisitorBtn" data-toggle="tooltips" data-bs-placement="right" title="Add a visitor"><i class="fa-solid fa-plus"></i></button>
              @if($authId != 0)
              <button type="button" onclick="setOptionVisitorDept({{$toggleOptionDID}})" class="btn btn-muted" data-bs-toggle="tooltips" title="Toggle to show all visitors or department only visitors (has log records)">
                  @if($getOptionDID == $authId)
                  Department Only
                  @else
                  All Visitors
                  @endif
              </button>
              @else
              <div class="input-group" style="height: 37.5px">
              <label for="departmentSelect" id="departmentSelectLabel" class="input-group-text bg-muted p-2 fw-bold" style="height:37.5px"><i class="fa-solid fa-building-user"></i>&nbsp; Department</label>
              <select class="form-select formselectDept" onchange="setOptionVisitorDept(this.value)">
                  <option value="0"
                  @if($getOptionDID == null || $getOptionDID == 0)
                    selected
                  @endif
                  >All</option>
                @foreach ($departments as $department)
                  <option value="{{$department->id}}" 
                    @if ($getOptionDID == $department->id)
                      selected
                    @endif>{{$department->dept_name}}</option>
                @endforeach
              </select>
              </div>
              @endif
            </div>
            </div>
            <div>
                <form method="GET" class="form-inline d-flex" action="{{ route('search.filter')}}" class="d-flex">
                    <div class="input-group">
                    <input class="form-control mr-sm-2 rounded-end-0" type="search" name="search" placeholder="Search" aria-label="Search">
                      @if(url()->current() !== route('view.visitors'))
                        <a href="{{route('view.visitors')}}" type="button" class="close btn bg-transparent" style="margin-left: -40px; z-index: 1;">
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
                    <form class="px-4 py-3" action="{{ route('search.spfilter')}}" method="GET">
                      <div class="form-group">
                        <label for="firstNameSearch">First Name</label>
                        <input type="text" class="form-control" id="firstNameSearch" name="firstNameSearch" placeholder="First Name">
                      </div>
                      <div class="form-group">
                        <label for="lastNameSearch">Last Name</label>
                        <input type="text" class="form-control" id="lastNameSearch" name="lastNameSearch" placeholder="Last Name">
                      </div>
                      <div class="form-group">
                        <label for="emailSearch">Email</label>
                        <input type="text" class="form-control" id="emailSearch" name="emailSearch" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="contactSearch">Contact</label>
                        <input type="number" class="form-control" id="contactSearch" name="contactSearch" placeholder="Phone/Contact">
                      </div>
                      <div class="form-group">
                        <label for="idSearch">ID</label>
                        <input type="number" class="form-control" id="idSearch" name="idSearch" placeholder="Visitor ID Number">
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label mb-0">Added Date</label>
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

            </div>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                <th>
                  <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'id', 'sort' => $currentSort]) }}">
                    ID
                    <i @if($requestBy !== 'id')
                    hidden
                    @endif
                  class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'id' ? 'up' : 'down'}}"></i></a>
                </th>
                <th>Profile</th>
                <th>
                  <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'last_name', 'sort' => $currentSort]) }}">
                    Visitor Name 
                    <i @if($requestBy !== 'last_name')
                              hidden
                              @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'last_name' ? 'up' : 'down'}}"></i></a>
                </th>
                <th>
                  <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'email', 'sort' => $currentSort]) }}">
                    Email
                    <i @if($requestBy !== 'email')
                              hidden
                              @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'email' ? 'up' : 'down'}}"></i></a>
                </th>
                <th>
                  <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'affiliation', 'sort' => $currentSort]) }}">
                    Affiliation
                    <i @if($requestBy !== 'affiliation')
                              hidden
                              @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'affiliation' ? 'up' : 'down'}}"></i></a>
                </th>
                <th>
                  <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'updated_at', 'sort' => $currentSort]) }}" data-bs-toggle="tooltips" data-bs-placement="right" title="Click to order by update">
                    Actions

                    <i @if($requestBy !== 'updated_at')
                              hidden
                              @endif
                            class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'updated_at' ? 'up' : 'down'}}"></i></a>
                </th>
                
                </tr>
                </thead>
                @if($visitors->isEmpty())
                  <tr>
                    <td colspan="6" class="text-center">No visitors found.</td>
                </tr>
                @else
                
                @foreach ($visitors as $visitor)
                    <tr 
                    @if($visitor->user && $visitor->user->id == auth()->user()->id)
                    class="trCreatedBy"
                    @endif
                    >
                        <td>{{$visitor->id}}</td>
                        <td>@if ($visitor->profile_image)
                        
                        <img src="{{asset('storage/' . $visitor->profile_image)}}" alt="N/A" height="50px" width="50px">
                        @else
                        <i class="fa-solid fa-ban p-3"></i>
                        @endif</td>
                        <td>{{$visitor->last_name}}, {{$visitor->first_name}}</td>
                        <td>{{$visitor->email}}</td>
                        <td>{{$visitor->affiliation ? $visitor->affiliation : "N/A"}}</td>
                        <td class="align-middle">
                          <div class="cbtn-group gap-1" role="group">
                            <button type="button" id="btn-click" class="btn btn-primary" data-bs-target=".modalviewvisitor" data-bs-toggle="modal" href="#"
                            data-first-name="{{$visitor->first_name}}"                   
                            data-last-name="{{$visitor->last_name}}"
                            data-affiliation="{{$visitor->affiliation ? $visitor->affiliation : "N/A"}}"
                            data-email="{{$visitor->email}}"
                            data-contact="{{$visitor->contact ? $visitor->contact : "N/A"}}"
                            data-address="{{$visitor->address}}"
                            data-id="{{$visitor->id}}"
                            data-created_at="{{$visitor->created_at}}"
                            data-updated_at="{{$visitor->updated_at}}"
                            data-logs="{{ json_encode($visitor->logs)}}"
                            data-addedby="{{$visitor->user ? $visitor->user->name : "N/A"}}"
                            data-image-profile="{{$visitor->profile_image ? asset('storage/'. $visitor->profile_image) : ""}}"
                            >
                            <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <button type="button" class="btn btn-muted edit-btn-onload" data-bs-toggle="modal" data-bs-target=".modalviewvisitor" data-bs-toggle="modal" href="#" id="checkin-btn"                            data-first-name="{{$visitor->first_name}}"                   
                            data-last-name="{{$visitor->last_name}}"
                            data-affiliation="{{$visitor->affiliation ? $visitor->affiliation : "N/A"}}"
                            data-email="{{$visitor->email}}"
                            data-contact="{{$visitor->contact ? $visitor->contact : "N/A"}}"
                            data-address="{{$visitor->address}}"
                            data-id="{{$visitor->id}}"
                            data-created_at="{{$visitor->created_at}}"
                            data-created_at="{{$visitor->updated_at}}"

                            data-logs="{{ json_encode($visitor->logs)}}"
                            data-addedby="{{$visitor->user ? $visitor->user->name : "N/A"}}"
                            data-image-profile="{{$visitor->profile_image ? asset('storage/'. $visitor->profile_image) : ""}}"
                            ><i class="fa-solid fa-user-check"></i> Check-In</button>
                          </div>
                        </td>
                    </tr>
                @endforeach
                @endif
            
            </table>
            </div>

            {{$visitors->links('vendor.pagination.bootstrap-5')}}

        </div>
    </div>
    </section>

    <div class="modal fade bd-modal-lg modalviewvisitor" id="modalviewvisitor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg d-flex">
          <div class="modal-content p-1">
            <div class="modal-divider d-flex flex-column-reverse flex-lg-row justify-content-between">
                <div class="justify-content-between">
            <div class="modal-header" style="border-bottom:0;">
                <h5 class="modal-title">Visitor Info</h5>
                </div>
                <div class="top-part d-flex">
                <div class="p-1" style="padding-left: 5% !important">
                    <img id="get-image" src="" style="max-width: 150px; max-height: auto;" alt="Profile Image">
                    <!--No image icon-->
                    <i id="icon-on-image-view" class="fa-solid fa-circle-user" style="font-size:100px;" aria-hidden="true"></i>
                </div>
                <div class="p-3 d-flex">
                    <div class="nameTop">
                    <p class="mb-0 pb-0">Name</p>
                <p class="fw-bold fs-5" id="name"></p>
                    </div>
                <p></p>
                </div>
                </div>
            <div class="mid-part pt-2" style="padding-left: 5% !important">
                Email
                <p class="text-primary" id="email"></p>
                Contact
                <p class="text-primary" id="contact"></p>
                Address
                <p class="text-primary" id="address"></p>
                Affiliation
                <p class="text-primary" id="affiliation"></p>
                Added By
                <p class="text-primary" id="addedBy"></p>
            </div>
            <button id="edit-vbtn" class="btn-primary btn ms-2"  data-bs-toggle="modal" data-bs-target=".modalviewaddvisitor">Edit</button>
            <button class="btn-secondary btn" data-bs-dismiss="modal">Cancel</button>
            <div class="footer pt-2 ps-3 fs-tiny d-flex text-secondary d-flex" style="gap: 5px">
                <p id="created"></p>
                <p id="updated"></p>
            </div>
                </div>

            <div id="modalLogsRight" class="modal-logs rounded">
                <div class="d-flex pt-2">
                    <ul class="nav nav-tabs p-2 w-100 pb-0" role="tablist">  
                        <li class="nav-item">
                        <button class="nav-link active p-2 pb-0" type="button" role="presentation" data-bs-toggle="tab" data-bs-target="#logTable" id="logTab">Visitor Log</button>
                        </li>
                        <li class="nav-item">
                        <button class="nav-link p-2 pb-0" type="button" role="presentation" data-bs-toggle="tab" data-bs-target="#checkinTab" id="checkTab">Check-In</button>
                        </li>
                    </ul>
                <button type="button" class="close text-end position-absolute end-0 top-0" data-bs-dismiss="modal" aria-label="Close" style="font-size: 25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                  
                </div>  
                <div class="tab-content">              
                <div class="tab-pane fade" role="tabpanel" id="checkinTab">
                <form method="POST" class="m-3" action="{{route('add.log')}}">
                    @csrf
                    <label for="dept_id">Department</label>
                    <select class="form-control mt-2" name="dept_id"
                    @if (auth()->user()->dept_id != 0)
                        disabled
                    @endif>
                        @foreach ($departments as $department)
                            <option @if (auth()->user()->dept_id == $department->id)
                                selected
                                    @endif
                            value="{{$department->id}}">{{$department->dept_name}}</option>
                        @endforeach
                    </select>
                    <label for="purpose">Purpose</label>
                    <input type="text" class="form-control mt-2" name="purpose" required>
                    <label for="visited_at">Visited At</label>
                    <input id="getDate" type="datetime-local" class="form-control mt-2" name="visited_at">
                    <input type="hidden" id="idAddLog" name="visitor_id">
                    <button type="submit" class="btn-primary btn mt-2">Add</button>
                </form>
                </div>                
                <div class="tab-pane fade show active" role="tabpanel" id="logTable" style="height: 70vh;
                overflow: overlay;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="">Date</th>
                        <th class="">Purpose</th>
                        @if($authId == 0)
                        <th class="">Department</th>
                        @endif
                        <th class="">Added By</th>
                    </tr>
                    </thead>
                    <tbody id="log-list">
                        <tr>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            @if($authId == 0)
                            <td class="border-0"></td>
                            @endif
                            <td class="border-0"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                </div>
            </div>
            <!-- Modal Divider-->
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade bd-modal-lg modalviewaddvisitor" id="modalviewaddvisitor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg d-flex">
          <div class="modal-content">
            
            <form id="formaddvisitor" enctype="multipart/form-data" method="POST" action="{{route('create.visitor')}}">
              
              <input type="hidden" id="eId" name="id">
            <div class="modal-header d-flex justify-content-between" style="border-bottom:0;">
                @csrf
                <h5 class="modal-title" id="formaddvisitortitle">Add a Visitor</h5>
                <button type="button" class="close text-end" data-bs-dismiss="modal" aria-label="Close" style="font-size: large;">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="top-part d-flex">
                <div class="p-1" style="padding-left: 5% !important">
                  <div>
                    <img id="previewImage" src="" style="max-width: 150px; max-height: auto;">
                    <i id="icon" class="fa-solid fa-circle-user text-secondary" style="font-size:150px;" aria-hidden="true"></i>
                  </div>
                <input type="file" name="image" class="text-center form-control-file" id="fileform" style="display:none" onchange="handleFileChange(event)">
                <div class="justify-content-center d-flex">
                <button id="upload-btn" class="btn btn-primary mt-2" onclick="triggerFileInput(event)">Upload Profile</button>
                </div>
                </div>
                <div class="p-4 d-flex">
                    <div class="d-flex nowrap" style="gap: 10px">
                <div>
                <label for="firstname">First Name</label>
                <input type="text" id="vfName" class="form-control" name="first_name" placeholder="First Name">
                </div>
                <div>
                <label for="lastname">Last Name</label>
                <input type="text" id="vlName" name="last_name" class="form-control" placeholder="Last Name">
                </div>
                    </div>
                <p></p>
                </div>
                </div>
            <div class="mid-part pt-2" style="padding-left: 5% !important; padding-right: 30%;">
                Email
                <input type="text" id="vEmail" name="email" class="form-control" placeholder="Email" required>
                Contact
                <input type="text" name="contact" id="vContact" class="form-control" placeholder="Contact Number" required>
                
                  <label for="address">Address</label>
                  <input type="text" id="vAddress" name="address" class="form-control" placeholder="Address" required>
                    <label for="affiliation">Affiliation</label>
                    <input type="text" class="form-control" name="affiliation">

            </div>
            <div class="content-end justify-content-between d-flex">
            <div class="footer pt-4 fs-tiny d-flex" style="padding-left: 4% !important; color:gray; gap: 5px;">
                <p id="editCreateDate"></p>
                <p id="editUpdateDate"></p>
                <p id="editDefaultDate">Added Date: {{date('d-m-Y',strtotime($currentdate))}}</p>
            </div>
            <div class="d-flex nowrap justify-content-end p-4" style="gap:10px;">
            <button type="submit" id="submit" class="btn-primary btn" id="save-btn">Save</button>
            <button type="button" id="back-btn" class="btn-secondary btn" data-bs-toggle="modal" data-bs-target="#modalviewvisitor">Back</button>
            <button type="button" class="btn-secondary btn" data-bs-dismiss="modal">Cancel</button>
            </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      @else

      @include('partials.invalid-perms')

      @endauth
      @endif

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
  
  
  $('#weekSearch').hide();
  $('#monthSearch').hide();
  $('#yearSearch').hide();

  
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

function toLocalISOString(date) {
    const localDate = new Date(date - date.getTimezoneOffset() * 60000);
    
    localDate.setSeconds(null);
    localDate.setMilliseconds(null);
      return localDate.toISOString().slice(0, -1);
  }

  window.addEventListener("load", () => {
    document.getElementById("getDate").value = toLocalISOString(new Date());
  });

  var checkTab = document.getElementById("checkTab");
  var logTab = document.getElementById("logTab");
  
  var logTableCont = document.getElementById('logTable');
  var checkinTabCont = document.getElementById('checkinTab');

  function triggerFileInput(event) {
    event.preventDefault();
    document.getElementById('fileform').click();
    }

  function handleFileChange(event) {
    const file = event.target.files[0];
    if (file) {
        //console.log("File selected:", file.name);
    }
  }

  var addForm = document.getElementById('formaddvisitor');

  function addPutMethod(){
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = '_method';
    input.value = 'PUT';

    addForm.appendChild(input);
  }

  function addHiddenId(){
    var idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.id = 'eId';

    addForm.appendChild(idInput);
  }

  function removeHiddenId(){
    var idInInput = addForm.querySelector('input[name="id"]');
    if(idInInput){
      addForm.removeChild(idInInput);
    }
  }

  function remPutMethod(){
    var methodInput = addForm.querySelector('input[name="_method"]');
    if (methodInput){
      addForm.removeChild(methodInput);
    }
  }

  $(document).on('click', '#addvisitorBtn', function(e){
    remPutMethod();
    removeHiddenId();

    $('#icon').show();
    $('#editCreateDate').hide();
    $('#editUpdateDate').hide();
    $('#editDefaultDate').show();
    
    $('#back-btn').hide();
    $('#formaddvisitortitle').text('Add a Visitor');

    $('#previewImage').attr('src', '');
    $('#fileform').val('');
    $('#vfName').val('');
    $('#vlName').val('');
    $('#vEmail').val('');
    $('#vContact').val('');
    $('#vAddress').val('');
    $('#vAffiliation').val('');

  });

  function truncate(str, maxLength){
    
    if (!str) return "";
    return str.length > maxLength ? str.slice(0, maxLength) + "..." : str;
  }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      document.getElementById("getDate").value = toLocalISOString(new Date());
    });
  $(document).on('click', '#btn-click, #checkin-btn', function(e){
    
    document.getElementById("getDate").value = toLocalISOString(new Date());
    remPutMethod();

    var checkIdInput = addForm.querySelector('input[name="id"]');

    if(!checkIdInput){
      addHiddenId();
    }
    $('#back-btn').hide();

    let imageprof = $(this).data('image-profile');
    let first_name = $(this).data('first-name');
    let last_name = $(this).data('last-name');
    let email = $(this).data('email');
    let contact = $(this).data('contact') || "N/A";
    let address = $(this).data('address') || "N/A";
    let created_at = $(this).data('created_at');
    let affiliation = $(this).data('affiliation') || "N/A";
    let affiOnSelect = $(this).data('affiliation') || "";
    let updated_at = $(this).data('updated_at') || "N/A";
    let getId = $(this).data('id');
    let addedBy = $(this).data('addedby');

    const logs = JSON.parse(this.getAttribute('data-logs'));

    const logTb = document.getElementById('log-list');
    logTb.innerHTML = '';

    $('#name').text(last_name + ", " + first_name);
    $('#email').text(email);
    $('#contact').text(contact);
    $('#created').text("Added Date: " + created_at);
    $('#updated').text("Edit Date: " + updated_at);
    $('#address').text(address);
    $('#affiliation').text(affiliation);
    $('#idAddLog').val(getId);
    $('#addedBy').text(addedBy);

    $('#eId').val(getId);
    $('#previewImage').attr('src', imageprof);
    $('#vfName').val(first_name);
    $('#vlName').val(last_name);
    $('#vEmail').val(email);
    $('#vContact').val(contact);
    $('#vAddress').val(address);

    $('#editUpdateDate').text('Updated: ' + updated_at);
    $('#editCreateDate').text('Created: ' + created_at);

    $('#vAffiliation').val(affiOnSelect);
    $('#editGetId').val(getId); 
    
    if(imageprof && imageprof.trim() !== ""){
        $('#get-image').attr('src', imageprof).show();
        $('#icon-on-image-view').hide();
        $('#icon').hide();
    }else{
      $('#get-image').hide();
      $('#icon-on-image-view').show();
      $('#icon').show();
    }
    
    let authId = @json($authId);

    if (logs.length === 0) {
      const emptyRow = document.createElement('tr');
      const emptyCell = document.createElement('td');
        if(authId == 0){
          emptyCell.colSpan = 4
        }
        else{
          emptyCell.colSpan = 3;
        }
      emptyCell.textContent = "No logs available.";
      emptyRow.appendChild(emptyCell);
      logTb.appendChild(emptyRow);
    } else {
    logs.forEach(log => {
      
      const logRow = document.createElement('tr');
      const dateCell = document.createElement('td');
      dateCell.textContent = log.visited_at;
      logRow.appendChild(dateCell);
      const purpCell = document.createElement('td');
      purpCell.textContent = log.purpose;
      logRow.appendChild(purpCell);
        if(authId == 0){
        const deptCell = document.createElement('td');
        deptCell.textContent = log.department.dept_name;
        logRow.appendChild(deptCell);
        }
      const byCell = document.createElement('td');
      byCell.textContent = log.user ? truncate(log.user.name, 10) + " - " +log.user.id : "N/A";
      logRow.appendChild(byCell);
      logTb.appendChild(logRow);
      
    });
    }

    logTab.classList.add("active", "show");
    checkTab.classList.remove("active", "show");
    checkinTabCont.classList.remove("active", "show");
    logTableCont.classList.add("active", "show");
  });


  $(document).on('click', '#checkin-btn', function(e){
    document.getElementById("getDate").value = toLocalISOString(new Date());
    checkTab.classList.add("active", "show");
    logTab.classList.remove("active", "show");
    checkinTabCont.classList.add("active", "show");
    logTableCont.classList.remove("active","show");
  });

  function setOptionVisitorDept(getDeptID){
          let currentURL = new URL(window.location.href);
          currentURL.searchParams.set('getDID', getDeptID);

          document.cookie = `getDID=${getDeptID}; path=/; max-age=31536000`;
          window.location.href = currentURL.toString();
    }
  
  $(document).on('click', '#edit-vbtn', function(e){
    
    $('#editCreateDate').show();
    $('#editUpdateDate').show();
    $('#editDefaultDate').hide();

    $('#back-btn').show();
    
    //console.log( "Form add is: "+$('#formaddvisitor').css('display'));
    //console.log("View Form is: "+$('#modalviewvisitor').css('display'));
    $('#formaddvisitortitle').text('Edit Visitor');
    $('#formaddvisitor').attr('action', '/visitors/edit');
    addPutMethod();
  });

  //upload
  $(document).ready(function(){
    $('#fileform').change(function (event) {
      let file = event.target.files[0];
      
      //console.log('event happened' + file);
      if (file){
        let reader = new FileReader();
        reader.onload = function (e) {
          //console.log(e.target.result);
          $('#previewImage').attr('src', e.target.result).show();
          $('#icon').hide();
          $('#upload-btn').text('Change Profile');
        };
        reader.readAsDataURL(file);
      } else {
        $('#previewImage').hide();
        $('#icon').show();
      }

      //console.log('Icon visibility: ', $('#icon').css('display'));

    });
  });

  const editBtns = document.querySelectorAll('.edit-btn-onload');
  let modalLogsview = document.getElementById('modalLogsRight');
  let departmentSelectLabel = document.getElementById('departmentSelectLabel');

  function minWidthEditBtn(){
            if (window.innerWidth <= 1092){
              editBtns.forEach(editBtn => {
                editBtn.innerHTML = '<i class="fa-solid fa-user-check"></i>';
              });
            }else{
              editBtns.forEach(editBtn => {
                editBtn.innerHTML = '<i class="fa-solid fa-user-check"></i> Check-In';
              });
            }
        }

        window.onload = minWidthEditBtn(), borderRemove(), DepartmentSelectorSize();

        window.addEventListener('resize', function() { 
                        minWidthEditBtn();
                        borderRemove();
                        DepartmentSelectorSize();
        });

  function borderRemove(){
    if (window.innerWidth <= 991.20){
      modalLogsview.classList.add('border-0');
      $('#logTable').css('height', '38.8vh');
    }else{
      modalLogsview.classList.remove('border-0');
      $('#logTable').css('height', '70vh');
    }
  }



  function DepartmentSelectorSize(){
    if(departmentSelectLabel != null){
      if (window.innerWidth <= 420) {
        departmentSelectLabel.innerHTML = '<i class="fa-solid fa-building-user"></i>';
      }else{
        departmentSelectLabel.innerHTML = '<i class="fa-solid fa-building-user"></i>&nbsp; Department';
      }
    }
  }


  $(function () {
    $('[data-bs-toggle="tooltips"]').tooltip();
    
    $('[data-toggle="tooltips"]').tooltip();
});


</script> 
