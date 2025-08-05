@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {

        $('#terminationApprovalTable').dataTable({
            "ordering": true
        });
    });
    function terminationApprovalConfirmation(e) {
        if (!confirm('Do you want to approve this termination request?')) {
            e.preventDefault();
        }
    }
    function terminationRejectConfirmation(e) {
        if (!confirm('Do you want to cancel this termination request?')) {
            e.preventDefault();
        }
    }
</script>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Termination Approval</h2>
                    <!--                        <a class="btn btn-success open-reqModal" id="editAtt" href="#reqModal" data-toggle="modal" data-id="0">Request</a>-->
                    <table id="terminationApprovalTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Effective Date</th>
                                <th>Reason</th>
                                <th>Approve</th>
                                <th>Cancel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($termination as $key => $row)
                            <?php
                            $fullName = ($row->emp_firstname != null) ? $row->emp_firstname : "";
                            $fullName .= ($row->emp_middle_name != null) ? " " . $row->emp_middle_name : "";
                            $fullName .= ($row->emp_lastname != null) ? " " . $row->emp_lastname : "";

                            $terminationDate = date('d-m-Y', strtotime($row->termination_date));
                            ?>
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $fullName }}</td>
                                <td>{{ $terminationDate }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    <form id="approveTermination" action="/terminationApproval/approve/{{$row->id}}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <button type="submit" onclick="terminationApprovalConfirmation(event)" class="btn btn-success">Approve</button>
                                    </form>
                                </td>
                                <td>
                                    <form id="rejectTermination" action="/terminationApproval/reject/{{$row->id}}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <button type="submit" onclick="terminationRejectConfirmation(event)" class="btn btn-danger">Reject</button>
                                    </form>
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
<!--<div id="reqModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reqModal" aria-hidden="true">
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
</div>-->




@endsection