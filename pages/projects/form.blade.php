@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h2>{!! $project->exists ? 'Edit Project' : 'Add Project' !!}</h2>
    {!! Form::model('project', [
        'method' => $project->exists ? 'put' : 'post',
        'route' => $project->exists ? ['projects.update', $project->id] : ['projects.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    <div class="form-group">
        <label for="name">Project Name</label>
        <input class="form-control" type="text" name="name" id="name" value="{{ $project->name }}" />
    </div>
    <div class="form-group">
        <label for="project_code">Initial Project Name</label>
        <input class="form-control" type="text" name="project_code" id="project_code" value="{{ $project->project_code }}" />
    </div>
    <div class="form-group">
        <label for="code">Project Code</label>
        <input class="form-control" type="text" name="code" id="code" value="{{ $project->code }}" />
    </div>
    <div class="form-group">
        <label for="seq">Project Sequence</label>
        <input class="form-control" type="text" name="seq" id="seq" value="{{ $project->seq }}" />
    </div>
    <input type="submit" class="btn btn-primary" />
    <a class="btn btn-danger" href="{{ route('projects.index') }}">Back</a>
    {!! Form::close() !!}
</div>
@endsection