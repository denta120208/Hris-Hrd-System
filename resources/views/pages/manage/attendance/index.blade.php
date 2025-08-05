@extends('_main_layout')

@section('content')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({});
        $('#date_filter').datetimepicker({
            format: 'Y-m-d',
        });
        $('#attend').dataTable({
            "ordering": false
        });
    });
    $(function () {
        $('#empNum').autocomplete({
            appendTo: "#reqModal",
            source: function (request, response) {
                //alert(request.term);
                $.ajax({
                    url: "{{ route('hrd.find_emp') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        q: request.term,
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
                $('#emp_number').val(ui.item.id)
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
        $('#date').datepicker();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            format: 'Y-m-d',
            timepicker: false,
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
        <h2>In/Out</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.inout_search_emp') }}" method="post" class="form-inline">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="start_date">Start Date*</label><br>
                        <input class="form-control" type="text" name="start_date" id="start_date" autocomplete="off" readonly="yes" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date*</label><br>
                        <input class="form-control" type="text" name="end_date" id="end_date" autocomplete="off" readonly="yes"/>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label><br>
                        <input class="form-control" type="text" name="comDisplayName" id="comDisplayName" placeholder="Employee Name" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label for="comNIP">NIK</label><br>
                        <input class="form-control" type="text" name="comNIP" id="comNIP" placeholder="0101001" autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Project</label><br>
                        <?php
                        if (session("project") == "HO" && Session::get('username') <> 'hrd_busdev') { // Jika Kantor Pusat Maka Semua Project Kebuka
                            $project = \App\Models\Master\Location::where('is_active', '=', 1)
                                    ->orderBy('name', 'ASC')
                                    ->lists('name', 'id')
//                                    ->prepend('-=Pilih=-', '0')
                                    ->prepend('All Project', '0');
                        } else {
                            $project = \App\Models\Master\Location::where("code", session("project"))->lists('name', 'id');
                        }

                        // $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                        ?>
                        {!! Form::label('comProjectID', 'Project', ['class'=>'sr-only']) !!}
                        {!! Form::select('comProjectID', $project, '', ['class' => 'form-control', 'id' => 'project']) !!}
                    </div>
                    <div class="form-group pull-right" style="margin-right:55px;">
                        <label style="visibility: hidden;">action</label><br>
                        <button class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            $no = 1;
            $currentEmpNumber = 0;
            ?>
            <div class="data-table-list">
                <div class="table-responsive">

                    <a class="btn btn-success open-reqModal" id="editAtt" href="#reqModal" data-toggle="modal" data-id="0">
                        Attendance Request
                    </a>
                    <br><br>
                    <table id="attend" class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Work Time</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attR as $row)
                            <?php
                            $inDate = date('d-m-Y', strtotime($row->comDate));
                            $inTime = date('H:i:s', strtotime($row->comIn));
                            $outTime = date('H:i:s', strtotime($row->comOut));
                            $day = date('D', strtotime($row->comDate));

                            //dd($row->comIn);
                            $workTimeOver = $row->workTimeOver;
                            $workTime = $row->workTime;
                            ?>
                            <tr>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ date('l', strtotime($row->comDate)) }}</td>
                                <td>{{ $inDate }}</td>
                                <td>{{ $inTime }}</td>
                                <td>{{ $outTime }}</td>
                                @if($day == 'Sat' || $day == 'Sun')
                                <td>{{ $workTimeOver }} Hours</td>
                                @else
                                <td>{{ $workTime }} Hours</td>
                                @endif
                                <td>{{ $row->comIjin }}</td>
                                <td>
                                    @if($row->job_title_code <= 4 && ($day == 'Sat' || $day == 'Sun') && $row->is_claim_ot == 0)
                                    <a href="javascript:void(0)" onclick="overAttd('<?php echo $row->comDate ?>', '<?php echo $row->id ?>')">
                                        <i class="fa fa-clock-o"></i>
                                    </a>
                                    @else
                                    @if($workTime < 8 && $row->comIjin == '')
                                    <a href="javascript:void(0)" onclick="reqAttd('<?php echo $row->comDate ?>', '<?php echo $row->id ?>', '<?php echo $row->emp_number ?>', '<?php echo $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname . ' - ' . $row->employee_id ?>');">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @elseif($workTime > 8 && $row->is_claim_ot == 0 && $row->job_title_code <= 4 )
                                    <a href="javascript:void(0)" onclick="overAttd('<?php echo $row->comDate ?>', '<?php echo $row->id ?>')">
                                        <i class="fa fa-clock-o"></i>
                                    </a>
                                    @else
                                    -
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal">Attendance Request</h4>
            </div>
            <form action="{{ route('hrd.setAttLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="leave_id" id="leave_id" value="0" />
                    <div class="form-group">
                        <div class="">

                            <label for="emp_incharge">Employee <span style="color: red;">*</span></label>
                            <input class="form-control" type="text" name="empNum" id="empNum" required="true" />
                            <input class="form-control" type="hidden" name="emp_number" id="emp_number" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date">Date <span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="date" id="date"/>
                        <input class="form-control" type="hidden" name="end_date" id="end_date" readonly="readonly" required="true"/>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Attendance Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="comijin">
                            <option value="">Not Define</option>
                            @foreach($comijin as $ijin)
                            <option value="{{$ijin->comIjin}}">{{$ijin->keterangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason <span style="color: red;">*</span></label>
                        <textarea class="form-control" rows="5" name="reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="reqModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal1">Attendance Request</h4>
            </div>
            <form action="{{ route('hrd.appAttLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="attendance_id" id="attendance_id" />
                    <input type="hidden" name="employee_number" id="employee_number" />
                    <div class="form-group">
                        <div class="">
                            <label for="emp_incharge">Employee <span style="color: red;">*</span></label>
                            <input class="form-control" type="text" name="emp_name" id="emp_name" disabled="true" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Date <span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="start_date" id="start_date1" readonly="readonly"/>
                        <input class="form-control" type="hidden" name="end_date" id="end_date1" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">Attendance Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="comijin">
                            <option value="">Not Define</option>
                            @foreach($comijin as $ijin)
                            <option value="{{$ijin->comIjin}}">{{$ijin->keterangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason <span style="color: red;">*</span></label>
                        <textarea class="form-control" rows="5" name="reason" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="reqModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal">Attendance Request</h4>
            </div>
            <form action="{{ route('hrd.overtime.add') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="attend_id" id="attend_id" />
                <input type="hidden" name="ot_date" id="ot_date" readonly="readonly" />
                <div class="form-group">
                    <div class="date nk-int-st">
                        <label style="margin-left: 20px;">Do you want create overtime request?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
                <!--                <button class="btn btn-primary pull-right">Request</button>-->
            </form>

            <!--            <form action="{{ route('setAttLeave') }}" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="leave_id" id="leave_id" />
                                <div class="form-group">
                                    <label for="start_date">Date</label>
                                    <input class="form-control" type="text" name="start_date" id="start_date1" readonly="readonly" />
                                    <input class="form-control" type="hidden" name="end_date" id="end_date1" readonly="readonly" />
                                </div>
                                <div class="form-group">
                                    <label for="end_date">Attendance Type</label>
                                    <select class="form-control" name="comijin">
                                        <option value=" ">Not Define</option>
                                        @foreach($comijin as $ijin)
                                            <option value="{{$ijin->comIjin}}">{{$ijin->keterangan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" rows="5" name="reason"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>-->
        </div>
    </div>
</div>

<script>
//    $(function() {
//        $('#UTILS_METER_TYPE_EDIT').select2();
//    });

    function reqAttd(TGL_ATTD, ATTENDANCE_ID, EMP_NUMBER, EMPLOYEE) {
        $("#start_date1").val(TGL_ATTD);
        $("#end_date1").val(TGL_ATTD);
        $("#attendance_id").val(ATTENDANCE_ID);
        $("#employee_number").val(EMP_NUMBER);
        $("#emp_name").val(EMPLOYEE);
        $('#reqModal1').modal('show');
    }
    
    function overAttd(TGL_ATTD, LEAVE_ID) {
        $("#attend_id").val(LEAVE_ID);
        $("#ot_date").val(TGL_ATTD);
        $('#reqModal2').modal('show');
    }
</script>

@endsection