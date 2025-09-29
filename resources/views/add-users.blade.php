<?php
if(auth()->user()->dept_id == 0){
    $isAdmin = 1;
}else{
    $isAdmin = 0;
}

$currentSort = request('sort') === 'asc' ? 'desc' : 'asc';
$requestBy = request('by');

?>
<!DOCTYPE html>
<html {{ request()->cookie('theme', 'light') }} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Manage Users</title>
        <link rel="icon" type="image/x-icon" href="{{asset('storage/images/imus_logo.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Fonts -->

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('/css/css.css') }}"/>
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css /html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5},:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        */</style>

    </head>
    <body>
        @include('partials.alertmsg')

        @if(is_null(auth()->user()->dept_id))
            @include('partials.firstlogin')
        @else
      

        @auth
            @if (auth()->user()->role == 'admin')
            
        <section>
            <div class="d-flex " style="height: 100vh">
            @include('partials.sidebar')
            </div>

        <div class="w-100">

            <div class="container bg-white rounded mt-2 p-4 pt-2" style="height: fit-content; width: 90%;">
                <div class="d-flex justify-content-between p-2">
                <h3 class="mt-2 fw-bold">
                    @foreach ($departments as $department)
                        @if($department->id == auth()->user()->dept_id)
                            {{$department->dept_name}} |
                        @endif
                    @endforeach
                    Users</h3>
                <button type="button" class="btn btn-primary addButton" data-bs-target=".modalviewadduser" data-bs-toggle="modal" href="#"><i class="fa-solid fa-plus"></i></button>
                </div>
                <div>
                <form method="GET" class="form-inline d-flex" action="{{route('search.user')}}" class="d-flex">
                    <div class="input-group">
                    <input class="form-control mr-sm-2 rounded-end-0" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}" type="search" name="search" placeholder="Search" aria-label="Search">
                      @if(url()->current() !== route('view.user'))
                        <a href="{{route('view.user')}}" type="button" class="close btn bg-transparent" style="margin-left: -40px; z-index: 1;">
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
                    <form class="px-4 py-3" action="{{ route('spsearch.user')}}" method="GET" id="searchFilterLogsSp">
                      <div class="form-group">
                        <label for="nameSearch">Name</label>
                        <input type="text" class="form-control" id="nameSearch" name="nameSearch" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="idSearch">ID</label>
                        <input type="text" class="form-control" id="idSearch" name="idSearch" placeholder="#">
                      </div>
                      <div class="form-group">
                        <label for="emailSearch">Email</label>
                        <input type="text" class="form-control" id="emailSearch" name="emailSearch" placeholder="example@email.com">
                      </div>
                      <div class="form-group">
                        <label for="roleSearch">Role</label>
                        <select name="roleSearch" class="form-select">
                            <option hidden selected></option>
                            <option value="Admin">Admin</option>
                            <option value="Moderator">Moderator</option>
                            <option value="suser">Standard User</option>
                        </select>
                      </div>
                      @if(auth()->user()->dept_id == 0)
                      <div class="form-group">
                        <label for="deptSearch">Department</label>
                        <select name="deptSearch" class="form-select">
                            <option hidden selected></option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">
                                    {{$department->dept_name}}
                                </option>
                            @endforeach
                        </select>
                      </div>
                      @endif
                      <div class="form-group">
                        <label for="DateSearch">Created Date</label>
                        <input type="Date" class="form-control" id="DateSearch" name="DateSearch">
                      </div>
  
                    <div class="dropdown-divider"></div>
                      <button type="submit" class="btn btn-primary ms-auto-right">Search</button>
                      
                    </form>
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
                            <th>
                                <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'name', 'sort' => $currentSort]) }}">
                                    Name
                                    <i @if($requestBy !== 'name')
                                    hidden
                                    @endif
                                    class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'name' ? 'up' : 'down'}}"></i></a>
                            </th>
                            <th>
                                <a class="text-black text-decoration-none ms-1" href="{{ request()->fullUrlWithQuery(['by' => 'email', 'sort' => $currentSort]) }}">
                                    Email
                                    <i @if($requestBy !== 'email')
                                    hidden
                                    @endif
                                    class="text-primary ms-1 fa-solid fa-caret-{{ request('sort') === 'asc' && request('by') === 'email' ? 'up' : 'down'}}"></i></a>
                            </th>
                            <th
                            @if(auth()->user()->dept_id !== 0)
                            hidden
                            @endif
                            >Department</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </thead>
                        @if($users->isEmpty())
                        <tr>
                            <td colspan="{{auth()->user()->dept_id == 0 ? 6 : 5}}" class="text-center">No users found.</td>
                        </tr>
                        @else
                        @foreach ($users as $user)
                        <tr
                        >
                            
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td
                            @if(auth()->user()->dept_id !== 0)
                            hidden
                            @endif
                            >{{$user->department->dept_name == "No Department" ? "All Departments" : $user->department->dept_name}}</td>
                            <td>{{ucFirst($user->role)}}</td>
                            <td><button type="button" id="btn-view-user" class="btn btn-primary" data-bs-target=".modalviewuser" data-bs-toggle="modal" href="#"
                                data-name="{{$user->name}}"
                                data-provider="{{ucFirst($user->provider)}}"
                                data-userid="{{$user->id}}"
                                data-email="{{$user->email}}"
                                data-deptid="{{$user->dept_id}}"
                                data-deptname="{{$user->department->dept_name}}"
                                data-role="{{$user->role}}"
                                data-createdat="{{$user->created_at}}"
                                data-updatedat="{{$user->updated_at}}"
                                ><i class="fa-solid fa-magnifying-glass"></i></td>
                        </tr>
                        @endforeach
                        @endif
                    </table>
                </div>
                    {{$users->links('vendor.pagination.bootstrap-5')}}
            </div>
            
        </div>
        </section>
            <div class="modal fade bd-modal-lg modalviewadduser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg d-flex">
                <div class="modal-content" id="modaltoview">
                    <div class="modal-header" style="border-bottom:0;">
                        <h5 class="modal-title">Add a User</h5>
                        <button type="button" class="close position-absolute end-0 top-0 fs-3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" class="m-3" action="{{route('add.user')}}">
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
                        <label for="aName">Name</label>
                        <input type="text" class="form-control mt-2" id="aName" name="name" required>
                        <label for="aEmail">Email</label>
                        <input type="email" class="form-control mt-2" id="aEmail" name="email" required>
                        <label class="pb-0" for="aPassword" >Password</label>
                        <input type="password" class="form-control" name="password" id="aPassword" 
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        <div class="d-flex" style="gap: 5px">
                        <label for="aRole">Role</label>
                        <i class="fa-solid fa-circle-info text-primary p-1 text-center" style="margin-top: 2px" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right" title="
                        <strong>- Standard User</strong>: User can view, create, delete, or edit (visitors and logs) but they can only edit or delete their own added entries. <br>
                        <strong>- Moderator</strong>: User can view, create, delete, or edit (visitors and logs). <br>
                        <strong>- Admin</strong>: User can view, create, delete, or edit (visitors and logs) with the inclusion to manage other users in their respective department (Create, Edit or Delete)."></i>
                        </div>
                        <select class="form-control mt-1 mb-4" id="aRole" name="role">
                            <option value="user">Standard User</option>
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="mb-3 pb-4">
                        <section class="d-flex position-absolute end-0 bottom-0 p-3" style="gap:5px">
                        <button type="submit" class="btn-primary btn mt-2">Add</button>
                        <button type="button" class="btn-secondary btn mt-2" data-bs-dismiss="modal">Cancel</button>
                        </section>
                        </div>
                    </form>
                </div>
                </div>
            </div>

            <div class="modal fade modaldeletepopup fit-content" id="modaldeletepopup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg d-flex justify-content-center">
                  <div class="modal-content" id="modaltopopup" style="max-width: 500px">
                    <div class="">
                      <form method="POST" action="{{route('delete.user')}}">
                        @csrf
                      <input type="hidden" name="id" id="inputValDelete">
                      <div class="p-3 modal-header">
                        <h5>Delete Warning</h5>
                        
                        <button type="button" class="close position-absolute end-0 top-0 fs-3" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
        
                        <p class="p-3">Are you sure you want to delete this user?
                            This effectively bans the account but details are recoverable
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

            <div class="modal fade bd-modal-lg modalviewuser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg d-flex">
                <div class="modal-content" id="modaltoview">
                    <div class="modal-header" style="border-bottom:0;">
                        <h5 class="modal-title">User Details</h5>
                        <button type="button" class="close position-absolute end-0 top-0 fs-3" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="p-2 ms-3">
                        <form method="POST" action="{{route('edit.user')}}">
                            @csrf
                            @method('PUT')
                            
                        <p class="pb-0 mb-0 pt-1">ID</p>
                        <p class="text-primary" id="vuserid"></p>
                        <input type="hidden" id="eId" name="id">
                        <p class="pb-0 mb-0">Name</p>
                        <p class="text-primary" id="vname"></p>
                        <input type="text" class="text-primary form-control" id="eName" name="name">
                        <p class="pb-0 mb-0">Email</p>
                        <p class="text-primary" id="vemail"></p>
                        <input type="email" class="text-primary form-control" id="eEmail" name="email">
                        
                        <div>
                            <input class="form-check-input" type="checkbox" id="changePassword" onclick="togglePasswordField()">
                            <label class="form-check-label" for="changePassword" id="labelChangePassword">
                            Change Password?
                            </label>
                        </div>

                        <label class="pb-0" for="ePassword" id="txtPassword" 
                        pattern=".{8,}" title="Eight or more characters">Password</label>
                        <input type="password" class="form-control" name="password" id="ePassword">
                        <p class="pb-0 mb-0">Department</p>
                        <p class="text-primary" id="vdeptname"></p>
                            <select name="dept_id" class="text-primary form-control" id="eDept"
                                @if ($isAdmin == 0)
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
                            
                        <div class="d-flex" style="gap:3px">
                        <p class="pb-0 mb-0">Role</p>
                        
                        <i class="fa-solid fa-circle-info text-primary p-1 text-center" style="margin-top: 2px" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="right" title="
                        <strong>- Standard User</strong>: User can view, create, delete, or edit (visitors and logs) but only their own. <br>
                        <strong>- Moderator</strong>: User can view, create, delete, or edit (visitors and logs). <br>
                        <strong>- Admin</strong>: User can view, create, delete, or edit (visitors and logs) with the inclusion to manage other users in their respective department (Create, Edit or Delete)."></i>
                        </div>
                        <p class="text-primary" id="vrole"></p>
                        <select name="role" class="text-primary form-select pb-1 mb-1" id="eRole">
                            <option value="user" title="User  can view, create, delete, or edit (visitors and logs) but only their own">Standard User</option>
                            <option value="moderator" title="User can view, create, delete, or edit (visitors and logs)">Moderator</option>
                            <option value="admin" title="User can view, create, delete, or edit (visitors and logs) with the inclusion to manage other users in their respective department (Create, Edit or Delete)">Admin</option>
                            </span>
                        </select>
                        <p class="pb-0 mb-0">Provider</p>
                        <p class="text-primary" id="vprovider"></p>                        
                                
                        <div class="d-flex justify-content-between">
                            <div class="d-flex" style="gap: 5px;">
                            <p class="text-secondary" id="vcreatedat"></p>
                            <p class="text-secondary" id="vupdatedat"></p>
                            </div>
                            <div class="d-flex p-2" style="gap: 5px">
                            <button type="button" class="btn btn-primary" id="editBtn">Edit</button>
                            <button type="submit" class="btn btn-primary" id="svBtn">Save</button>
                            <button type="button" class="btn btn-danger" id="delBtn" data-bs-toggle="modal" data-bs-target=".modaldeletepopup"><i class="fa-solid fa-trash"></i></button>
                            <button type="button" class="btn-secondary btn" id="cnBtn">Cancel</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="bckBtn">Back</button>
                            </div>
                            
                        </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            @else
                @include('partials.invalid-perms')
            @endif
        @else
            @include('partials.invalid-perms')

        @endauth
        @endif
    </body>
</html>

<script>
    var checkbox = document.getElementById('changePassword');
    var providerCheck = null;

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    })

    function disableEdit(){
        $('#eName').hide();
        $('#vname').show();
        $('#eEmail').hide();
        $('#vemail').show();
        $('#eDept').hide();
        $('#vdeptname').show();
        $('#eRole').hide();
        $('#vrole').show();

        $('#svBtn').hide();
        $('#cnBtn').hide();
        $('#editBtn').show();
        $('#bckBtn').show();
        $('#delBtn').hide();
        $('#changePassword').hide();
        $("#ePassword").hide();
        $("#txtPassword").hide();
        $("#labelChangePassword").hide();
        }

    function capFirst(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
    }

    $(document).on('click', '#btn-view-user',function (e) {
        let name = $(this).data('name');
        let userId = $(this).data('userid');
        let email = $(this).data('email');
        let deptId = $(this).data('deptid');
        let deptName = $(this).data('deptname') || "N/A";
        let role = $(this).data('role');
        let createdat = $(this).data('createdat') || "N/A";
        let updatedat = $(this).data('updatedat') || "N/A";
        let provider = $(this).data('provider') || "Default";
        providerCheck = provider;

        console.log(providerCheck);

        let capRole = capFirst(role);

        $('#vprovider').text(provider);
        $('#vname').text(name);
        $('#vuserid').text(userId);
        $('#vemail').text(email);
        $('#vdeptname').text(deptName);
        $('#vrole').text(capRole);
        $('#vcreatedat').text("Created: " + createdat);
        $('#vupdatedat').text("Updated: " + updatedat);

        $('#eName').val(name);
        $('#eEmail').val(email);
        $('#eDept').val(deptId);
        $('#eRole').val(role);
        $('#eId').val(userId);

        $('#inputValDelete').val(userId);

        console.log(deptId);

        disableEdit();

        if(deptId == 0 && role == "admin"){
            $('#editBtn').hide();
        }

    });

    
    function togglePasswordField() {

        if (checkbox.checked) {
        $("#ePassword").show();
        $("#txtPassword").show();
        } else {
        $("#ePassword").hide();
        $("#txtPassword").hide();
        }
    }

    $(document).on('click', '#editBtn', function(e) {

        $('#eName').show();
        $('#vname').hide();

        $('#eEmail').show();
        $('#vemail').hide();

        if(providerCheck === "Azure"){
            $('#eEmail').hide();
            $('#vemail').show();
        }

        $('#eDept').show();
        $('#vdeptname').hide();
        $('#eRole').show();
        $('#vrole').hide();
        
        $('#svBtn').show();
        $('#cnBtn').show();
        $('#editBtn').hide();
        $('#bckBtn').hide();
        $('#delBtn').show();
        $('#changePassword').show();
        $('#labelChangePassword').show();
    });

    $(document).on('click', '#cnBtn', function(e)
    {
        disableEdit();
    });

</script>