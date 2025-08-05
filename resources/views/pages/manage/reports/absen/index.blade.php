@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#start_date,#end_date').datetimepicker({
        useCurrent: false,
        format: 'Y-m-d',
        timepicker:false,
        // minDate: moment()
    });
    $('#start_date').datetimepicker().on('dp.change', function (e) {
        // var incrementDay = moment(new Date(e.date));
        // incrementDay.add(1, 'days');
        $('#end_date').data('DateTimePicker').minDate(incrementDay);
        $(this).data("DateTimePicker").hide();
    });
    $('#end_date').datetimepicker().on('dp.change', function (e) {
        // var decrementDay = moment(new Date(e.date));
        // decrementDay.subtract(1, 'days');
        $('#start_date').data('DateTimePicker').maxDate(decrementDay);
        $(this).data("DateTimePicker").hide();
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.rekap_absen') }}" method="post" class ="form-inline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="start_date" class="sr-only">Name</label>
                    <input class="form-control" type="text" name="start_date" id="start_date" />
                </div>
                <div class="form-group">
                    <label for="end_date" class="sr-only">NIK</label>
                    <input class="form-control" type="text" name="end_date" id="end_date"/>
                </div>
                <div class="form-group">
                    <?php
                    $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
//                    $project = \App\Models\Master\Location::lists('name','id')->prepend('-=Pilih=-', '0');
                    ?>
                    {!! Form::label('project', 'Project', ['class'=>'sr-only']) !!}
                    {!! Form::select('project', $project, '', ['class' => 'form-control', 'id' => 'project']) !!}
                </div>
                <button class="btn btn-success">Search</button>
            </form>
        </div>
    </div>
</div>

@endsection