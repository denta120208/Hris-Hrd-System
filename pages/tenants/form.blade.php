@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h2>{!! $tenant->exists ? 'Edit Tenant' : 'Add Tenant' !!}</h2>
    {!! Form::model('tenant', [
        'method' => $tenant->exists ? 'put' : 'post',
        'route' => $tenant->exists ? ['tenants.update', $tenant->id] : ['tenants.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    @if(Session::get('pnum') == '1802')
    <div class="form-group">
        <label for="name">Service Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $tenant->name }}" />
    </div>
    <div class="form-group">
        <label for="loc">Service Location</label>
        <input class="form-control" type="text" name="loc" id="loc" value="{{ $tenant->loc }}" />
    </div>
    @else
    <div class="form-group">
        <label for="name">Tenant Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $tenant->name }}" />
    </div>
    <div class="form-group">
        <label for="pic">PIC Name</label>
        <input class="form-control" type="text" name="pic" id="pic" value="{{ $tenant->pic }}" />
    </div>
    <div class="form-group">
        <label for="tlp">PIC Telephone</label>
        <input class="form-control" type="text" name="tlp" id="tlp" value="{{ $tenant->tlp }}" />
    </div>
    <div class="form-group">
        <label for="loc">Tenant Location</label>
        <input class="form-control" type="text" name="loc" id="loc" value="{{ $tenant->loc }}" />
    </div>
    @endif
    
    @if(Session::get('project') == 'HO')
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
    @endif
    <input type="submit" class="btn btn-primary" />
    <a class="btn btn-danger" href="{{ route('tenants.index') }}">Back</a>
    {!! Form::close() !!}
</div>
@endsection