@extends('layouts.app')

@section('content')
<a href="/roles/create" class="btn btn-primary">Create New Role</a>
<table class="table">
    <thead>
      <tr>
        <th scope="col">#id</th>
        <th scope="col">Role</th>
        <th scope="col">Permission</th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
    @forelse ($roles as $role)
    <tr>
        <th scope="row">{{$role->id}}</th>
        <td><a href="roles/{{$role->id}}">{{$role->name}}</a></td>
        <td>
            @if ($role->permissions != null)

            @foreach ($role->permissions as $permission)
            <span class="badge badge-secondary">
                {{ $permission->name }}
            </span>
            @endforeach

        @endif</td>
        <td>
            <a href="/roles/{{ $role['id'] }}/edit" class="btn btn-warning">Edit</i></a>
        </td>
        <td>
            <form method="POST" action="{{route('roles.destroy', $role->id)}}">

                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <button type="submit" name="delete" class=" btn btn-danger btn-sm" >Delete</button>
                </form>
        </td>
      </tr>
    @empty
        <h1>None</h1>
    @endforelse
    </tbody>
  </table>
@endsection
