@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#table-list-approve').dataTable();
        $('#sTrain_date').datetimepicker({
            format: 'Y-m-d H:i:s'
        });
        $('#eTrain_date').datetimepicker({
            format: 'Y-m-d H:i:s'
        });
        // $('#activeClass ul li').addClass($('addClasses').val());
        $("#train_id").change(function () {
            var id = $(this).val();
            $.ajax({
                url: '{{ route('getVendorTrain') }}',
                type: 'get',
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $('#vendor_id').html(data['html']);
                }
            });
            $('#training_id').val(id);
        });
        $('#confirm-approve').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>List Approve</h2>
                    <table id="table-list-approve" class="table table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Requested By</th>
                                <th>Training Topic</th>
                                <th>Training Institutions</th>
                                <th>Training Date</th>
                                <th>Training Shared</th>
                                <th>Approve Supervisor</th> <!-- Date Approve Sup -->
                                <th>Approve HR</th> <!-- Date Approve HRD -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($trainList)
                            <?php $no = 1; ?>
                            @foreach($trainList as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->vendor_name }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->trainning_start_date))." s/d ".date('d-m-Y', strtotime($row->trainning_end_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->trainning_share_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->approved_sup_at)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($row->approved_hr_at)) }}</td>
                                <td>@if($row->training_status == '1')
                                    <a id="show" data-href="{{ route('hrd.appTrain', $row->id) }}" data-toggle="modal" data-target="#confirm-approve"><i class="fa fa-check-square" title="Approve"></i></a>
                                    @else
                                    <i class="fa fa-check-square" title="Approve"></i>
                                    @endif
                                </td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
<!--                            <tr>
                                <td colspan="9">No Data</td>
                            </tr>-->
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
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
@endsection