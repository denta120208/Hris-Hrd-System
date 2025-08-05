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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('demotion.add') }}" class="btn btn-primary">New Request</a>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="pTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>Emp Number</th>
                    <th>Emp Name</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Approved By</th>
                    <th>Approved At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($requests)
                @foreach($requests as $row)
                <tr>
                    <td>{{ $row->emp_sub->employee_id }}</td>
                    <td>{{ $row->emp_sub->emp_firstname." ".$row->emp_sub->emp_middle_name." ".$row->emp_sub->emp_lastname }}</td>
                    <td>{{ $row->demotion_status->name }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ $row->approved_by }}</td>
                    <td>{{ $row->approved_at }}</td>
                    @if($row->pro_status == '1')
                    <td><a href="#delModal" data-toggle="modal" class="open-delModal" data-id="{{ $row->id }}" id="apv"><i class="fa fa-trash" title="Cancel"></i></a></td>
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
                <h4 class="modal-title" id="delModal">demotion Approval</h4>
            </div>
            <form action="{{ route('delDemotion') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" value="" />
                    <p>Sure want to Cancel this Demotion?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection