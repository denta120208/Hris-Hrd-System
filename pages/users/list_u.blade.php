@extends('_main_layout')

@section('content')
<script type="text/javascript">
$().click(function(){
    
});
</script>
<div class="col-lg-12">
    <h1>List Users</h1>
    <a class="btn btn-primary" href="{{ route('users.create') }}">Add User</a>
    <div class="col-md-12">&nbsp;</div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th colspan="2">Pemission</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
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
            <td colspan="2"><a href="{{ route('users.activate', $user->id) }}"><i class="fa fa-check-square-o" title="Activate User"></i></a></td>
            @else
            <td colspan="2" style="text-align: center;">Active</td>
            <td><a href="{{ route('users.edit', $user->id) }}"><i class="fa fa-edit" title="Edit User"></i></a></td>
            <td><a href="{{ route('users.confirm', $user->id) }}"><i class="fa fa-trash" title="Delete User"></i></a></td>
            @endif
            
        </tr>
        <?php $no++;?>
        @endforeach
        @endif
        {!! $users->render() !!}
    </table>
</div>
@endsection