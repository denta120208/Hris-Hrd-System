@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#training').DataTable({});
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
            if (id > 0){
            $.ajax({
            url: '{{ route('hrd.getHoliday') }}',
            type: 'get',
                    data: {
                        id:id
                    }
            ,
            dataType: 'json',
                    success:function (data) {
                        $('#id').val(id);
                        $('#date').val(data['date']);
                        $('#description').val(data['description']);
                        $('#recurring').val(data['recurring']);
                        }
            }
            );
            }
        });
        $('#date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#confirm-approve').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $("#recurring option:first-child").attr("disabled", "disabled");
    });

    function PrintElem(elem) {
        $.ajax({
            type: 'get',
            url: "{{ route('hrd.print_training') }}",
            data: {id: elem},
            dataType: "html",
            success: function (result) {
                var mywindow = window.open('', 'my div');
                mywindow.document.write(result);
                mywindow.print();
                mywindow.close();
                return true;
            }
        });
    }
</script>
<div class="container">
    <h2>Training Employee</h2>
    <a class="btn btn-primary open-showModal" data-toggle="modal" href="#new_training">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Training Topik
    </a>
    <a class="btn btn-success open-showModal" data-toggle="modal" href="#new_vendor">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Training Vendor
    </a>
    <div style="margin-bottom: 60px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="training" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Institusion</th>
                                <th>Purpose</th>
                                <th>Cost</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Share Date</th>
                                <th>Sup Approval By</th>
                                <th>Sup Approval At</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($empTrains)
                            @foreach($empTrains as $row)
                            <tr>
                                <td>{{ $row->emp_name->employee_id }}</td>
                                <td>{{ $row->emp_name->emp_firstname.' '.$row->emp_name->emp_middle_name.' '.$row->emp_name->emp_lastname }}</td>
                                <td>{{ $row->train_vendor->vendor_name }}</td>
                                <td>{{ $row->trainning_purpose }}</td>
                                <td>{{ $row->trainning_costs }}</td>
                                <td>{{ $row->trainning_start_date }}</td>
                                <td>{{ $row->trainning_end_date }}</td>
                                <td>{{ $row->trainning_share_date }}</td>
                                <td>{{ $row->approved_sup_by }}</td>
                                <td>{{ $row->approved_sup_at }}</td>
                                @if($row->training_status < '3')
                                <td>
                                    <a id="show" data-href="{{ route('hrd.appTrain', $row->id) }}" data-toggle="modal" data-target="#confirm-approve"><i class="fa fa-check-square" title="Approve"></i></a>
                                </td>
                                <td>
                                    <a id="show" data-href="{{ route('hrd.delTrain', $row->id) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" title="Remove"></i></a>
                                </td>
                                @else
                                <td>
                                    <i class="fa fa-check-square" title="Already Approve"></i>
                                </td>
                                <td>
                                    <i class="fa fa-trash" title="Remove"></i>
                                </td>
                                @endif
                                <td>
                                    <a href="#" onclick="PrintElem({{ $row->id }})"><i class="fa fa-print" title="Print"></i></a>
                                </td>
                            </tr>
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
<div class="modal" id="new_training" tabindex="-1" role="dialog" aria-labelledby="newTrainingLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('hrd.setTrainTopik') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 class="modal-title" id="newTrainingLabel">Add Training Topic</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Training Topic</label>
                        <input class="form-control" type="text" name="name" id="name" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="newVendorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('hrd.setVendorTrain') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 class="modal-title" id="newVendorLabel">Add Institutions</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="vendor_name">Institution Name</label>
                        <input class="form-control" type="text" name="vendor_name" id="vendor_name" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_addr">Institution Address</label>
                        <textarea class="form-control" rows="5" name="vendor_addr" id="vendor_addr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="vendor_tlp">Institution Phone</label>
                        <input class="form-control" type="text" name="vendor_tlp" id="vendor_tlp" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_fax">Institution Fax</label>
                        <input class="form-control" type="text" name="vendor_fax" id="vendor_fax" />
                    </div>
                    <div class="form-group">
                        <label for="vendor_email">Institution Email</label>
                        <input class="form-control" type="text" name="vendor_email" id="vendor_email" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation Approve Training
            </div>
            <div class="modal-body">
                <h1>Are you sure want to <strong>approve</strong> this Training Request?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success btn-ok">Approve</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation Delete Training
            </div>
            <div class="modal-body">
                <h1>Are you sure want to <strong>delete</strong> Training Request?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection