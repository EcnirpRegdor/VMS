<div class="modal fade" id="configAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Configure your Account</h5>
        </div>
        <form method="POST" action="{{route('config.user')}}">
            @csrf
            @method('PUT')
        <div class="modal-body">
                <p>Choose your Department</p>
                <input type="hidden" name="id" value="{{auth()->user()->id}}">
                <select class="form-select" name="dept_id">
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{$department->dept_name}}</option>
                    @endforeach
                </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<script>
    $(document).ready(function() {
        $('#configAccount').modal('show');
    });

</script>

