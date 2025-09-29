
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<style>
    ul .nav-link:hover{ 
      background-color: #9cb0f0;
      opacity: 0.8;
    }
    .sidebar-main, .sidebar-flex{
        transition: left 0.3s ease;
        left: -280px;
        width: 0;
    }

    .sidebar-main.active, .sidebar-flex.active{
        left: 0;
        width: 280px;
    }
    .sidebar-nav-link.active {
        color:white !important;
    }
    .toggle-btn {
            position: fixed;
            top: 15px;
            left: 10px;
            z-index: 1001;
            transition: left 0.3s ease;
        }
    .toggle-btn.active {
        position: fixed;
        left: 260px;
    }
  </style>

@php
$urlIs = '';
$getSegment = request()->segment(1);
$paginationCookie = request()->cookie('pagination') ?? $_COOKIE['pagination'] ?? null;
$paginationOptions = ['10','20','25','30', '50','75','100'];
switch (true){
    case(Request::is('home') || $getSegment == 'home'):
        $urlIs = 'Home';
        break;
    case(Request::is('dashboard') || $getSegment == 'dashboard'):
        $urlIs = 'Dashboard';
        break;
    case(Request::is('logs') || $getSegment == 'logs'):
        $urlIs = 'Logs';
        break;
    case(Request::is('visitors') || $getSegment == 'visitors'):
        $urlIs = 'Visitors';
        break;
    case(Request::is('add-user') || $getSegment == 'add-user'):
        $urlIs = 'Manage Users';
        break;

}
$hasProvider = auth()->user() ? auth()->user()->provider : 'null';

$currentUrl = url()->current();
if($urlIs === ''){
    $urlIs = "Home";
}
@endphp

<div class="modal fade bd-modal-lg modalviewsettings" id="modalviewsettings" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg d-flex" style="z-index: 10000">
    <div class="modal-content p-1" style="z-index: 1090 !important">
      <div class="modal-header justify-content-between" style="border-bottom:0;">
          
        <h5 class="modal-title" id="modalProfileTitle">Settings</h5>
        <button type="button" class="close text-end position-absolute top-0 end-0 fs-4" data-bs-dismiss="modal" aria-label="Close" style="font-size: large;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="form-check form-switch m-3">
        <input class="form-check-input" type="checkbox" id="darkModeSwitch">
        <label class="form-check-label" for="darkModeSwitch">Dark Mode</label>
      </div>
      <p class ="ms-3 mb-1">Set Pagination</p>
      <select id="selectPagination" class="m-3 pe-3 mt-0 form-select" onchange="setPaginationCookie(this.value)" style="width:20vh">
        @foreach($paginationOptions as $paginationOption)
          <option 
          @if($paginationCookie == $paginationOption)
            selected
          @elseif( $paginationCookie == null && $paginationOption == 30)
            selected
          @endif
          value="{{$paginationOption}}">{{$paginationOption}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<div class="modal fade bd-modal-lg modalviewownprofile" id="modalviewownprofile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg d-flex" style="z-index: 10000">
    <div class="modal-content p-1" style="z-index: 1090 !important">
      <div class="modal-header justify-content-between" style="border-bottom:0;">
          <h5 class="modal-title" id="modalProfileTitle">Profile Info</h5>
          <button type="button" class="close text-end position-absolute top-0 end-0 fs-4" data-bs-dismiss="modal" aria-label="Close" style="font-size: large;">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <form method="POST" action="{{route('edit.user')}}" id="formEditProfile">
        @csrf
        @method('PUT')
      <p class="ps-3 pb-0 mb-0">Name</p>
      
      <input class="form-control ps-3 m-3 mt-2 mb-2" name="name" id="editProfileName" value="{{$user->name}}" style="width: -webkit-fill-available;" required>
      <p class="text-primary ps-3 pt-0 mt-0" id="vProfileName">{{$user->name}}</p>
      <input hidden name="id" value="{{$user->id}}">
      <p class="ps-3 pb-0 mb-0">Email</p>
      <input class="form-control ps-3 m-3 mt-2 mb-2" name="email" id="editProfileEmail" value="{{$user->email}}" style="width: -webkit-fill-available;" required>
      <p class="text-primary ps-3 pt-0 mt-0" id="vProfileEmail">{{$user->email}}</p>

      <p class="ps-3 pb-0 mb-0">Department</p>
      <p class="text-primary ps-3 pt-0 mt-0">{{$user->department->dept_name == "No Department" ? "All Departments" : $user->department->dept_name}}</p>

      @if($hasProvider == null)
      <input class="form-check-input ps-3 m-3 mt-1 mb-0 me-1" type="checkbox" id="changePasswordProfile" onclick="togglePasswordFieldProfile()">
      <label class="form-check-label pt-0 mt-0" for="changePassword" id="labelChangePasswordProfile">
      Change Password?
      </label>

      <p></p>
      <label class="ps-3 pb-0 mb-0" for="ePasswordProfile" id="txtPasswordProfile">Password</label>
      <input type="password" class="form-control ps-3 m-3 mt-2 mb-2" name="password" pattern=".{8,}" title="Eight or more characters" id="ePasswordProfile" style="width:95%" placeholder="Input password here">
      <label class="ps-3 pb-0 mb-0" for="econfPasswordProfile" id="txtConfPasswordProfile">Confirm Password</label>
      <input type="password" class="form-control ps-3 m-3 mt-2 mb-2" id="eConfirmPasswordProfile" style="width:95%" placeholder="Confirm password">
              <div class="invalid-feedback ps-3" id="confirmPasswordFeedback">
          Passwords do not match.
        </div>
      @endif

      <p class="ps-3 pb-0 mb-0">Role</p>
      <p class="text-primary ps-3 pt-0 mt-0">{{ucfirst($user->role)}}</p>

      
      <div class="d-flex flex-column flex-md-row justify-content-between">
        <div class="d-flex ms-2" style="gap: 5px;">
        <p class="text-secondary">Created: {{$user->created_at ? $user->created_at : 'N/A'}}</p>
        <p class="text-secondary">Updated: {{$user->updated_at ? $user->updated_at : 'N/A'}}</p>
        </div>
        <div class="d-flex p-2" style="gap: 5px">
        <button type="button" class="btn btn-primary" id="editBtnProfile">Edit</button>
        <button type="submit" class="btn btn-primary" id="svBtnProfile">Save</button>
        <button type="button" class="btn-secondary btn" data-bs-dismiss="modal" id="cnBtnProfile">Cancel</button>
        <button type="button" class="btn btn-secondary" id="bckBtnProfile">Back</button>
        </div>
        
      </div>
      </form>
    </div>
  </div>
</div>    

<button class="btn btn-primary toggle-btn active" id="toggleSidebar"><</button>

<div class="d-flex flex-column flex-shrink-0 sidebar-flex active" id="sidebar-flex" style="height: 100%;">
</div>
<div class="d-flex flex-column flex-shrink-0 p-3 text-black bg-white position-fixed sidebar-main active" id="sidebar-main" style="width: 280px; height: 100%;  z-index: 1;">
  <span class="ps-2 pt-2 ms-2 fw-bold">
    @if($user->dept_id !== 0)
    {{auth()->user()->department->dept_name}} Department
  @else
    All Departments
  @endif
  </span>
    <hr>
    <a href="{{$currentUrl}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-black text-decoration-none hover-overlay shadow-1-strong">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4 fw-bold">{{$urlIs}}</span>
    </a>

    <hr>
    <ul class="nav nav-pills flex-column mb-auto hover-overlay">
      <li class="nav-item list-group-item-action">
      </li>

      <li>
        <a href="/dashboard" class="sidebar-nav-link nav-link
        <?php $check = $urlIs === 'Dashboard' ? 'active' : '' ; echo $check; ?>
        text-black list-group-item-action">
        <i class="fa-solid fa-gauge-simple-high" aria-hidden="true"></i>
          Dashboard
        </a>
      </li>
      <li>
        <a href="/visitors" class="sidebar-nav-link nav-link <?php $check = $urlIs === 'Visitors' ? 'active' : ''; echo $check;
          ?> text-black">
            <i class="fa-solid fa-address-book" aria-hidden="true"></i>
          Visitors
        </a>
      </li>
      <li>
        <a href="/logs" class="sidebar-nav-link nav-link 
        <?php $check = $urlIs === 'Logs' ? 'active' : '' ; echo $check; ?>
        text-black">
        <i class="fa fa-book" aria-hidden="true"></i>
          Log
        </a>
      </li>
      
      <li 
      @if(auth()->user()->role !== "admin")
      hidden
      @endif
      >
        <a href="/add-user" class="sidebar-nav-link nav-link 
        <?php $check = $urlIs === 'Manage Users' ? 'active' : '' ; echo $check; ?>
        text-black">
        <i class="fa-solid fa-users"></i>
          Manage Users
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        
        @if ($user->profile_picture)
          @switch($user->profile_picture)
          @case($user->provider !== "azure")
          <img src="{{asset('storage/' . $user->profile_picture)}}" class="me-3" height="36px" width="36px" style="border-radius: 36px">
            @break
          @case($user->provider == "azure")
          <img src="{{$user->profile_picture}}" class="me-3" height="36px" width="36px" style="border-radius: 36px">
            @break
          @endswitch

        @else
        <i class="fa-solid fa-circle-user pe-3" style="font-size:32px;" aria-hidden="true"></i>
        
        @endif
        <strong>{{$user->name}}   
        </strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow pe-3" aria-labelledby="dropdownUser1" style="">
        <p class="ps-3 pb-1 mb-0">
          {{ucfirst($user->role)}}
        </p>
        <p class="ps-3 pb-1 mb-0">
          {{$user->email}}
        </p>
        <li><hr class="dropdown-divider"></li>
        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target=".modalviewsettings">Settings</button></li>
        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target=".modalviewownprofile">View Profile</button></li>
        <li><a class="dropdown-item" href="/logout">Sign out</a></li>
      </ul>
    </div>

    


    <script>

        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar-main').classList.toggle('active');
            document.getElementById('sidebar-flex').classList.toggle('active');
            document.getElementById('toggleSidebar').classList.toggle('active');

            if (document.getElementById('toggleSidebar').classList.contains('active')) {
                this.textContent = '<';
            } else {
                this.textContent = '>';
            }
        });



        let checkProvider = @json($hasProvider);
        var formEditValidate = $('#formEditProfile');
        if(!checkProvider){
          var checkboxProfilePassword = document.getElementById('changePasswordProfile');
          $('#labelChangePasswordProfile').hide();
          $('#changePasswordProfile').hide();
          $('#txtPasswordProfile').hide();
          $('#ePasswordProfile').hide();
          $('#txtConfPasswordProfile').hide();
          $('#eConfirmPasswordProfile').hide();

          var editPasswordField = $('#ePasswordProfile');
          var confEditPasswordField = $('#eConfirmPasswordProfile');
          var passwordError = $('#confirmPasswordFeedback');
          passwordError.hide();

        }
        function togglePasswordFieldProfile() {
            if (checkboxProfilePassword.checked) {
            $("#ePasswordProfile").show();
            $("#txtPasswordProfile").show();
            $('#txtConfPasswordProfile').show();
            $('#eConfirmPasswordProfile').show();
            } else {
            $("#ePasswordProfile").hide();
            $("#txtPasswordProfile").hide();
            $('#txtConfPasswordProfile').hide();
            $('#eConfirmPasswordProfile').hide();
            passwordError.hide();
            }
          }

          formEditValidate.on('submit', function(e){
            if(!checkProvider){
            passwordError.hide();
            editPasswordField.removeClass('is-invalid');
            confEditPasswordField.removeClass('is-invalid');
            passwordError.text('Passwords do not match');
            var valid = true;
            
            if(checkboxProfilePassword.checked){
                if(!editPasswordField.val()){
                valid = false;
                
                console.log('left pass' + editPasswordField + " " + confEditPasswordField);
                editPasswordField.addClass('is-invalid');
                passwordError.show();
                passwordError.text('Password field not entered');
              }

              if(!confEditPasswordField.val()){
                console.log('left conf' + editPasswordField + " " + confEditPasswordField);
                valid = false;

                confEditPasswordField.addClass('is-invalid');
                passwordError.show();
                passwordError.text('Confirm password field not entered');
              }

              if(editPasswordField.val() !== confEditPasswordField.val()){
                
                console.log('not equal' + editPasswordField.val() + " " + confEditPasswordField.val());
                editPasswordField.addClass('is-invalid');
                confEditPasswordField.addClass('is-invalid');
                valid = false;
                passwordError.show();
              }
            }else{
              confEditPasswordField.val('');
              editPasswordField.val('');
            }

            if (!valid){
              e.preventDefault();
              e.stopPropagation();
            }
            
            }
          });
        
        const sidebar = document.getElementById('sidebar-main');
        const sidebarflex = document.getElementById('sidebar-flex');
        const togglebtn = document.getElementById('toggleSidebar');

        function minWidth(){
            if (window.innerWidth <= 768){
                togglebtn.textContent = '>';
                sidebar.classList.remove('active');
                sidebarflex.classList.remove('active');
                togglebtn.classList.remove('active');
            }
        }
        window.onload = minWidth();

        window.addEventListener('resize', function() {
            if (window.innerWidth <= 768) {
                togglebtn.textContent = '>';
                sidebar.classList.remove('active');
                sidebarflex.classList.remove('active');
                togglebtn.classList.remove('active');
            }
        });

        $('#editProfileName').hide();
        $('#editProfileEmail').hide();
        $('#svBtnProfile').hide();
        $('#bckBtnProfile').hide();
        
        $(document).on('click', '#editBtnProfile', function(e) {
          $('#editProfileName').show();
          $('#editProfileEmail').show();
          
          if(!checkProvider){
          $('#labelChangePasswordProfile').show();
          $('#changePasswordProfile').show();
          }
          $('#editBtnProfile').hide();
          $('#cnBtnProfile').hide();
          $('#svBtnProfile').show();
          $('#bckBtnProfile').show();
          $('#vProfileName').hide();
          $('#vProfileEmail').hide();
          $('#modalProfileTitle').text('Edit Profile Info');
        });

        $(document).on('click', '#bckBtnProfile', function(e) {
          $('#editProfileName').hide();
          $('#editProfileEmail').hide();
          
          if(!checkProvider){
          $('#labelChangePasswordProfile').hide();
          $('#changePasswordProfile').hide();
          $('#txtPasswordProfile').hide();
          $('#ePasswordProfile').hide();
          }
          $('#svBtnProfile').hide();
          $('#bckBtnProfile').hide();
          $('#editBtnProfile').show();
          $('#cnBtnProfile').show();
          $('#vProfileName').show();
          $('#vProfileEmail').show();
          $('#modalProfileTitle').text('Profile Info');
        });

        const toggleButton = document.getElementById('darkModeSwitch');

        function setThemeCookie(getTheme){
          document.cookie = `theme=${getTheme}; path=/; max-age=31536000`;
        }

        function setPaginationCookie(PaginationNumCookie){
          document.cookie = `pagination=${PaginationNumCookie}; path=/; max-age=31536000`;
          $('#alerts').append(`
          <div class="alert alert-success alert-dismissible fade show">
              Successfully updated pagination setting to ${PaginationNumCookie}, refresh to apply effect
              <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
          </div>
          `);
        }

        function getThemeCookie() {
          const name = "theme=";
          const decodedCookie = decodeURIComponent(document.cookie);
          const ca = decodedCookie.split(';');
          
          for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
          }
          return "";
        }

        //dark mode
        const currentTheme = getThemeCookie() || document.documentElement.getAttribute('data-bs-theme');
        if (currentTheme === 'dark') {
          document.documentElement.setAttribute('data-bs-theme', 'dark');
          document.getElementById('darkModeSwitch').checked = true;
        } else {
          document.documentElement.setAttribute('data-bs-theme', 'light');
        }

      toggleButton.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        if (currentTheme === 'dark') {
          document.documentElement.setAttribute('data-bs-theme', 'light');
          setThemeCookie('light'); 
        } else {
          document.documentElement.setAttribute('data-bs-theme', 'dark');
          setThemeCookie('dark');
        }
      });
    </script>