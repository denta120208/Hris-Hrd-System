@extends('_main_layout')

@section('content')
<style type="text/css">
    .modal-xtra-large{
        width: 1080px;
        margin: auto;
    }
</style>
<script type='text/javascript'>
$(document).ready(function(){

});
</script>
<div class="container">
    <div class="row">
        <h1>Employee Picture</h1>
        <form action="{{ route('personalEmp.setEmpPic') }}" method="POST" enctype='multipart/form-data'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="emp_number" value="{{ $emp->emp_number }}" />
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('emp_name', 'Employee Name') !!}
                        <input type="text" class="form-control" id="emp_name" name="emp_name" value="{{ $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname }}" readonly="readonly"/>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('employee_id', 'NIK') !!}
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ $emp->employee_id }}" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 60px;"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    @if($pic)
                        @if($pic->epic_picture_type == '2')
                            <img style="height: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                        @elseif($pic->epic_picture_type == '1')
                            <img style="height: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                        @else
                            <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                        @endif
                    @else
                        <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('emp_pic', 'Emp Picture') !!}
                        {!! Form::hidden('emp_pic', 'None',['id'=>'sheet']) !!}
                        <input type="file" class="form-control" id="emp_pic" name="emp_pic" />
                    </div>
                </div>
                <button class="btn btn-primary pull-right">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection