@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#table-training-request').dataTable();
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
    });
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <div class="data-table-list">
            <div class="table-responsive">
                <h2>Trainning History</h2>
                <table id="data-table-basic" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Trainning Name</th>
                            <th>Certificate No</th>
                            <th>Certificate Date</th>
                            <th>Certificate Expiried</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($trains)
                        <?php $no = 1; ?>
                        @foreach($trains as $train)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $train->trainning->name }}</td>
                            <td>{{ $train->license_no }}</td>
                            <td>{{ date('d-m-Y', strtotime($train->license_issued_date)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($train->license_expiry_date)) }}</td>
                            <?php $no++; ?>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="5">No Data</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br /><br />
    <div class="row">
        <div class="data-table-list">
            <div class="table-responsive">
                <h2>Trainning Requested</h2>
                <table id="table-training-request" class="table table-striped" >
                    <thead>
                        <tr>
                            <th>No</th>
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
                            <td>{{ $row->training_name->name }}</td>
                            <td>{{ $row->institutions_name->vendor_name }}</td>
                            <td>{{ $row->trainning_start_date." s/d ".$row->trainning_end_date }}</td>
                            <td>{{ $row->trainning_share_date }}</td>
                            <td>{{ $row->approved_sup_at }}</td>
                            <td>{{ $row->approved_hr_at }}</td>
                            <td>@if($row->training_status == '1')
                                <a><i class="fa fa-edit" title="Edit"></i></a>
                                @else
                                <i class="fa fa-edit" title="Edit"></i>
                                @endif
                            </td>
                        </tr>
                        <?php $no++; ?>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8">No Data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal" id="new_vendor" tabindex="-1" role="dialog" aria-labelledby="newVendorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('setVendorTrain') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="training_id" id="training_id" />
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
@endsection