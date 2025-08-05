@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#pTable').DataTable({ });
    $(document).on("click", ".open-delModal", function () {
        $(".modal-body #id").val( $(this).data('id') );
    });
});
</script>
<div class="container">
    <div class="row">
        <h3>Punishment Approval</h3>
        <br>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="pTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Punishment Type</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Req. Date</th>
                    <th>Cancel</th>
                    <th>Approve</th>
                </tr>
                </thead>
                <tbody>
                @if($reqAppr)
                @foreach($reqAppr as $row)
                <tr>
                    <td>{{ $row->employee_id }}</td>
                    <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                    <td>{{ $row->punish_type }}</td>
                    <td>{{ $row->punish_reason }}</td>
                    <td>{{ $row->punish_status_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    @if($row->punish_status == '1')
                    <td class="center">
                        <a href="#delpunish{!!$row->id!!}" data-toggle="modal">
                            <i class="fa fa-trash" title="Cancel"></i>
                        </a>
                        <div id="delpunish{!!$row->id!!}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">  
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>Are you sure cancel this document ?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                        <a href="{{ URL('/delStsp/'.$row->id) }}" class="btn btn-success">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="center">
                        <a href="#approvepunish{!!$row->id!!}" data-toggle="modal">
                            <i class="fa fa-check-circle" title="Cancel"></i>
                        </a>
                        <div id="approvepunish{!!$row->id!!}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">  
                                        <h4 class="modal-title">Confirmation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>    
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>Are you sure approve this document ?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                        <a href="{{ URL('/apprStsp/'.$row->id) }}" class="btn btn-success">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    @else
                    <td><i class="fa fa-trash" title="Cancel"></i></td>
                    @endif
                </tr>
                @endforeach
                @else
                <tr>
                    <td></td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection