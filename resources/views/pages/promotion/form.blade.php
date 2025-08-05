@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            format: 'Y-m-d H:i',
            timepicker:true,
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
        $('#sub_emp_number').change(function(){
            $.ajax({
                type: 'POST',
                url: "{{ route('job_from') }}",
                data: {emp_number:$('#sub_emp_number').val(), _token:"{{ csrf_token() }}"},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('#pro_from_name').val(data['job_title']);
                    $('#pro_from_title').val(data['job_name']);
                    $('#pro_from').val(data['job_title_code']);

                    // job_name
                }
            });
        });
    });
</script>
    <div class="container">
        <h1>New Promotion</h1>
        <div class="row">
            <br /><br />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form action="{{ route('promotion.save') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="sub_emp_number">Subordinative</label>
                                <select class="form-control" name="sub_emp_number" id="sub_emp_number">
                                    <option value="">-= Subordinative =-</option>
                                    @foreach($emps as $emp)
                                        <option value="{{ $emp->erep_sub_emp_number }}">{{ $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_from_name', 'From Level') !!}
                                <input type="text" class="form-control" id="pro_from_name" name="pro_from_name" disabled="disabled" />
                                <input type="hidden" name="pro_from" id="pro_from" />
                            </div>
                        </div>
                    </div>
                    <?php
                    $jobs = \App\Models\Master\JobMaster::lists('job_title','id')->prepend('-=To Level=-', '0');
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_to', 'To Level') !!}
                                {!! Form::select('pro_to', $jobs, '', ['class' => 'form-control', 'id' => 'pro_to']) !!}
                            </div>
                        </div>
                    </div>
{{--                    Add Job Title--}}
                    <!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_from_title', 'From Title') !!}
                                <input type="text" class="form-control" id="pro_from_title" name="pro_from_title" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_to_title', 'To Title') !!}
                                {!! Form::select('pro_to_title', $jobs, '', ['class' => 'form-control', 'id' => 'pro_to_title']) !!}
                            </div>
                        </div>
                    </div> -->
                    {{--                    Add Job Title--}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-check">
                            <div class="nk-int-st">
                                <input type="checkbox" class="form-check-input" id="is_pjs" name="is_pjs">
                                <label class="form-check-label" for="is_pjs">PJS</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="pro_reason">Notes</label>
                                <textarea class="form-control" rows="5" name="pro_reason" id="pro_reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Request</button>
                </form>
            </div>
        </div>
    </div>
@endsection