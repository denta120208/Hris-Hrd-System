<script type="text/javascript">
    $(document).ready(function () {
        $('#emergencyDtlSave').hide();
        $('#emergencyDtlUpdate').hide();
        $('.editRt').hide();
        $('#addRt').hide();
        $('.deleteButton').hide();
        $('#emergencyDtl').click(function () {
            $('#emergencyDtl').hide();
            $('#emergencyDtlSave').show();
            $('#emergencyDtlUpdate').show();
            $('.editRt').show();
            $('#addRt').show();
            $('.deleteButton').show();
        });
        $('#emergencyDtlUpdate').click(function () {
            $('#emergencyDtl').show();
            $('#emergencyDtlSave').hide();
            $('#emergencyDtlUpdate').hide();
            $('.editRt').hide();
            $('#addRt').hide();
            $('.deleteButton').hide();
        });
        $('#emergencyDtlSave').click(function () {
            $('form#emergencyForm').submit();
        });
        $(document).on("click", ".open-edtModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val($(this).data('id'));
            console.log(id);
            if (id > 0) {
                $.ajax({
                    url: '{{ route('personal.getEmergencyDtl') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $('#eec_name').val(data['eec_name']);
                        $('#eec_relationship').val(data['eec_relationship']);
                        $('#eec_home_no').val(data['eec_home_no']);
                        $('#eec_mobile_no').val(data['eec_mobile_no']);
                        $('#eec_office_no').val(data['eec_office_no']);
                    }
                });
            }
        });
    });
    function deleteConfirmation(e) {
        if (!confirm("Delete dependent?")) {
            e.preventDefault();
        }
    }
</script>
<div class="table-responsive">
    <a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addRt"></i></a>
    <table id="data-table-basic" class="table table-striped">
        <thead>
            <tr>
                <th>Nos</th>
                <th>Name</th>
                <th>Relationship</th>
                <th>Home Telephone</th>
                <th>Mobile</th>
                <th>Work Telephone</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach($eec as $row)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $row->eec_name }}</td>
                <td>{{ $row->eec_relationship }}</td>
                <td>{{ $row->eec_home_no }}</td>
                <td>{{ $row->eec_mobile_no }}</td>
                <td>{{ $row->eec_office_no }}</td>
                <td>
                    <a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="{{ $row->id }}"><i class="fa fa-edit editRt" title="Edit" id="editRt"></i></a>
                    &nbsp;
                    <a onclick="deleteConfirmation(event)" class="deleteButton" id="deleteButton" href="{{ route('personal.deleteEmergency', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a>
                </td>
                <?php $no++; ?>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<button class="btn btn-success" id="emergencyDtl">Edit</button>
<!--<button class="btn btn-primary" id="emergencyDtlSave">Save</button>-->
<button class="btn btn-primary" id="emergencyDtlUpdate">Update Data</button>


<div id="edtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModal">Leave Approval</h4>
            </div>
            <form action="{{ route('personal.setEmergencyDtl') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" value="" />
                    <div class="form-group">
                        <label for="eec_name">Name</label>
                        <input class="form-control" type="text" name="eec_name" id="eec_name" />
                    </div>
                    <div class="form-group">
                        <label for="eec_relationship">Relationship</label>
                        <input class="form-control" type="text" name="eec_relationship" id="eec_relationship" />
                    </div>
                    <div class="form-group">
                        <label for="eec_home_no">Home No</label>
                        <input class="form-control" type="text" name="eec_home_no" id="eec_home_no" />
                    </div>
                    <div class="form-group">
                        <label for="eec_mobile_no">Mobile No</label>
                        <input class="form-control" type="text" name="eec_mobile_no" id="eec_mobile_no" />
                    </div>
                    <div class="form-group">
                        <label for="eec_office_no">Office No</label>
                        <input class="form-control" type="text" name="eec_office_no" id="eec_office_no" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </form>
        </div>
    </div>
</div>