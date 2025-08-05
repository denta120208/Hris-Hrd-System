@extends('_main_layout')

@section('content')
<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<script type="text/javascript">
    $(function () {
        $('#empNum').autocomplete({
            source: function (request, response) {
                //alert(request.term);
                $.ajax({
                    url: "{{ route('hrd.find_emp2') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        q: request.term,
                        empNum: '{{ $emp->emp_number }}',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            var d = item.split(';');
                            return {
                                label: d[0] + " - " + d[1],
                                value: d[0] + " - " + d[1],
                                name: d[0],
                                id: d[2]
                                        //pareantId: d[2]
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                $('#emp_incharge').val(ui.item.id)
                // $('#ACC_NO_CHAR').val(ui.item.1),
                // $('#ACC_NAME_CHAR').val(ui.item.name)
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $("#type").change(function () {
            var e = document.getElementById("type");
            var id = e.options[e.selectedIndex].value;
            $.ajax({
                url: '{{ route('getBal') }}',
                type: 'post',
                data: {id: id, _token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (response) {
                    $('#balance').val(response.balance);
                }
            });
        });

        $('#start_date,#end_date').datetimepicker({
            useCurrent: true,
            format: 'd-m-Y',
            timepicker: false
                    // minDate: moment()
        });

        $('#start_date').datetimepicker().on('dp.change', function (e) {
            // var incrementDay = moment(new Date(e.date));
            // incrementDay.add(1, 'days');
            $('#end_date').data('DateTimePicker').minDate($('#start_date').val());
            $(this).data("DateTimePicker").hide();
        });
        $('#end_date').datetimepicker().on('dp.change', function (e) {
            // var decrementDay = moment(new Date(e.date));
            // decrementDay.subtract(1, 'days');
            $('#start_date').data('DateTimePicker').maxDate($('#end_date').val());
            $(this).data("DateTimePicker").hide();
        });
        // $( "#empNum" ).autocomplete( "option", "appendTo", ".eventInsForm" );
    });

    $(function () {
        $('#end_date').on('change', function () {
            var end_date = $('#end_date').val();
            document.getElementById("end_date1").value = end_date;
            //alert(end_date);
        });
    });
    function check()
    {
        var start_date = $('#start_date').val();
        var end_date1 = $('#end_date1').val();
        //alert(start_date);

        if (document.getElementById('ts1').checked)
        {
            //alert('test1');
            document.getElementById("end_date").value = start_date;
        } else
        {
            //alert('test2');
            document.getElementById("end_date").value = end_date1;
        }
    }
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <br /><br />
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h2>Apply Leave</h2>
            <br>
            <form action="{{ route('saveLeave') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            {!! Form::label('type', 'Leave Type') !!}
                            <select name="type" class="form-control" id="type">
                                <option value="0">-=Pilih=-</option>
                                @foreach($type as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
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
                            <input class="form-control" type="hidden" name="end_date1" id="end_date1" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="nk-int-st">
                            <?php
                            //$sup = DB::table('emp_reportto')->where('erep_sub_emp_number', $emp->emp_number)->where('erep_reporting_mode', '1')->first();
//                            $cowok = DB::select("
//                                SELECT e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname FROM emp_reportto er INNER JOIN employee e
//                                ON er.erep_sub_emp_number = e.emp_number
//                                WHERE er.erep_sup_emp_number = '" . $sup->erep_sup_emp_number . "' AND er.erep_reporting_mode = '1'
//                                AND e.termination_id IS NULL AND e.emp_number <> '" . $emp->emp_number . "'
//                            ");
                            ?>
                            <label for="emp_incharge">Person In Charge</label>
                            <input class="form-control" type="text" name="empNum" id="empNum" required />
                            <input style="display : none;" class="form-control" type="text" name="emp_incharge" id="emp_incharge" required />
                            {{--                            <select class="form-control" name="emp_incharge">--}}
                            {{--                                <option value="0">-= Perso                            n In Charge =-</option>--}}
{{--                            @                            foreach($cowok as $row)--}}
{{--                                <option value="{{ $row->emp_number }}">{{ $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->e                            mp_lastname }}</option>--}}
{{--                                            @endforeach--}}
{{--                            </select>--}}
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
                            <input id="ts1" type="checkbox" hidden="hidden" name="ts1" onclick="check();">
                            <label for="ts1" class="ts-helper"></label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary pull-right">Request</button>
            </form>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h4>History Entitle</h4>
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Entitlement Type</th>
                                <th>From Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Person In Charge</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($leaves)
                            <?php $no = 1; ?>
                            @foreach($leaves as $leave)
                            <tr>
                                <td>{!! $no !!}</td>
                                <td>{!! $leave->leave_type->name !!}</td>
                                <td>{!! date_formated($leave->from_date) !!}</td>
                                <td>{!! date_formated($leave->end_date) !!}</td>
                                <td>{!! $leave->length_days !!}</td>
                                <td>{!! $leave->leave_stat->name !!}</td>
                                <td>
                                    @if(isset($leave->empInCharge->emp_fullname)) {{ $leave->empInCharge->emp_fullname }} @else - @endif
                                </td>{{-- $leave->empInCharge->emp_firstname --}}
                                <td>{!! $leave->comments !!}</td>
                                <td>@if($leave->leave_status == '3') <a href="{{ route('cancel_Leave', $leave->id) }}"><i class="fa fa-trash" title="Cancel"></i></a> @else <i class="fa fa-trash" title="Cancel"></i> @endif</td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">No Entitle</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection