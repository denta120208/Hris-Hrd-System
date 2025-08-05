@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $("#leave_type").change(function(){
            var e = document.getElementById("leave_type");
            var id = e.options[e.selectedIndex].value;
            alert(e);
            $.ajax({
                url: '{{ route('getBal') }}',
                type: 'post',
                data: {id:id, _token: '{{ csrf_token() }}'},
                dataType: 'json',
                success:function(response){
                    $('#balance').val(response.balance);
                }
            });
        });

        $('#start_date,#end_date').datetimepicker({
            useCurrent: true,
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
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <br /><br />
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <form action="{{ route('saveLeave') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            <?php
                            $type = \App\Models\Leave\LeaveType::lists('name','id')->prepend('-=Pilih=-', '0');
                            ?>
                            {!! Form::label('leave_type', 'Leave Type') !!}
                            {!! Form::select('leave_type', $type, '', ['class' => 'form-control', 'id' => 'leave_type']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="balance">Entitle Balance</label>
                            <input class="form-control" type="text" name="balance" id="balance" value="" disabled="disabled" />
                        </div>
                    </div>
                </div>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" rows="5" name="comments" id="comments"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="toggle-select-act fm-cmp-mg">
                        <div class="nk-toggle-switch">
                            <label for="ts1" class="ts-label">Half day</label>
                            <input id="ts1" type="checkbox" hidden="hidden" name="ts1">
                            <label for="ts1" class="ts-helper"></label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary pull-right">Request</button>
            </form>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4>History Entitle</h4>
            <table id="data-table-basic" class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Entitlement Type</th>
                    <th>Days</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection