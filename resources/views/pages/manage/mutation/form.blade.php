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
                url: "{{ route('listDept') }}",
                data: {emp_number:$('#sub_emp_number').val(), _token:"{{ csrf_token() }}"},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('#mt_from_dept').val(data['name']);
                    $('#dept_id').val(data['dept_id']);
                    $('#mt_from_loc').val(data['loc_id']);
                    $('#loc_name').val(data['loc_name']);
                }
            });
        });
    });
</script>
    <div class="container">
        <h1>Request Mutation</h1>
        <div class="row">
            <br /><br />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form action="{{ route('mutation.save') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="sub_emp_number">Subordinative</label>
                                <select class="form-control" name="sub_emp_number" id="sub_emp_number">
                                    <option value="">-= Subordinative =-</option>
                                @foreach($mutations as $mutation)
                                    <option value="{{ $mutation->erep_sub_emp_number }}">{{ $mutation->emp_firstname.' '.$mutation->emp_middle_name.' '.$mutation->emp_lastname }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <?php
                                $type = \App\Models\Mutations\MutationType::lists('name','id')->prepend('-=Mutation Type=-', '0');
                                ?>
                                {!! Form::label('mt_type', 'Mutation Type') !!}
                                {!! Form::select('mt_type', $type, '', ['class' => 'form-control', 'id' => 'mt_type']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('mt_from_dept', 'Mutation Dept From') !!}
                                <input type="hidden" id="dept_id" name="dept_id" />
                                <input type="text" class="form-control" id="mt_from_dept" name="mt_from_dept" disabled="disabled" />
{{--                                <select name="mt_from_dept" id="mt_from_dept" class="form-control"></select>--}}
                            </div>
                        </div>
                    </div>
                    <?php
                        $depts = \App\Models\Employee\EmpDept::lists('name','id')->prepend('-=Mutation Dept To=-', '0');
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('mt_to_dept', 'Mutation Dept To') !!}
                                {!! Form::select('mt_to_dept', $depts, '', ['class' => 'form-control', 'id' => 'mt_to_dept']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('mt_from_loc', 'Mutation From') !!}
                                <input type="hidden" id="mt_from_loc" name="mt_from_loc" />
                                <input type="text" class="form-control" id="loc_name" name="loc_name" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <?php
                        $project = \App\Project::lists('name','id')->prepend('-=Mutation Location=-', '0');
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('mt_to_loc', 'Mutation To') !!}
                                {!! Form::select('mt_to_loc', $project, '', ['class' => 'form-control', 'id' => 'mt_to_loc']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="mt_reason">Reasons</label>
                                <textarea class="form-control" rows="5" name="mt_reason" id="mt_reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary pull-right">Request</button>
                </form>
            </div>
        </div>
    </div>
@endsection