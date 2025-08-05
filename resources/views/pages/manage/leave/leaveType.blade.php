@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#leaveType').DataTable({
//            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'portrait',
                    pageSize: 'A4'
                },
                {
                    extend: 'print'
                }
            ]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
//    $('#leaveType').DataTable({});

    $(document).on("click", ".open-showModal", function () {
        var id = $(this).data('id');
        var comIjin = $(this).data('comijin');  
        var name = $(this).data('extra');
        
        //alert(comIjin);  

        if (id.toString().length > 0 && name.toString().length > 0) {
            $('#id').val(id);
            $('#name').val(name);
            $('#comIjin').val(comIjin);
        }
    });

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>
<div class="container">
    <h2>Leave Type</h2>
    <a class="btn btn-primary open-showModal" id="addEmp" data-toggle="modal" href="#showModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Leave Type
    </a>
    <div style="margin-bottom: 60px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="leaveType" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($leaveTypes)
                            <?php $no = 1; ?>
                            @foreach($leaveTypes as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->comIjin }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $row->id }}" data-extra="{{ $row->name }}" data-comIjin="{{ $row->comIjin }}"><i class="fa fa-edit" title="Edit"></i></a>
                                </td>
                                <td>
                                    <a id="show" data-toggle="modal" data-target="#confirm-delete{{ $row->id }}"><i class="fa fa-trash" title="Remove"></i></a>
                                    <div class="modal fade" id="confirm-delete{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    Confirmation
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure want to delete this leave type?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <a class="btn btn-danger btn-ok" href="{{ route('hrd.delLeaveType', $row->id) }}">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No data</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Leave Type</h4>
            </div>
            <form method="post" action="{{ route('hrd.setLeaveType') }}">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="name">Code</label>
                        <input class="form-control" type="text" name="comIjin" id="comIjin" />
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name" />
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