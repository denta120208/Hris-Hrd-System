@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#start_date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#end_date').datetimepicker({
            format: 'Y-m-d',
        });
//        $('#attendance').addClass("active");
//        $('#Charts').addClass("in active");
//        $(document).on("click", ".open-reqModal", function () {
//            var id = $(this).data('id');
//            var emp_id = {{ Session::get('username') }};
//            //alert(id);
//            $(".modal-body #leave_id").val( id);
//            console.log(emp_id);
//            if(id !== 0){
//                $.ajax({
//                    url: '{{ route('getAttLeave') }}',
//                    type: 'get',
//                    data: {id:id, emp_id: emp_id },
//                    dataType: 'json',
//                    success:function(data){
//                        alert(data['punch_in_utc_time']);
//                        $('#start_date').val('2023-03-01 00:00:00');
//                        //$('#start_date').val(data['punch_in_utc_time']);
//                        $('#end_date').val(data['punch_out_utc_time']);
//                    }
//                });
//            }
//        });
        $('#attend').dataTable({
            "ordering": false
        });
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>In/Out Employee</h2>
                    <a class="btn btn-success open-reqModal" id="editAtt" href="#reqModal" data-toggle="modal" data-id="0">
                        Request Attendance
                    </a>
                    <table id="attend" class="table table-striped">
                        <thead>
                            <tr>
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
                            @foreach($attend as $row)
                            <?php
                            $inDate = date('d-m-Y', strtotime($row->comDate));
                            $inTime = date('H:i:s', strtotime($row->comIn));
                            $outTime = date('H:i:s', strtotime($row->comOut));
                            $totalHours = $row->comTotalHours;
                            $totalHoursOver = $row->comTotalHoursOver;
                            $day = date('D', strtotime($row->comDate));

                            //dd($row->comIn);

                            $workTime = $row->workTime;
                            ?>
                            <tr>
                                <td>{{ date('l', strtotime($row->comDate)) }}</td>
                                <td>{{ $inDate }}</td>
                                <td>{{ $inTime }}</td>
                                <td>{{ $outTime }}</td>
                                @if($day == 'Sat' || $day == 'Sun')
                                    <td>{{ $totalHoursOver }}</td>
                                @else
                                    <td>{{ $totalHours }}</td>
                                @endif
                                <td>{{ $row->comIjin }}</td>
                                <td>
                                    @if($row->job_title_code <= 4 && $row->is_claim_ot == 0 && ($day == 'Sat' || $day == 'Sun'))
                                    <a href="javascript:void(0)" onclick="overAttd('<?php echo $row->comDate ?>', '<?php echo $row->id ?>')">
                                        <i class="fa fa-clock-o"></i>
                                    </a>
                                    @else
                                        @if($workTime < 8 && $row->comIjin == '')
                                        <a href="javascript:void(0)" onclick="reqAttd('<?php echo $row->comDate ?>', '<?php echo $row->id ?>')">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @elseif($workTime > 8 && $row->is_claim_ot == 0 && $row->job_title_code <= 4)
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
                <h4 class="modal-title" id="reqModal">Leave Permission</h4>
            </div>
            <form action="{{ route('setAttLeaveWithoutAttend') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="leave_id_1" id="leave_id_1" value="0" />
                    <div class="form-group">
                        <label for="start_date">Date<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="start_date" id="start_date" readonly="readonly" />
                        <input class="form-control" type="hidden" name="end_date" id="end_date" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">Attendance Type<span style="color: red;">*</span></label>
                        <select class="form-control" name="comijin">
                            <option value="">Not Define</option>
                            @foreach($comijin as $ijin)
                            <option value="{{$ijin->comIjin}}">{{$ijin->keterangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason<span style="color: red;">*</span></label>
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
            <form action="{{ route('setAttLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="leave_id" id="leave_id" />
                    <div class="form-group">
                        <label for="start_date">Date<span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="start_date" id="start_date1" readonly="readonly" />
                        <input class="form-control" type="hidden" name="end_date" id="end_date1" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">Attendance Type<span style="color: red;">*</span></label>
                        <select class="form-control" name="comijin">
                            <option value="">Not Define</option>
                            @foreach($comijin as $ijin)
                            <option value="{{$ijin->comIjin}}">{{$ijin->keterangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason<span style="color: red;">*</span></label>
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

<div id="reqModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="reqModal">Attendance Request</h4>
            </div>
            <form action="{{ route('overtimeRequest.add') }}" method="POST">
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

    function reqAttd(TGL_ATTD, LEAVE_ID) {
        $("#start_date1").val(TGL_ATTD);
        $("#end_date1").val(TGL_ATTD);
        $("#leave_id").val(LEAVE_ID);
        $('#reqModal1').modal('show');
    }

    function overAttd(TGL_ATTD, LEAVE_ID) {
        $("#attend_id").val(LEAVE_ID);
        $("#ot_date").val(TGL_ATTD);
        $('#reqModal2').modal('show');
    }
</script>
@endsection