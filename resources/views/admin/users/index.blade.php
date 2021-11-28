@extends('layouts.app')

@section('content')

<div class="row py-lg-2">
    <div class="col-md-6">
        <h2>This is user List</h2>
    </div>
    @cannot('isManager')
    <div class="col-md-6">
        <a href="/users/create" class="btn btn-primary btn-lg float-md-right" role="button" aria-pressed="true">Create New User</a>
    </div>
    @endcannot
</div>


<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        User Data List</div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Permissions</th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)

                @if(!\Auth::user()->hasRole('admin') && $user->hasRole('admin')) @continue; @endif
                <tr {{ Auth::user()->id == $user->id ? 'bgcolor=#ddd' : '' }}>
                    <td>{{$user['id']}}</td>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['email']}}</td>
                    <td>
                        @if ($user->roles->isNotEmpty())
                            @foreach ($user->roles as $role)
                                <span class="badge badge-secondary">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        @endif

                    </td>
                    <td>
                        @if ($user->permissions->isNotEmpty())

                            @foreach ($user->permissions as $permission)
                                <span class="badge badge-secondary">
                                    {{ $permission->name }}
                                </span>
                            @endforeach

                        @endif
                    </td>
                    <td>
                        <a href="/users/{{ $user['id'] }}/edit" class="btn btn-warning">Edit</i></a>
                    </td>
                    <td>
                        <form method="POST" action="{{route('users.destroy', $user->id)}}">

                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" name="delete" class=" btn btn-danger btn-sm" >Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

    </div>
</div>



@endsection
