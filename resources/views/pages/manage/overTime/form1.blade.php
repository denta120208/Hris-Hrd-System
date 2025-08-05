@extends('_main_layout')

@section('content')
<script type="text/javascript">
//    $(document).ready(function(){
//        $('#ot_date').datetimepicker({
//            useCurrent: true,
//            format: 'Y-m-d',
//            timepicker:false
//            // minDate: moment()
//        });
//    });
    
//    $('#ot_date').datetimepicker().on('dp.change', function (e) {
//        $('#ot_date').data('DateTimePicker').minDate($('#ot_date').val());
//        $(this).data("DateTimePicker").hide();
//    });
</script>
<!--<script type="text/javascript">
    $(document).ready(function(){
        $('#start_time,#end_time').datetimepicker({
            useCurrent: false,
            format: 'H:i',
            timepicker:true,
            minDate: moment()
        });
        
        $('#start_time').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            incrementDay.add(1, 'days');
            $('#end_time').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        
        $('#end_time').datetimepicker().on('dp.change', function (e) {
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(1, 'days');
            $('#start_time').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });
    });
</script>-->
<div class="container">
    <h1>Add Overtime</h1>
    <div class="row">
        <br /><br />
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <form action="{{ route('hrd.overtime.save') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="date nk-int-st">
                            <label for="emp_name">Employee Name</label>
                            <input class="form-control" type="text" name="emp_name" id="emp_name" value="{{$emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname}}" readonly="readonly" disabled="disabled"/>
                            <input class="form-control" type="hidden" name="emp_number" id="emp_number" value="{{$emp->emp_number}}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="date nk-int-st">
                            <label for="start_date">Overtime Date</label>
                            <input class="form-control" type="text" name="ot_date" id="ot_date" value="{{$overDate}}" readonly="readonly" />
                            <input class="form-control" type="hidden" name="attend_id" id="attend_id" value="{{$attend_id}}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="date nk-int-st">
                            <label for="start_date">Start Time</label>
                            <input class="form-control" type="text" name="start_time" id="start_time" value="{{$in}}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="date nk-int-st">
                            <label for="end_date">End Time</label>
                            <input class="form-control" type="text" name="end_time" id="end_time" value="{{$out}}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="ot_reason">Reasons</label>
                            <textarea class="form-control" rows="5" name="ot_reason" id="ot_reason"></textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary pull-right">Request</button>
            </form>
        </div>
    </div>
</div>
@endsection