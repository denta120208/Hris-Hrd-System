@extends('_main_layout')

@section('content')

<div class="col-lg-12">
    <h1>{!! $bank->exists ? 'Edit Bank' : 'Create Bank' !!}</h1>
    &nbsp;
    {!! Form::open([
        'method' => $bank->exists ? 'put' : 'post',
        'route' => $bank->exists ? ['banks.update', $bank->id] : ['banks.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $bank->name }}" />
    </div>
    @if(Session::get('project') == 'HO')
    <?php
        $project = App\Project::lists('name', 'id')->prepend('-=Pilih=-', '0');
    ?>
    <div class="form-group">
        {!! Form::label('project_code', 'Project') !!}
        {!! Form::select('project_code', $project, null, ['class' => 'form-control']) !!}
    </div>
    @endif
    @if($bank->exists)
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control">
            <option value="1">Activate</option>
            <option value="0">Deactivate</option>
        </select>
    </div>
    @endif
    <div class="form-group col-lg-12">
        <input type="submit" value="Save" class="btn btn-primary" />
        <a class="btn btn-danger" href="{{ route('banks.index') }}">Back</a>
    </div>
    {!! Form::close() !!}
</div>
@endsection