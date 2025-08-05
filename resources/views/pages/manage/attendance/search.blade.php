@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#empTable').DataTable({ });
    $('#date_filter').datetimepicker({
        format: 'Y-m-d',
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.inout_search_emp') }}" method="post" class ="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="date_filter" class="sr-only">Dates</label>
                    <input class="form-control" type="text" name="date_filter" id="date_filter" placeholder="2019-01-01" />
                </div>
                <div class="form-group">
                    <label for="emp_name" class="sr-only">Name</label>
                    <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Name" />
                </div>
                <div class="form-group">
                    <label for="employee_id" class="sr-only">NIK</label>
                    <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" />
                </div>
                <div class="form-group">
                    <?php
                    $emp_status = \App\Models\Master\EmploymentStatus::lists('name','id')->prepend('Employment Status', '0');
                    ?>
                    {!! Form::label('emp_status', 'Employment Status', ['class'=>'sr-only']) !!}
                    {!! Form::select('emp_status', $emp_status, '', ['class' => 'form-control', 'id' => 'emp_status']) !!}
                </div>
                <div class="form-group">
                    <?php
                    $jobCategory = \App\Models\Employee\JobCategory::lists('name','id')->prepend('Divisi', '0');
                    ?>
                    {!! Form::label('eeo_cat_code', 'Divisi', ['class'=>'sr-only']) !!}
                    {!! Form::select('eeo_cat_code', $jobCategory, '', ['class' => 'form-control eeo_cat_code', 'id' => 'eeo_cat_code']) !!}
                </div>
                <div class="form-group">
                    <label for="termination_id" class="sr-only">Employee Status</label>
                    <select name="termination_id" class="form-control" id="termination_id">
                        <option value="" disabled selected>Employee Status</option>
                        <option value="1">Active</option>
                        <option value="2">Past</option>
                    </select>
                </div>
                <button class="btn btn-success">Search</button>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="empTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>NIK</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($attR)
                @foreach($attR as $row)
                <tr>
                    <td>{{ $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->emp_lastname }}</td>
                    <td>{{ $row->employee_id }}</td>
                    <td>{{ $row->punch_in_utc_time }}</td>
                    <td>{{ $row->punch_out_utc_time }}</td>
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