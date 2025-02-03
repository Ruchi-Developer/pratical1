@extends('layouts.app')

@section('title', 'Employee Management')

@section('content')
    <div class="d-flex justify-content-end" style="padding-top:30px;padding-right:20px;">
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createModal" id="createEmployeeBtn">
            Create Employee
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </div>

    <div class="container mt-4">
        @if(session('success'))
            <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
        @endif
        <h3>Employee List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Phone</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->salary }}</td>
                    <td>
                        <button class="btn btn-success btn-sm editEmployeeBtn" data-id="{{ $employee->id }}">Edit</button>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.store') }}" method="POST" id="createEmployeeForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" name="department">
                                <option value="" disabled {{ old('department') ? '' : 'selected' }}>Select Department</option>
                                <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>Human Resources</option>
                                <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            </select>
                            @error('department')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}">
                            @error('position')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone No.</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary') }}">
                            @error('salary')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#createEmployeeBtn').click(function() {
        $('#createModalLabel').text('Create New Employee');
        $('#createEmployeeForm').attr('action', '{{ route('employees.store') }}');
        $('#createEmployeeForm').find('input[name="_method"]').remove();
        $('#createEmployeeForm')[0].reset();
        $('.text-danger').text('');
    });

    $(document).on('click', '.editEmployeeBtn', function() {
        var employeeId = $(this).data('id');
        
        $.ajax({
            url: '/employees/' + employeeId + '/edit',
            method: 'GET',
            success: function(data) {
                $('#name').val(data.name);
                $('#department').val(data.department);
                $('#position').val(data.position);
                $('#phone').val(data.phone);
                $('#salary').val(data.salary);
                $('#createEmployeeForm').attr('action', '/employees/' + data.id);
                $('#createEmployeeForm').append('<input type="hidden" name="_method" value="PUT">');
                $('#createModalLabel').text('Edit Employee');
                $('#createModal').modal('show');
            }
        });
    });

    $('#createEmployeeForm').submit(function(e) {
        e.preventDefault();
        
        var isValid = true;
        $('.text-danger').text('');
        
        $('#createEmployeeForm input, #createEmployeeForm select').each(function() {
            var $field = $(this);
            var errorMessage = $field.next('.text-danger');
            
            if (($field.is('input') && $field.val().trim() === '') || ($field.is('select') && !$field.val())) {
                isValid = false;
                if (errorMessage.length === 0) {
                    $field.after('<div class="text-danger">This field is required</div>');
                }
            } else {
                errorMessage.remove();
            }
        });
        
        if (isValid) {
            this.submit();
        }
    });
});
</script>
@endsection
