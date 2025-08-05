<script type="text/javascript">
    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function deleteConfirmation(e) {
        if (!confirm("Delete dependent?")) {
            e.preventDefault();
        }
    }

    $(document).ready(function () {
        $('#addDependents').hide();
        $('#depenDtlSave').hide();
        $('#depenDtlCancel').hide();
        $('.editButton').hide();
        $('.deleteButton').hide();
        $('#ed_date_of_birth').datetimepicker({
            format: 'Y-m-d',
        });
        $('#ed_date_of_birth_edit').datetimepicker({
            format: 'Y-m-d',
        });
        $('#editDtl').click(function () {
            $('#addDependents').show();
            $('#editDtl').hide();
            $('#depenDtlSave').show();
            $('#depenDtlCancel').show();
            $('.editButton').show();
            $('.deleteButton').show();
        });
        $('#depenDtlCancel').click(function () {
            $('#addDependents').hide();
            $('#editDtl').show();
            $('#depenDtlSave').hide();
            $('#depenDtlCancel').hide();
            $('.editButton').hide();
            $('.deleteButton').hide();
        });
        $('#depenDtlSave').click(function () {
            $('form#addDependents').submit();
        });
        $(document).on("click", ".open-edtModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val($(this).data('id'));
            console.log(id);
            if (id > 0) {
                $.ajax({
                    url: '{{ route('personal.getDependentsDtl') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $('#ed_name_edit').val(data['ed_name']);
                        $('#ed_relationship_edit').val(data['ed_relationship']).change();
                        $('#ed_date_of_birth_edit').val(formatDate(data['ed_date_of_birth']));
                    }
                });
            }
        });
    });
</script>
<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<form id="addDependents" action="{{ route('personal.setDependent') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="form-group">
        <label for="ed_name">Name</label>
        <input class="form-control" type="text" name="ed_name" id="ed_name" />
    </div>
    <div class="form-group">
        <label for="ed_relationship">Relationship</label>
        <select class="form-control" name="ed_relationship" id="ed_relationship">
            <option value="">-= Select =-</option>
            <option value="Spouse">Spouse</option>
            <option value="Child">Child</option>
        </select>
    </div>
    <div class="form-group">
        <label for="ed_date_of_birth">Date Of Birth</label>
        <input class="form-control" type="text" name="ed_date_of_birth" id="ed_date_of_birth" readonly="readonly" />
    </div>
    <input type="submit" class="btn btn-primary" id="depenDtlSave" value="Save">
    <input type="reset" class="btn btn-danger" id="depenDtlCancel" value="Cancel">
</form>
<div class="table-responsive">
    <table id="data-table-basic" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Relationship</th>
                <th>Date Of Birth</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($eds)
            <?php $no = 1; ?>
            @foreach($eds as $row)
            <?php 
                $date_of_birth = date_formated($row->ed_date_of_birth); 
//                dd(date_formated($row->ed_date_of_birth));
            ?>
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $row->ed_name }}</td>
                <td>{{ $row->ed_relationship }}</td>
                @if($date_of_birth == '01-01-1970' || $date_of_birth == '01-01-1900')
                <td></td>
                @else
                <td><?php echo date_formated($row->ed_date_of_birth); ?></td>
                @endif
                <td>
                    <a id="editButton" href="#edtModal" data-toggle="modal" class="open-edtModal editButton" data-id="{{ $row->id }}"><i class="fa fa-edit editRt" title="Edit" id="editRt"></i></a>
                    &nbsp;
                    <a onclick="deleteConfirmation(event)" id="deleteButton" class="deleteButton" href="{{ route('personal.deleteDependent', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a>

                </td>
            </tr>
            <?php $no++; ?>
            @endforeach
            @else
            <tr><td colspan="4">No Dependents</td></tr>
            @endif
        </tbody>
    </table>
    <button class="btn btn-success" id="editDtl">Edit</button>
</div>

<div id="edtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModal">Leave Approval</h4>
            </div>
            <form action="{{ route('personal.setDependentsDtl') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" value="" />
                    <div class="form-group">
                        <label for="ed_name">Name</label>
                        <input class="form-control" type="text" name="ed_name_edit" id="ed_name_edit" />
                    </div>
                    <div class="form-group">
                        <label for="ed_relationship">Relationship</label>
                        <select class="form-control" name="ed_relationship_edit" id="ed_relationship_edit">
                            <option value="">-= Select =-</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Child">Child</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ed_date_of_birth">Date Of Birth</label>
                        <input class="form-control" type="text" name="ed_date_of_birth_edit" id="ed_date_of_birth_edit" readonly="readonly" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>