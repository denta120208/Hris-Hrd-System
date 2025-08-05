@extends('_main_layout')

@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on("click", ".open-apvModal", function () {
                $(".modal-body #ot_id").val( $(this).data('id') );
            });
        });
    </script>
    <div class="container">
        <input type="hidden" id="addClasses" value="active" />
        <div class="row">
            <br /><br />
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Approve Over Time</h4>
                <table id="data-table-basic" class="table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee Name</th>
                        <th>Requested Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    @if($overTimes)
                        @foreach($overTimes as $overTime)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $overTime->emp_firstname.' '.$overTime->emp_middle_name.' '.$overTime->emp_lastname }}</td>
                                <td>{{ $overTime->ot_date }}</td>
                                <td>{{ date("H:i:s", strtotime($overTime->ot_start_time)) }}</td>
                                <td>{{ date("H:i:s", strtotime($overTime->ot_end_time)) }}</td>
                                <?php $status = \App\Models\OverTime\NotificationStatus::where('id', $overTime->ot_status)->first();?>
                                <td>{{ $status->name }}</td>
                                @if($overTime->ot_status == '1')
                                    <td><a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="{{ $overTime->id }}" id="apv"><i class="fa fa-check-circle" title="Approve"></i></a></td>
                                @else
                                    <td><i class="fa fa-check-circle"></i></td>
                                @endif
                            </tr>
                            <?php $no++;?>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No Requested Leave</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="apvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="apvModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 class="modal-title" id="apvModal">OverTime Approval</h4>
                </div>
                <form action="{{ route('setOverTime') }}" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" id="ot_id" value="" />
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="ot_status">Status OverTime</label>
                                <select class="form-control" name="ot_status" id="ot_status">
                                    <option value="">-=Pilih=-</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="nk-int-st">
                                <label for="ot_reason">Comments</label>
                                <textarea class="form-control" rows="5" name="ot_reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection