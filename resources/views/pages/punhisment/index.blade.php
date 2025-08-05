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
        <h3>Punishment</h3>
        <br>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('stsp.add') }}" class="btn btn-primary">New Request</a>
        </div>
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($requests)
                @foreach($requests as $row)
                <tr>
                    <td>{{ $row->emp_sub->employee_id }}</td>
                    <td>{{ $row->emp_sub->emp_firstname." ".$row->emp_sub->emp_middle_name." ".$row->emp_sub->emp_lastname }}</td>
                    <td>{{ $row->punishment_type->name }}</td>
                    <td>{{ $row->punish_reason }}</td>
                    <td>{{ $row->punishment_status->name }}</td>
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
<div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="delModal">Punishment</h4>
            </div>
            <form action="{{ route('delStsp') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="text" name="id" id="id" value="{{$row->id}}" />
                    <p>Are you sure cancel this document?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection