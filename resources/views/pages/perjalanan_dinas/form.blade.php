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
        <h1>Request Perjalanan Dinas</h1>
        <div class="row">
            <br /><br />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form action="{{ route('perjalanDinasRequest.save') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="start_date">Start Date</label>
                                <input class="form-control" type="text" name="start_date" id="start_date" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                <label for="end_date">End Date</label>
                                <input class="form-control" type="text" name="end_date" id="end_date" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <?php
                    $project = \App\Project::lists('name','id')->prepend('-=Mutation Location=-', '0');
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="date nk-int-st">
                                {!! Form::label('pd_project_des', 'PD Destination') !!}
                                {!! Form::select('pd_project_des', $project, '', ['class' => 'form-control', 'id' => 'pd_project_des']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="pd_reason">Reasons</label>
                                <textarea class="form-control" rows="5" name="pd_reason" id="pd_reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Request</button>
                </form>
            </div>
        </div>
    </div>
@endsection