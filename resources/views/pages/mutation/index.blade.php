@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#otTable').DataTable({ });
    $('#date_filter').datetimepicker({
        format: 'Y-m-d',
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('mutation.add') }}" class="btn btn-primary">New Request</a>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="otTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Emp Number</th>
                    <th>Emp Name</th>
                    <th>Unit From</th>
                    <th>Unit To</th>
                    <th>Mutation Type</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Approved By</th>
                    <th>Approved At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($requests)
                @foreach($requests as $row)
                <tr>
                    <td>{{ $row->emp_sub->employee_id }}</td>
                    <td>{{ $row->emp_sub->emp_firstname." ".$row->emp_sub->emp_middle_name." ".$row->emp_sub->emp_lastname }}</td>
                    <td>{{ $row->project_from->name }}</td>
                    <td>{{ $row->project_to->name }}</td>
                    <td>{{ $row->mutation_type->type }}</td>
                    <td>{{ $row->mutation_status->name }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ $row->approved_by }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->approved_at)) }}</td>
                    <td></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td></td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection