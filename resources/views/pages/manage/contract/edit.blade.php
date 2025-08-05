@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#econ_extend_start_date,#econ_extend_end_date').datetimepicker({
        useCurrent: false,
        format: 'Y-m-d',
        timepicker:false,
    });
    
    $('#econ_extend_start_date').datetimepicker().on('dp.change', function (e) {
        $('#econ_extend_end_date').data('DateTimePicker').minDate(e.date);
        $(this).data("DateTimePicker").hide();
    });
    
    $('#econ_extend_end_date').datetimepicker().on('dp.change', function (e) {
        $('#econ_extend_start_date').data('DateTimePicker').maxDate(e.date);
        $(this).data("DateTimePicker").hide();
    });
});
</script>
<div class="container">
    <div class="row">
        <h1>Edit PKWT</h1>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('emp_name', 'Nama Karyawan') !!}
                        <input type="text" class="form-control" id="emp_name" name="emp_name" value="{{ $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname }}" disabled="disabled" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('employee_id', 'NIK') !!}
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ $emp->employee_id }}" disabled="disabled" />
                    </div>
                </div>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.updateContract', $contract->id) }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="emp_number" value="{{ $emp->emp_number }}" />
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('econ_extend_start_date', 'Tanggal Mulai') !!}
                        <input type="text" class="form-control" id="econ_extend_start_date" name="econ_extend_start_date" value="{{ $contract->econ_extend_start_date }}" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('econ_extend_end_date', 'Tanggal Berakhir') !!}
                        <input type="text" class="form-control" id="econ_extend_end_date" name="econ_extend_end_date" value="{{ $contract->econ_extend_end_date }}" />
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('template_id', 'Template PKWT') !!}
                        {!! Form::select('template_id', $temp_contract, $contract->template_id, ['class' => 'form-control', 'id' => 'template_id']) !!}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection 