
<!DOCTYPE html>
<html {{ cookie('theme', 'light') }} lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>
        <link rel="icon" type="image/x-icon" href="{{asset('storage/images/imus_logo.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Fonts -->

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('/css/css.css') }}"/>
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css /html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5},:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        */</style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            #carouselBackground {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                z-index: -1;
            }

            .carousel-item img {
                object-fit: cover;
                height: 100vh;
            }
            .form-container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -60%);
                width: 400px;
                padding: 15px;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                z-index: 10;
            }
        </style>
    </head>
<body @if(!Auth::check())
    class="gradbg"
    @endif
    >
    @include('partials.alertmsg')
    
    @auth
    <section>
        <div class="d-flex " style="height: 100vh">
        @include('partials.sidebar')

        </div>
        


        <div class="w-100">
        @if (auth()->user()->dept_id != 0)
        <div class="container bg-white rounded mt-2 p-4 pt-2" style="height: fit-content; width: 90%;">
            <div class="d-flex justify-content-between p-2">
            <h3 class="mt-2 fw-bold">Department {{auth()->user()->department->dept_name}}</h3>
        @else
        <div class="container bg-white rounded mt-2 p-4 pt-2" style="height: fit-content; width: 90%;">
            <div class="d-flex justify-content-between p-2">
            <h3 class="mt-2 fw-bold">Welcome Admin!</h3>
        @endif
            
            </div>
        </section>
    @else
        
    <div id="carouselBackground" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        
        <div class="carousel-item active">
        <img class="d-block w-100 op-5" src="{{ asset('storage/images/newcityhall.jpg') }}" alt="First slide" data-bs-interval="5000">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100 op-5" src="{{ asset('storage/images/IMUS PLAZA & CATHEDRAL AERIAL-2.jpg') }}" alt="Second slide" data-bs-interval="5000">
        </div>
        <div class="carousel-item">
        <img class="d-block w-100 op-5" src="{{ asset('storage/images/flag.jpg') }}" alt="Third slide" data-bs-interval="5000">
        </div>

    </div>
    </div>
    <div class="form-container">
        
    <div class="d-flex align-items-center justify-content-center position-relative p-3" >
    
    <img src="{{ asset('storage/images/Logo_City_Government_of_Imus.png') }}" class="position-absolute justify-content-center pt-5" style="max-height 125px; max-width: 125px;">
    </div>
    <h3 class="text-center pt-5">Visitor Management</h3>
    
    <h5 class="text-center mt-2 text-secondary">Login</h5>
    <form class="p-4 pb-3 pt-2" action="{{route('azure.redirectlogin')}}">
        <button class="btn-light btn text-left azurebtn"><img class="p-1" src="{{asset('storage/images/Microsoft_logo.svg.png')}}" style="width:25px; height: 25px">Login with Microsoft</button>
    </form>
    <form action="/login" method="POST" class="p-4 pt-0">
        @csrf
        
        <div id="errorMessage" class="alert alert-danger d-none">Email or password is incorrect.</div>
        <div class="form-floating w-100">
        <input type="text" name="email" class="form-control" required placeholder="E-mail"><br>
        <label for="email">Email</label>
        </div>
        <div class="form-floating w-100">
        <input type="password" name="password" class="form-control" required placeholder="Password"><br>
        <label for="password">Password</label>
        </div>
        <input type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 40px;">
    </form>
    </div>
    
    @endauth
</body>
</html>