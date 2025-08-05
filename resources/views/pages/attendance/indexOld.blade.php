@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function(){
        $('#start_date').datetimepicker({
            format: 'Y-m-d H:i:s',
        });$('#end_date').datetimepicker({
            format: 'Y-m-d H:i:s',
        });
        $('#attendance').addClass("active");
        $('#Charts').addClass("in active");
        $(document).on("click", ".open-reqModal", function () {
            var id = $(this).data('id');
            $(".modal-body #leave_id").val( id);
            console.log(id);
            if(id > 0){
                $.ajax({
                    url: '{{ route('getAttLeave') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        $('#start_date').val(data['punch_in_utc_time']);
                        $('#end_date').val(data['punch_out_utc_time']);
                    }
                });
            }
        });
        $('#attend').dataTable( {
            "ordering": false
        } );
    });
</script>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="table-responsive">
                        <a class="btn btn-success open-reqModal" id="editAtt" href="#reqModal" data-toggle="modal" data-id="0">Request</a>
                        <table id="attend" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Day</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Work Time</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($attends)
                                @foreach($attends as $row)
                            <?php
                            $inDate = date('Y-m-d', strtotime($row->punch_in_utc_time));
                            $inTime = date('H:i:s', strtotime($row->punch_in_utc_time));
                            $outTime = date('H:i:s', strtotime($row->punch_out_utc_time));
                            $in = strtotime($row->punch_in_utc_time);
                            $out = strtotime($row->punch_out_utc_time);
                            $workTime  = round(($out - $in) / 3600) - 1;
                            ?>
                            <tr>
                                <td>{{ date('l', strtotime($row->punch_in_utc_time)) }}</td>
                                <td>{{ $inDate }}</td>
                                <td>{{ $inTime }}</td>
                                <td>{{ $outTime }}</td>
                                <td>{{ $workTime }} Hours</td>
                                <td>@if($workTime < 8)
                                        <a id="editAtt" href="#reqModal" data-toggle="modal" class="open-reqModal" data-id="{{ $row->id }}"><i class="fa fa-edit"></i></a>
                                    @else
                                        <i class="fa fa-edit"></i>
                                    @endif
                                </td>
                            </tr>
                                @endforeach
                            @else
                            <tr><td>No Entitlement</td></tr>
                            @endif
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
            <form action="{{ route('setAttLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="leave_id" id="leave_id" />
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input class="form-control" type="text" name="start_date" id="start_date" readonly="readonly" />
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input class="form-control" type="text" name="end_date" id="end_date" readonly="readonly" />
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
            </form>
        </div>
    </div>
</div>
@endsection