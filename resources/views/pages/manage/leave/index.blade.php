@extends('_main_layout')

@section('content')
<script type="text/css">
    .ui-autocomplete-input {
        border: none;
        font-size: 14px;
        width: 300px;
        height: 24px;
        margin-bottom: 5px;
        padding-top: 2px;
        border: 1px solid #DDD !important;
        padding-top: 0px !important;
        z-index: 1511;
        position: relative;
    }
    .ui-menu .ui-menu-item a {
        font-size: 12px;
    }
    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1510 !important;
        float: left;
        display: none;
        min-width: 160px;
        width: 160px;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }
    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }
    #addDtlVOC{
        width: 500px;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
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
    $(document).ready(function(){
//    $('#empTable').DataTable({ });
    $(document).on("click", ".open-showModal", function () {
    var id = $(this).data('id');
    var leave_id = $(this).data('extra');
    $(".modal-body #emp_id").val(id);
    $(".modal-body #leave_id").val(leave_id);
    if (id > 0 && leave_id > 0){
    $.ajax({
    url: '{{ route('hrd.getLeaveEmp') }}',
            type: 'get',
            data: {emp_number:id, leave_id:leave_id},
            dataType: 'json',
            success:function(data){
            var name = data['emp_firstname'] + ' ' + data['emp_middle_name'] + ' ' + data['emp_lastname'];
            var leave_type_id = data['leave_type_id'];
            $('#employee_id').val(data['employee_id']);
            $('#emp_name').val(name);
            // $("#leave_type_id option[value=leave_type_id]").prop('selected', true);
            $('.leave_type_id').val(data['leave_type_id']).prop('selected', true);
            $('#no_of_days').val(data['no_of_days']);
            $('#to_date').val(data['to_date']);
            $('#from_date').val(data['from_date']);
            $('#days_used').val(data['days_used']);
            }
    });
    } else{
    $('#employee_id').removeAttr("disabled");
    $('#emp_name').removeAttr("disabled");
    }
    });
    $('#from_date').datetimepicker({
    format: 'Y-m-d',
    });
    $('#to_date').datetimepicker({
    format: 'Y-m-d',
    });
    $('#emp_name').autocomplete({
    source: function(request, response) {
    $.ajax({
    url: "{{ route('getEmpName') }}",
            dataType: "json",
            type: "POST",
            data: {
            emp_name: request.term,
                    _token: "{{ csrf_token() }}"
            },
            success: function(data) {
            response($.map(data, function(item) {
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
            select: function(event, ui) {
            $('#employee_idL').val(ui.item.employee_id),
                    $('#emp_id').val(ui.item.emp_number)
            },
            open: function() {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
    });
    $('#emp_name').autocomplete("option", "appendTo", ".eventInsForm");
    $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $(document).on("click", ".open-dedModal", function () {
    var id = $(this).data('id');
    var leave_id = $(this).data('extra');
    $.ajax({
    url: '{{ route('hrd.getLeaveEmp') }}',
            type: 'get',
            data: {emp_number:id, leave_id:leave_id},
            dataType: 'json',
            success:function(data){
            var name = data['emp_firstname'] + ' ' + data['emp_middle_name'] + ' ' + data['emp_lastname'];
            $('#employee_idDed').val(data['employee_id']);
            $('#emp_nameDed').val(name);
            $('#leave_idDed').val(leave_id);
            $('#no_of_daysDed').val(data['no_of_days']);
            $('#days_usedDed').val(data['days_used']);
            $('#emp_idDed').val(id);
            $('#leave_nameDed').val(data['name']);
            }
    });
    });
    });
</script>
<div class="container">
    <h2>Leave Employee</h2>
    <a class="btn btn-primary open-showModal" id="addEmp" data-toggle="modal" href="#showModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Leave
    </a>
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="data-table-list">
            <div class="table-responsive">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="{{ route('hrd.searchLeave') }}" method="post" class ="form-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="empName" class="sr-only">Name</label>
                            <input class="form-control" type="text" name="empName" id="empName" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="employee_id" class="sr-only">NIK</label>
                            <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" />
                        </div>
                        <div class="form-group">
                            {!! Form::label('leave_type_id', 'Employment Status', ['class'=>'sr-only']) !!}
                            <select name="leave_type_id" class="form-control" id="type">
                                <option value="0">-=Pilih=-</option>
                                @foreach($type as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $divisi = App\Models\Master\Divisi::where('pnum','=',Session::get('pnum'))->orderBy('name', 'asc')->lists('name', 'id')->prepend('Divisi', '0');
                            ?>
                            {!! Form::label('eeo_cat_code', 'Divisi', ['class'=>'sr-only']) !!}
                            {!! Form::select('eeo_cat_code', $divisi, '', ['class' => 'form-control eeo_cat_code', 'id' => 'eeo_cat_code']) !!}
                        </div>
                        <button class="btn btn-success">Search</button>
                    </form>
                </div>
                <div style="margin-bottom: 60px;"></div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Leave Type</th>
                                <th>No of Leave</th>
                                <th>Use of leave</th>
                                <th>Balance</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        @if($dataLeave == 1)
                        <tbody>
                            @foreach($leave as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->emp_lastname }}</td>
                                <td>{{ $row->from_date }}</td>
                                <td>{{ $row->to_date }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->no_of_days }}</td>
                                <td>{{ $row->days_used }}</td>
                                <td>{{ $row->balance }}</td>
                                @if($row->balance <= 0.0)
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                @else
                                    <td>
                                        <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $row->emp_number }}" data-extra="{{ $row->id }}"><i class="fa fa-edit" title="Edit"></i></a>
                                    </td>
                                    <td>
                                        <a id="show" href="#dedModal" data-toggle="modal" class="open-dedModal" data-id="{{ $row->emp_number }}" data-extra="{{ $row->id }}"><i class="fa fa-minus" title="Deduction"></i></a>
                                    </td>
                                    <td>
                                        <a id="show" data-href="{{ route('hrd.delLeaveEmp', $row->id) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" title="Remove"></i></a>
                                    </td>
                                @endif
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                        @endif
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
                <h4 class="modal-title" id="showModal">Employee Leave</h4>
            </div>
            <form method="post" action="{{ route('hrd.setLeaveEmp') }}">
                <div class="modal-body">
                    <input type="hidden" id="emp_id" name="emp_id" />
                    <input type="hidden" id="leave_id" name="leave_id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="employee_id">NIK</label>
                        <input class="form-control" type="text" name="employee_idL" id="employee_idL" disabled="disabled" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="emp_name">Full Name</label>
                        <input class="form-control" type="text" name="emp_name" id="emp_name" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        {!! Form::label('leave_type_id', 'Leave Type') !!}
                        <select name="leave_type_id" class="form-control" id="type">
                            <option value="0">-=Pilih=-</option>
                            @foreach($type as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="from_date">Valid From</label>
                        <input class="form-control" type="text" name="from_date" id="from_date" />
                    </div>
                    <div class="form-group">
                        <label for="to_date">Valid To</label>
                        <input class="form-control" type="text" name="to_date" id="to_date" />
                    </div>
                    <div class="form-group">
                        <label for="no_of_days">Number Of Leave</label>
                        <input class="form-control" type="text" name="no_of_days" id="no_of_days" />
                    </div>
                    <div class="form-group">
                        <label for="days_used">Number Of Used</label>
                        <input class="form-control" type="text" name="days_used" id="days_used" disabled="disabled" />
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation Delete Leave
            </div>
            <div class="modal-body">
                <h1>Are you sure want to delete this leave?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<div id="dedModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dedModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="dedModal">Employee Deduction Leave</h4>
            </div>
            <form method="post" action="{{ route('hrd.dedLeaveEmp') }}">
                <div class="modal-body">
                    <input type="hidden" id="emp_idDed" name="emp_idDed" />
                    <input type="hidden" id="leave_idDed" name="leave_idDed" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group eventInsFormDed">
                        <label for="emp_nameDed">Full Name</label>
                        <input class="form-control" type="text" name="emp_nameDed" id="emp_nameDed" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="employee_idDed">NIK</label>
                        <input class="form-control" type="text" name="employee_idDed" id="employee_idDed" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="leave_nameDed">Leave Type</label>
                        <input class="form-control" type="text" name="leave_nameDed" id="leave_nameDed" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="no_of_daysDed">Number Of Leave</label>
                        <input class="form-control" type="text" name="no_of_daysDed" id="no_of_daysDed" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="days_usedDed">Number Of Used</label>
                        <input class="form-control" type="text" name="days_usedDed" id="days_usedDed" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="days_ded">Number Of Deduction</label>
                        <input class="form-control" type="text" name="days_ded" id="days_ded" />
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <textarea class="form-control" name="reason" id="reason"></textarea>
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