@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>List Projects</h1>
    <a class="btn btn-primary" href='{{ route('projects.create') }}'>Add Project</a>
    <div>&nbsp;</div>
    <table class="table table-striped table-responsive">
        <tr>
            <th>No</th>
            <th>Project Name</th>
            <th>Project Code</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($projects))
        <?php $no = 1;?>
        @foreach ($projects as $project)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->code }} - {{ $project->seq }}</td>
            <td><a href="{{ route('projects.edit', $project->id) }}"><i class="fa fa-edit" title="Edit Project"></i></a></td>
            <td><a href="{{ route('projects.confirm', $project->id) }}"><i class="fa fa-trash" title="Delete Project"></i></a></td>
        </tr>
        <?php $no++;?>
        @endforeach
        @else
        <tr>
            <td colspan="4"><strong>No Data Found</strong></td>
        </tr>
        @endif
        {!! $projects->render() !!}
    </table>
</div>
@endsection