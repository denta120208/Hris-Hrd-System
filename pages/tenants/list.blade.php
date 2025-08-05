@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>List Tenants</h1>
    <a class="btn btn-primary" href='{{ route('tenants.create') }}'>Add Tenant</a>
    <div>&nbsp;</div>
    <table class="table table-striped table-responsive">
    @if(Session::get('pnum') != '1802')
        <tr>
            <th>No</th>
            <th>Tenant Name</th>
            <th>PIC</th>
            <th>Telephone</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($tenants))
        <?php $no = 1;?>
        @foreach ($tenants as $tenant)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $tenant->name }}</td>
            <td>{{ $tenant->pic }}</td>
            <td>{{ $tenant->tlp }}</td>
            <td><a href="{{ route('tenants.edit', $tenant->id) }}"><i class="fa fa-edit" title="Edit Project"></i></a></td>
            <td><a href="{{-- route('tenants.confirm', $tenant->id) --}}"><i class="fa fa-trash" title="Delete Project"></i></a></td>
        </tr>
        <?php $no++;?>
        @endforeach
        @else
        <tr>
            <td colspan="5"><strong>No Data Found</strong></td>
        </tr>
        @endif
    @else
        <tr>
            <th>No</th>
            <th>Service Name</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($tenants))
        <?php $no = 1;?>
        @foreach ($tenants as $tenant)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $tenant->name }}</td>
            <td><a href="{{ route('tenants.edit', $tenant->id) }}"><i class="fa fa-edit" title="Edit Project"></i></a></td>
            <td><a href="{{-- route('tenants.confirm', $tenant->id) --}}"><i class="fa fa-trash" title="Delete Project"></i></a></td>
        </tr>
        <?php $no++;?>
        @endforeach
        @else
        <tr>
            <td colspan="5"><strong>No Data Found</strong></td>
        </tr>
        @endif
    @endif
    {!! $tenants->render() !!}
    </table>
</div>
@endsection