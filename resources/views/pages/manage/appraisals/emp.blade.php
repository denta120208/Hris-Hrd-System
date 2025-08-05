@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
            $(".modal-body #emp_id").val(id);
            if (id > 0) {
                $.ajax({
                    url: '{{ route('hrd.getAssign') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        $('#emp_number').val(data['emp_number']);
                        $('#emp_appraisal_type').val(id);
                        $('#emp_name').val(data['emp_firstname']+' '+data['emp_middle_name']+' '+data['emp_lastname']);
                        $('#appraisal_type_id').val(data['id']);
                        $('#employee_id').val(data['employee_id']);
                    }
                });
            } else {
                $('#employee_id').removeAttr("disabled");
                $('#emp_name').removeAttr("disabled");
            }
        });
        $('#emp_name').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ route('getEmpName') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        emp_name: request.term,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            var d = item.split('/');
                            return {
                                label: d[0] + " - " + d[1],
                                value: d[0],
                                id: d[0],
                                employee_id: d[1],
                                emp_number: d[2]
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                $('#employee_id').val(ui.item.employee_id),
                        $('#emp_number').val(ui.item.emp_number)
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $('#emp_name').autocomplete("option", "appendTo", ".eventInsForm");
        // $('#confirm-delete').on('show.bs.modal', function(e) {
        //     $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        // });
    });
</script>
<div class="container">
    <h2>Employee Apraisal</h2>
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ Session::get('error') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <a class="btn btn-primary open-showModal" id="addEmp" data-toggle="modal" href="#showModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Assign Appraisal
    </a>
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Appraisal Form</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($empApprTypes)
                                <?php $no = 1; ?>
                                @foreach($empApprTypes as $row)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $row->employee_id }}</td>
                                    <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                    <td>{{ $row->code_appraisal }}</td>
                                    <td>
                                        <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $row->id }}"><i class="fa fa-edit" title="Edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="#deleteModal{{ $row->id }}" data-toggle="modal"><i class="fa fa-trash" title="Delete"></i></a>
                                        <div id="deleteModal{{ $row->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Confirmation</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure?</p>
                                                        <p style="color: red;"><b>* Deleting This Data Will Also Delete Appraisal & Evaluator Data!</b></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <a href="/hrd/deleteEmpAppraisal/{{ $row->id }}" class="btn btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                                @endforeach
                                @else
                                <tr><td>No Data</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
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
                <h4 class="modal-title" id="showModal">Assign Appraisal Form</h4>
            </div>
            <form method="post" action="{{ route('hrd.empAssignAdd') }}">
                <div class="modal-body">
                    <input type="hidden" id="emp_number" name="emp_number" />
                    <input type="hidden" id="emp_appraisal_type" name="emp_appraisal_type" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group eventInsForm">
                        <label for="employee_id">NIK</label>
                        <input class="form-control" type="text" name="employee_id" id="employee_id" readonly ="yes" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="emp_name">Full Name</label>
                        <input class="form-control" type="text" name="emp_name" id="emp_name" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <?php $leave = \App\Models\Master\AppraisalType::where('is_active','=',1)->lists('name', 'id')->prepend('-=Appraisal Type=-', '0'); ?>
                        {!! Form::label('appraisal_type_id', 'Appraisal Type') !!}
                        {!! Form::select('appraisal_type_id', $leave, '', ['class' => 'form-control appraisal_type_id', 'id' => 'appraisal_type_id']) !!}
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