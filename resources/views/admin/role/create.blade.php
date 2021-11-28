@extends('layouts.app')

@section('content')

<h1>Create new Role</h1>



<form method="POST" action="/roles">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="role_name">Role name</label>
        <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Role name..." value="{{ old('role_name') }}" required>
    </div>

    <div class="form-group" >
        <label for="roles_permissions">Add Permissions</label>
        <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" id="roles_permissions" value="{{ old('roles_permissions') }}">
    </div>
    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@endsection
