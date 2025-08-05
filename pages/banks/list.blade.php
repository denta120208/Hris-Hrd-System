@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>Bank List</h1>
    <a class="btn btn-primary" href="{{ route('banks.create') }}">Add Bank</a>
    <div class="col-md-12">&nbsp;</div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Name</th>
            @if(Session::get('project') == 'HO')<th>Project</th>@endif
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($banks))
        <?php $no = 1; ?>
        @foreach($banks as $bank)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $bank->name }}</td>
            @if(Session::get('project') == 'HO')<td>{{ $bank->project_code }}</td>@endif
            @if($bank->status == FALSE)
            <td>Deleted</td>
            <td  colspan="2"><a href="{{ route('banks.edit', $bank->id) }}"><i class="fa fa-edit" title="Edit Bank"></i></a></td>
            @else
            <td>Active</td>
            <td><a href="{{ route('banks.edit', $bank->id) }}"><i class="fa fa-edit" title="Edit Bank"></i></a></td>
            <td><a href="{{ route('banks.destroy', $bank->id) }}"><i class="fa fa-trash" title="Delete Card"></i></a></td>
            @endif
        </tr>
        <?php $no++;?>
        @endforeach
        @endif
    </table>
</div>
@endsection