 @extends('_main_layout')

@section('content')
@if($user->exists)
<script type="text/javascript">
$( document ).ready(function() {
    var str = document.getElementById('menus').value;
    var menu = str.split(',');
    for(var i=0; i< menu.length; i++){
        var tes = '#cek' + menu[i];
        $(tes).prop( "checked", true );
    }
    {{--$('#level').change(function(){--}}
    {{--    $.ajax({--}}
    {{--        type: 'POST',--}}
    {{--        url: "{{ route('users.getMenus') }}",--}}
    {{--        data: {project_id:$('#service_id').val()},--}}
    {{--        dataType: 'html',--}}
    {{--        cache: false,--}}
    {{--        success: function(data) {--}}
    {{--            $('#customerid').html(data);--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}
});
</script>
@endif
<div class="container">
    <div class="row">
        <h1>{!! $user->exists ? 'Edit User' : 'Create User' !!}</h1>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {!! Form::model('user', [
        'method' => $user->exists ? 'put' : 'post',
        'route' => $user->exists ? ['users.update', $user->id] : ['users.store'],
    ]) !!}
    @if($user->exists)<input type="hidden" name="menus" id="menus" value="{{ $user->permission }}" />@endif
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}" />
            </div>
        </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" type="text" name="username" id="username" value="{{ $user->username }}" />
    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}" />
    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password" id="password" />
    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" />
    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <?php
        $project_id = App\Project::lists('name', 'code')->prepend('-=Pilih=-', '0');
        ?>
        {!! Form::label('project_code', 'Project Name') !!}
        {!! Form::select('project_code', $project_id, $user->project_code, ['class' => 'form-control']) !!}
    </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <label for="level">Level Access</label>
        <select class="form-control" id="level" name="perms_name">
            <option value="NULL">-=Pilih=-</option>
            <option value="Administrator" @if($user->perms_name == 'Administrator') selected @endif>Administrator</option>
            <option value="Supervisor" @if($user->perms_name == 'Supervisor') selected @endif>Supervisor</option>
            <option value="Staff" @if($user->perms_name == 'Staff') selected @endif>Staff</option>
            <option value="CS" @if($user->perms_name == 'CS') selected @endif>CS</option>
        </select>
    </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    @if($menuESS_parents)
    <div class="form-group">
        @foreach($menuESS_parents as $row)
        <div class="col-md-4">
            @if($row->is_parent == TRUE)
            <legend>{!! $row->title !!}</legend>
            @endif
            <ul class="checkbox">
            @foreach($menuESS_childs as $child)
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
    </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if($menuSup_parents)
                    <div class="form-group">
                        @foreach($menuSup_parents as $parent)
                            <div class="col-md-4">
                                @if($parent->is_parent == TRUE)
                                    <legend>{!! $parent->title !!}</legend>
                                @endif
                                <ul class="checkbox">
                                    @foreach($menuSup_childs as $kid)
                                        @if($parent->id == $kid->parent_id)
                                            <li>
                                                <input type="checkbox" name="menu_perms2[]" id='cek2{!! $kid->id !!}' value="{!! $kid->id !!}" />
                                                <label for="cek2{!! $kid->id !!}">{!! $kid->title !!}</label>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="form-group">
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('users.index') }}">Back</a>
    </div>
            </div>
    {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection