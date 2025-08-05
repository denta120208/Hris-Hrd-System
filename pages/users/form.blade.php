@extends('_main_layout')

@section('content')
@if($user->exists)
<script type="text/javascript">
$( document ).ready(function() {
    var str = document.getElementById('menus').value;
    var menu = str.split(',');
    for(var i=0; i< menu.length; i++){
        console.log(menu[i]);
        var tes = '#cek' + menu[i];
        $(tes).prop( "checked", true );
    }
});
</script>
@endif
<div class="col-lg-12">
    <h1>{!! $user->exists ? 'Edit User' : 'Create User' !!}</h1>
    &nbsp;
    {!! Form::model('user', [
        'method' => $user->exists ? 'put' : 'post',
        'route' => $user->exists ? ['users.update', $user->id] : ['users.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    @if($user->exists)<input type="hidden" name="menus" id="menus" value="{{ $user->permission }}" />@endif
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" />
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}" />
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" />
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password" id="password" />
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
    </div>
    <div class="form-group">
        <label for="project_code">Project Name</label>
        <select name="project_code" id='project_code' class="form-control">
        @if($projects)
            @foreach($projects as $project)
            <option value="{!! $project->project_code !!}">{{ $project->name }}</option>
            @endforeach
        @endif
        </select>
    </div>
    <div class="form-group">
        <label for="level">Level Access</label>
        <select class="form-control" id="level" name="perms_name">
            <option value="NULL">-=Pilih=-</option>
            <option value="Administrator">Administrator</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Staff">Staff</option>
            <option value="CS">CS</option>
        </select>
    </div>
    @if($menu_parents)
    <div class="form-group col-lg-12">
    @foreach($menu_parents as $row)
    <div class="col-md-4">
        @if($row->is_parent == TRUE)
        <legend>{!! $row->title !!}</legend> 
        @endif
        <ul class="checkbox">
        @foreach($menu_childs as $child)
            @if($row->id == $child->parent_id)
            <li>
                <input type="checkbox" name="menu_perms[]" id='cek{!! $child->id !!}' value="{!! $child->id !!}" />
                <label for="cek{!! $child->id !!}">{!! $child->title !!}</label>
            </li>
            @endif
        @endforeach
        </ul>
    </div> 
    @endforeach
    </div>
    @endif
    <div class="form-group col-lg-12">
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('users.index') }}">Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection