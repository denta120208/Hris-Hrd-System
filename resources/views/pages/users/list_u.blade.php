@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#usrTable').DataTable({ });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>List Users</h1>
            <a class="btn btn-primary" href="{{ route('users.create') }}">Add User</a>
            <div class="col-md-12">&nbsp;</div>
            <table id="usrTable" class="table table-responsive table-striped">
                <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Pemission</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
                </thead>
                <tbody>
        @if(count($users))
            <?php $no = 1;?>
        @foreach($users as $user)
        <tr>
            <td>{{ $no }}</td>
            <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->perms_name }}</td>
            @if($user->status == FALSE)
            <td>Deleted</td>
            <td>{{ $user->delete_at}}</td>
            <td><a href="{{ route('users.activate', $user->id) }}"><i class="fa fa-check-square-o" title="Activate User"></i></a></td>
            @else
            <td>Active</td>
            <td><a href="{{ route('users.edit', $user->id) }}"><i class="fa fa-edit" title="Edit User"></i></a></td>
            <td><a href="{{ route('users.confirm', $user->id) }}"><i class="fa fa-trash" title="Delete User"></i></a></td>
            @endif
        </tr>
        <?php $no++;?>
        @endforeach
        @endif
                </tbody>
    </table>
        </div>
    </div>
</div>
@endsection