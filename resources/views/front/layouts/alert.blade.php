@if (Session::has('success'))
    <div class="alert alert-success">
        <span><i class="icon fas fa-check"></i>{{ Session::get('success') }}</span>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        <span><i class="icon fas fa-times"></i>{{ Session::get('error') }}</span>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning">
        <span>{{ Session::get('warning') }}</span>
    </div>
@endif