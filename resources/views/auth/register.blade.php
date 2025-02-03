@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">{{ __('Register Form') }}</div>

                <div class="card-body">

<form action="{{ route('register') }}" method="POST" id="register-form">
        @csrf
        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" name="name" class="form-control" id="name">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" id="email">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" id="password">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
             @error('password_confirmation')
               <div class="text-danger">{{ $message }}</div>
             @enderror
        </div>

       

        <div class="form-group">
            <label>Role</label>
            <select id="role" name="role" class="form-control" >
                <option>Please Select</option>
        <option value="admin">Admin</option>
        <option value="employee">Employee</option>
      </select>
            @error('role')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <br />
       <button class="btn btn-primary"type="submit">Register</button>

</form>
</div>

</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch all countries and populate the dropdown
    });
    
</script>
@endpush