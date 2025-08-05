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
        $('#sub_emp_number').autocomplete({
            source: function( request, response ) {
                var dt = request.term;
                $.ajax({
                    url: "{{ route('promotion.getEmp') }}",
                    dataType: "json",
                    type: "GET",
                    data: {
                        q: request.term,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            var d = item.split(';');
                            return {
                                label: d[1] + " - " + d[0],
                                value: d[0],
                                name: d[0],
                                id: d[2],
                                job_title: d[4]
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                $('#emp_number').val(ui.item.id)
                $('#pro_from').val(ui.item.job_title)
                $('#pro_from_id').val(ui.item.id)
            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
        $( "#sub_emp_number" ).autocomplete( "option", "appendTo", ".eventInsForm" );
    });
</script>
    <div class="container">
        <h1>New Promotion</h1>
        <div class="row">
            <br /><br />
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <form action="{{ route('hrd.promotion.save') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="sub_emp_number">Employee</label>
                                <input type="hidden" id="emp_number" name="emp_number" />
                                <input type="text" class="form-control" id="sub_emp_number" name="sub_emp_number" />
                            </div>
                        </div>
                    </div>
                    <?php
                    $jobs = \App\Models\Master\JobMaster::lists('job_title','id')->prepend('-=Job =-', '0');
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_from', 'From Level') !!}
                                <input type="text" class="form-control" id="pro_from" name="pro_from" readonly="readonly" />
                                <input type="hidden" class="form-control" id="pro_from_id" name="pro_from_id" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                {!! Form::label('pro_to', 'To Level') !!}
                                {!! Form::select('pro_to', $jobs, '', ['class' => 'form-control', 'id' => 'pro_to']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="pro_doc_no">Document Number</label>
                                <input type="text" class="form-control" id="pro_doc_no" name="pro_doc_no" />
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