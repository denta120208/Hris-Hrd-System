@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".open-showModal");
        $('#HRDProcessTable').DataTable({
            "ordering": true
        });
    });
    function terminationConfirmation(e) {
        if (!confirm('Do you want to terminate this employee?')) {
            e.preventDefault();
        }
    }
    function hrdApprovalConfirmation(e) {
        if (!confirm('Do you want to approve this termination request?')) {
            e.preventDefault();
        }
    }
    function hrdRejectConfirmation(e) {
        if (!confirm('Do you want to cancel this termination request?')) {
            e.preventDefault();
        }
    }
</script>
<?php
$selectedId = 0;
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <h2>HRD Process</h2>
                <table id="HRDProcessTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Effective Date</th>
                            <th>Reason</th>
                            <th>View File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($termination)
                        <?php $no = 1; ?>
                        @foreach($termination as $key => $row)
                        <?php
                        $fullName = ($row->emp_firstname != null) ? $row->emp_firstname : "";
                        $fullName .= ($row->emp_middle_name != null) ? " " . $row->emp_middle_name : "";
                        $fullName .= ($row->emp_lastname != null) ? " " . $row->emp_lastname : "";

                        $terminationDate = date('d-m-Y', strtotime($row->termination_date));
                        ?>
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $fullName }}</td>
                            <td>{{ $terminationDate }}</td>
                            <td>{{ $row->name }}</td>
                            @if(isset($row->termination_file_name))
                            <td>
                                <a href="/hrd/HrdProcess/download/{{$row->id}}">{{$row->termination_file_name}}</a>
                            </td>
                            @else
                            <td>-</td>
                            @endif
                            @if($row->status == 2)
                            <td style="display: flex">
                                <form id="approveTermination" action="/hrd/HrdProcess/approve/{{$row->id}}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <button type="submit" onclick="hrdApprovalConfirmation(event)" class="btn btn-success">Approve</button>
                                </form>
                                &nbsp;
                                <form id="rejectTermination" action="/hrd/HrdProcess/reject/{{$row->id}}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <button type="submit" onclick="hrdRejectConfirmation(event)" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                            @else
                            <td>
                                @if($row->is_upload == 0)
                                <a href="#showModal" data-toggle="modal" class="btn btn-primary show-modal" onclick="{{$selectedId = $row->id}}">Upload</a>
                                @else
                                <form id="Termination" action="/hrd/HrdProcess/terminate/{{$row->id}}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="emp_number" value="{{$row->emp_number}}" />
                                    <button type="submit" onclick="terminationConfirmation(event)" class="btn btn-danger">Terminate</button>
                                </form>
                                @endif
                            </td>
                            @endif
                        </tr>
                        <?php $no++; ?>
                        @endforeach
                        @else
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog modal-xtra-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Upload File</h4>
            </div>
            <div class="modal-body">
                <form id="uploadFile" action="/hrd/HrdProcess/upload/{{$selectedId}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="termination_date">File</label>
                        <input class="form-control" type="file" name="form_exit_interview" id="form_exit_interview" accept="application/pdf" required/>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection