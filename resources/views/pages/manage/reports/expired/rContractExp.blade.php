@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function() {
    $('#start_date').datetimepicker({
        format: 'Y-m-d',
        timepicker:false,
    });
    $('#empTable').DataTable({
        "pageLength": 20
    });
});
</script>
<div class="container">
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.contract_exp') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-lg-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="start_date" id="start_date" readonly="readonly" placeholder="<?php echo date('Y-m-d');?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit">Go</button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div style="margin-bottom: 20px;"></div>
        @if($reports)
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="empTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Emp Name</th>
                    <th>Contract Start</th>
                    <th>Contract End</th>
                    <th>Emp Loc</th>
                    <th>Age</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $data)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $data->employee_id }}</td>
                    <td>{{ $data->emp_name }}</td>
                    <td>{{ date('Y-m-d', strtotime($data->econ_extend_start_date)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($data->econ_extend_end_date)) }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->Age }}</td>
                </tr>
                <?php $no++;?>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection