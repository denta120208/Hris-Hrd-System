@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            format: 'Y-m-d',
            timepicker:false,
            minDate: moment()
        });
        $('#start_date').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            incrementDay.add(1, 'days');
            $('#end_date').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        $('#end_date').datetimepicker().on('dp.change', function (e) {
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(1, 'days');
            $('#start_date').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });
    });
</script>
    <div class="container">
        <h1>Add Induction</h1>
        <div class="row">
            <br /><br />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form action="{{ route('hrd.induction.save') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="name" name="name" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            {!! Form::label('url_gform', 'Google Form') !!}
                            <input type="text" class="form-control" id="url_gform" name="url_gform" />
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Request</button>
                </form>
            </div>
        </div>
    </div>
@endsection