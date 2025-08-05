@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#leave').addClass("active");
        $('#mailbox').addClass("in active");
        $(document).on("click", ".open-apvModal", function () {
            $(".modal-body #leave_id").val($(this).data('id'));
        });
    });
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <br /><br />
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h4>Requested Leave</h4>
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Days</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @if($leaves)
                            @foreach($leaves as $leave)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $leave->emp_firstname.' '.$leave->emp_middle_name.' '.$leave->emp_lastname }}</td>
                                <td>{{ $leave->length_days }}</td>
                                <td>{{ date("d-m-Y", strtotime($leave->from_date)) }}</td>
                                <td>{{ date("d-m-Y", strtotime($leave->end_date)) }}</td>
                                <?php $status = \App\Models\Leave\LeaveStatus::where('id', $leave->leave_status)->first(); ?>
                                <td>{{ $status->name }}</td>
                                @if($leave->leave_status == '3')
                                <td><a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="{{ $leave->id }}" id="apv"><i class="fa fa-check-circle" title="Approve"></i></a></td>
                                @else
                                <td><i class="fa fa-check-circle"></i></td>
                                @endif
                            </tr>
                            <?php $no++; ?>
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
    </div>
</div>
<div id="apvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="apvModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="apvModal">Leave Approval</h4>
            </div>
            <form action="{{ route('hrd.setAppLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="leave_id" id="leave_id" value="" />
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="leave_status">Comments</label>
                            <select class="form-control" name="leave_status" id="leave_status">
                                <option value="">-=Pilih=-</option>
                                <option value="1">Reject</option>
                                <option value="4">Approve</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" rows="5" name="comments"></textarea>
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