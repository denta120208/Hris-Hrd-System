@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
            $(".modal-body #id").val(id);
            if (id > 0) {
                $.ajax({
                    url: '{{ route('hrd.getEvaluator') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $("#id").removeAttr('disabled');
                        $('#employee_id').attr('disabled','disabled');
                $('#emp_name').attr('disabled','disabled');
                $('#employee_id2').attr('disabled','disabled');
                $('#emp_name2').attr('disabled','disabled');
                        $('#emp_number').val(data['emp_number']);
                        $('#emp_appraisal_type').val(id);
//                        $('#emp_name').val(data['sup_name']);
//                        $('#emp_name2').val(data['emp_name']);
                        $('#emp_name').val(data['emp_firstname']+' '+data['emp_middle_name']+' '+data['emp_lastname']);
                        $('#emp_name2').val(data['firstname']+' '+data['middle_name']+' '+data['lastname']);
                        $('#appraisal_type_id').val(data['id']);
                        $('#employee_id').val(data['employee_id']);
                        $('#employee_id2').val(data['employee_id2']);
                        $('#emp_evaluation').val(data['emp_evaluation']);
                        $("#evaluator_status").val(data['evaluator_status']).change();
                    }
                });
            } else {
                $("#id").attr('disabled','disabled');
                $('#employee_id').removeAttr("disabled");
                $('#emp_name').removeAttr("disabled");
                $('#employee_id2').removeAttr("disabled");
                $('#emp_name2').removeAttr("disabled");
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
        $('#emp_name2').autocomplete({
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
                $('#employee_id2').val(ui.item.employee_id),
                        $('#emp_evaluation').val(ui.item.emp_number)
            },
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $('#emp_name2').autocomplete("option", "appendTo", ".eventInsForm");
    });
    
</script>
<div class="container">
    <h2>Evaluator</h2>
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
    <a class="btn btn-primary open-showModal" id="addEvaluator" data-toggle="modal" href="#showModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Evaluator
    </a>
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Evaluator Name</th>
                                <th>Evaluation Name</th>
                                <th>Appraisal Type</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($evaluators)
                            <?php $no = 1; ?>
                            @foreach($evaluators as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                <td>{{ $row->firstname." ".$row->middle_name." ".$row->lastname }}</td>
                                <td>@if($row->evaluator_status == 1) Self Appraisal @elseif($row->evaluator_status == 2) Supperior Appraisal @elseif($row->evaluator_status == 3) Director Appraisal @else Undefined @endif</td>
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $row->id }}" onclick="getId({{$row->id}})"><i class="fa fa-edit" title="Edit"></i></a>
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
                                                    <p style="color: red;"><b>* Deleting This Data Will Also Delete Appraisal Data!</b></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <a href="/hrd/deleteEvaluator/{{ $row->id }}" class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr><td>No Entitlement</td></tr>
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
                <h4 class="modal-title" id="showModal">Appraisal Evaluator</h4>
            </div>
            <form method="post" action="{{ route('hrd.setEvaluator') }}">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" id="emp_number" name="emp_number" />
                    <input type="hidden" id="emp_evaluation" name="emp_evaluation" />
                    <input type="hidden" id="emp_appraisal_type" name="emp_appraisal_type" />
                    <input type="hidden" id="id" name="id" />
                    <div class="form-group eventInsForm">
                        <label for="employee_id">Evaluator NIK</label>
                        <input class="form-control" type="text" name="employee_id" id="employee_id" readonly="yes" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="emp_name">Evaluator Name</label>
                        <input class="form-control" type="text" name="emp_name" id="emp_name" disabled="disabled" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="employee_id">Evaluated NIK</label>
                        <input class="form-control" type="text" name="employee_id2" id="employee_id2" readonly="yes" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="emp_name">Evaluated Name</label>
                        <input class="form-control" type="text" name="emp_name2" id="emp_name2" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="evaluator_status">Appraisal Type</label>
                        <select name="evaluator_status" id="evaluator_status" class="form-control">
                            <option value="2">Supperior Appraisal</option>
                            <option value="3">Director Appraisal</option>
                        </select>
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