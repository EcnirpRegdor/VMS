<div id="alerts" class="position-absolute end-0 top-0 p-2" style="z-index: 2;">

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

@elseif(session('fail'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('fail') }}
        <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

@elseif(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        {{ session('warning') }}
        <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close position-absolute end-0 top-0" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
</div>

<script>
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.classList.remove('show');
                alert.classList.add('fade');

                setTimeout(function(){
                    alert.remove();
                    
                }, 1000);
            }, 15000);
            
        });
</script>