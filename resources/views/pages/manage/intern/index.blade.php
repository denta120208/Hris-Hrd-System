@extends('_main_layout')

@section('content')
<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<style type="text/css">
    .modal-xtra-large{
        width: 1080px;
        margin: auto;
    }
    .modal-xtra-large-no-margin {
        width: 1080px;
    }
</style>
<script type='text/javascript'>
    $(document).ready(function() {
        reportToTable();

        function reportToTable() {
            var t = $('#report_to_table').DataTable();
            const idTable = [];
            $('#BTN_ADD_NEW').on('click', function () {
                var empSupId = $('#emp_sup option:selected').val();
                var rtTypeId = $('#rt_type option:selected').val();

                if(empSupId === "" || rtTypeId === "") {
                    alert("Field cannot be empty!");
                }
                else {
                    var empSupDesc = $('#emp_sup option:selected').text().split(" - ")[1].trim();
                    var rtTypeDesc = $('#rt_type option:selected').text().trim();

                    // Check if a value exists in array
                    if(idTable.indexOf(empSupId) !== -1) {
                        alert(empSupDesc + " Already Exists!");
                    }
                    else {
                        t.row.add([
                            empSupId,
                            empSupDesc,
                            rtTypeId,
                            rtTypeDesc,
                            "<button id='BTN_REMOVE_ROW' name='BTN_REMOVE_ROW' class='btn btn-danger'>X</button>"
                        ]).draw(false);
                        idTable.push(empSupId);

                        $('select[name="emp_sup"]').val(null);
                        $('select[name="emp_sup"]').trigger("change");
                        $('select[name="rt_type"]').val(null);
                    }
                }
            });
            $('#report_to_table tbody').on('click', '#BTN_REMOVE_ROW',function() {
                var rowData = t.row($(this).parents('tr')).data();
                var id = rowData[0];

                t.row($(this).parents('tr')).remove().draw();

                var index = idTable.indexOf(id);
                if (index >= 0) {
                    idTable.splice(index, 1);
                }
            });
        }
    });

    function validateAddEmployee() {
        var t = $('#report_to_table').DataTable();
        var data = t.rows().data();

        if(data.length <= 0) {
            alert("Report To cannot be empty!");
            return false;
        }
        else {
            var dataTable = [];
            for (var i = 0; i < data.length; i++) {
                dataTable.push(data[i]);
            }
            $("#TXT_REPORT_TO_DATATABLE").val(JSON.stringify(dataTable));

            return true;
        }
    }
</script>
<script type='text/javascript'>
    $(document).ready(function(){
    $('#empTable').DataTable({
    lengthMenu: [[10, 25, 50, 100, - 1], [10, 25, 50, 100, "All"]],
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
            $(document).on("click", ".open-showModal", function () {
    var id = $(this).data('id');
            $(".modal-body #emp_id").val(id);
            $('#personalTab').load("{{ route('personalEmp') }}/personal/" + id, function (result) {
    $('.active a').tab('show');
    });
    });
            $('[data-toggle="tab"]').click(function(e) {
    var $this = $(this),
            loadurl = "{{ route('personalEmp') }}/" + $this.attr('href') + "/" + $('#emp_id').val(),
            targ = $this.attr('data-target');
            $.get(loadurl, function(data) {
            $(targ).html(data);
            });
            $(this).tab('show');
            return false;
    });
            $('#addEmp').on("click", ".open-addModal", function(){});
            $('#addEmp1').on("click", ".open-addModal1", function(){});
            $('select.eeo_cat_code option:first').attr('disabled', true);
            $('#emp_status option:first').attr('disabled', true);
            $(document).on("click", ".open-terminateModal", function () {
    $(".modal-body #leave_id").val($(this).data('id'));
            // var id = $(this).data('id');
                    // $(".modal-body #emp_id").val(id);
                    {{--$('#personalTab').load("{{ route('personalEmp') }}/personal/" + id, function (result) {--}}
                    {{--    $('.active a').tab('show'); --}}
                    {{--}); --}}
                    });
                            $(document).on("click", ".open-terminateModal", function () {
                    var id = $(this).data('id');
                            $(".modal-body #terminate_emp_id").val(id);
                    });
                            $('select.reason_id option:first').attr('disabled', true);
                            $('#termination_date').datetimepicker({
                    format: 'd-m-Y',
                            timepicker:false
                    });
                    });
                            $(document).on("click", ".open-unterminateModal", function () {
                    var id = $(this).data('id');
                            $(".modal-body #terminate_emp_id").val(id);
                    });
</script>
<div class="container">
    <h2>List Internship</h2>
    @if($username == 'dirut' || $username == 'dirops1' || 
    $username == 'dirops2' || $username == 'dirops3' || $username == 'dirops4' || 
    $username == 'dirops5')
    @else
    <br>
    <a class="btn btn-primary open-addModal" id="addEmp" data-toggle="modal" href="#addModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Internship
    </a>
    @endif
    <div style="margin-bottom: 50px;"></div>
    <div class="row">
        <div class="data-table-list">
            <div class="table-responsive">
                @if($username == 'dirut' || $username == 'dirops1' || 
                    $username == 'dirops2' || $username == 'dirops3' || $username == 'dirops4' || 
                    $username == 'dirops5')
                @else
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form action="{{ route('hrd.search_emp_intern') }}" method="post" class ="form-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="emp_name" class="sr-only">Name</label>
                                <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Name" />
                            </div>
                            <div class="form-group">
                                <label for="employee_id" class="sr-only">NIK</label>
                                <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" />
                            </div>
                            <div class="form-group">

                                {!! Form::label('employment_status_id', 'Employment Status', ['class'=>'sr-only']) !!}
                                <select name="emp_status" id="emp_status" class='form-control'>
                                    <option value="0">Employment Status</option>
                                    <option value="3">Honorer</option>
                                    <option value="4">Magang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php
                                $divisi = App\Models\Master\Divisi::where('pnum','=',Session::get('pnum'))->orderBy('name', 'asc')->lists('name', 'id')->prepend('Divisi', '0');
                                ?>
                                {!! Form::label('eeo_cat_code', 'Divisi', ['class'=>'sr-only']) !!}
                                {!! Form::select('eeo_cat_code', $divisi, '', ['class' => 'form-control eeo_cat_code', 'id' => 'eeo_cat_code']) !!}
                            </div>
                            <div class="form-group">
                                <label for="termination_id" class="sr-only">Employee Status</label>
                                <select name="termination_id" class="form-control" id="termination_id">
                                    <option value="" disabled selected>Employee Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Past</option>
                                </select>
                            </div>
                            <button class="btn btn-success">Search</button>
                        </form>
                    </div>
                    <div style="margin-bottom: 60px;"></div>
                @endif
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Project/Unit</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                @if($username == 'dirut' || $username == 'dirops1' || 
                                    $username == 'dirops2' || $username == 'dirops3' || $username == 'dirops4' || 
                                    $username == 'dirops5')
                                    <th></th>
                                @else
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emps as $emp)
                            <?php
                            $jobTitle = \App\Models\Master\JobMaster::where('id', $emp->job_title_code)->first();
                            $location = \App\Models\Master\Location::where('id', $emp->location_id)->first();
                            ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $emp->employee_id }}</td>
                                <td>{{ $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname }}</td>
                                <td>@if($jobTitle) {{ $jobTitle->job_title }} @endif</td>
                                <td>@if($location) {{ $location->name }} @endif</td>
                                <td>{{ date_formated($emp->joined_date) }}</td>
                                <td>{{$emp->termination_id > '1' ? 'Past' : 'Active'}}</td>
                                @if($username == 'dirut' || $username == 'dirops1' || 
                                    $username == 'dirops2' || $username == 'dirops3' || $username == 'dirops4' || 
                                    $username == 'dirops5')
                                    <td>
                                        <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-edit"></i></a>
                                    </td>
                                @else
                                @if($emp->termination_id > '1')
                                <td>
                                    <i class="fa fa-edit"></i>
                                </td>
                                <td>
                                    <a id="show" href="#unterminateModal" data-toggle="modal" class="open-unterminateModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-undo" title="Unterminate"></i></a>
                                </td>
                                <td>
                                    <i class="fa fa-file-archive-o" title="Renew Contract"></i>
                                </td>
                                <td>
                                    <i class="fa fa-image" title="Picture"></i>
                                </td>
                                <td>
                                    <a href="{{ route('hrd.printSK', $emp->emp_number) }} " target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true" title="Picture"></i></a>
                                </td>
                                @else
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-edit"></i></a>
                                </td>
                                <td> 
                                    <a id="show" href="#terminateModal" data-toggle="modal" class="open-terminateModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-trash" title="Terminate"></i></a> 
                                </td>
                                <td>
                                    <a href="{{ route('hrd.renewContract', $emp->emp_number) }}"><i class="fa fa-file-archive-o" title="Renew Contract"></i></a>
                                </td>
                                <td><a href="{{ route('personalEmp.empPic', $emp->emp_number) }}"><i class="fa fa-image" title="Picture"></i></a></td>
                                <td><a href="{{ route('hrd.administrationDocument', $emp->emp_number) }}"><i class="fa fa-file-text-o" title="Administration Document"></i></a></td>

                                @endif
                                @endif
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog modal-xtra-large">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Detail Employee</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="emp_id" id="emp_id" />
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a aria-controls="personalTab" data-toggle="tab" href="personal" data-target="#personalTab">Personal Detail</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="jobTab" data-toggle="tab" href="job" data-target="#jobTab">Job</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="contactTab" data-toggle="tab" href="contact" data-target="#contactTab">Contact Details</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="dependentsTab" data-toggle="tab" href="dependents" data-target="#dependentsTab">Dependents</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="emergencyTab" data-toggle="tab" href="emergency" data-target="#emergencyTab">Emergency Contact</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="qualificationsTab" data-toggle="tab" href="qualifications" data-target="#qualificationsTab">Qualifications</a>
                        </li>
                        <li role="presentation">
                            <a aria-controls="reward_punishTab" data-toggle="tab" href="reward_punish" data-target="#reward_punishTab">Reward & Punishment</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="personalTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="jobTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="contactTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="dependentsTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="emergencyTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="qualificationsTab"><div class="tab-ctn"></div></div>
                        <div role="tabpanel" class="tab-pane" id="reward_punishTab"><div class="tab-ctn"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-xtra-large-no-margin">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="addModal">Add Employee</h4>
            </div>
            <form onsubmit="return validateAddEmployee()" method="post" action="{{ route('hrd.addIntern') }}">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="text" name="TXT_REPORT_TO_DATATABLE" class="form-control" style="display: none;" id="TXT_REPORT_TO_DATATABLE" readonly>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h4><b>Personal Detail</b></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="employee_id">Employee ID&nbsp;</label><span style="color: red;">*</span>
                                <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="Employee ID" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_firstname">Firstname&nbsp;</label><span style="color: red;">*</span>
                                <input class="form-control" type="text" name="emp_firstname" id="emp_firstname" placeholder="Firstname" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_middle_name">Middlename</label>
                                <input class="form-control" type="text" name="emp_middle_name" id="emp_middle_name" placeholder="Middlename" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_lastname">Lastname</label>
                                <input class="form-control" type="text" name="emp_lastname" id="emp_lastname" placeholder="Lastname" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_ktp">KTP&nbsp;</label><span style="color: red;">*</span>
                                <input class="form-control" type="text" name="emp_ktp" id="emp_ktp" placeholder="KTP" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_gender">Gender&nbsp;</label><span style="color: red;">*</span>
                                <select class="form-control" name="emp_gender" id="emp_gender" required>
                                    <option value="">--- Not Selected ---</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $nationality = \DB::table("nationality")->get(); ?>
                                <label for="nation_code">Nationality&nbsp;</label><span style="color: red;">*</span>
                                <select class="form-control select2" name="nation_code" id="nation_code" required>
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($nationality as $data)
                                    <option value="{{ $data->id }}" {{ $data->id == "83" ? "selected" : "" }}>{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_marital_status">Marital Status&nbsp;</label><span style="color: red;">*</span>
                                <select class="form-control" name="emp_marital_status" id="emp_marital_status" required>
                                    <option value="">--- Not Selected ---</option>
                                    <option value="Lajang">Lajang</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai">Cerai</option>
                                    <option value="Janda/Duda">Janda/Duda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_birthday">Date of Birth&nbsp;</label><span style="color: red;">*</span>
                                <input class="form-control" type="date" name="emp_birthday" id="emp_birthday" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="bpjs_ks">BPJS Kes</label>
                                <input class="form-control" type="text" name="bpjs_ks" id="bpjs_ks" placeholder="BPJS Kes" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="bpjs_tk">BPJS TK</label>
                                <input class="form-control" type="text" name="bpjs_tk" id="bpjs_tk" placeholder="BPJS TK" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="npwp">No. NPWP</label>
                                <input class="form-control" type="text" name="npwp" id="npwp" placeholder="No. NPWP" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_dri_lice_num">Driver's License Number</label>
                                <input class="form-control" type="text" name="emp_dri_lice_num" id="emp_dri_lice_num" placeholder="Driver's License Number" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="emp_dri_lice_exp_date">License Expiry Date</label>
                                <input class="form-control" type="date" name="emp_dri_lice_exp_date" id="emp_dri_lice_exp_date" />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h4><b>Job</b></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="job_level">Job Title <span style="color: red;">*</span></label>
                                <input class="form-control" type="text" name="job_level" id="job_level" placeholder="Job Title" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $employment_status = \DB::table("employment_status")->whereIn("id", [3,4])->get(); ?>
                                <label for="estatus">Employment Status <span style="color: red;">*</span></label>
                                <select class="form-control" name="estatus" id="estatus" required>
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($employment_status as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="joined_date">Joined Date <span style="color: red;">*</span></label>
                                <input class="form-control" type="date" name="joined_date" id="joined_date" placeholder="Joined Date" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $subunit = \DB::table("subunit")->get(); ?>
                                <label for="work_station">SubUnit</label>
                                <select class="form-control select2" name="work_station" id="work_station">
                                    @foreach($subunit as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $project = \App\Models\Master\Location::where('pnum', Session::get('pnum'))->where('ptype', Session::get('ptype'))->first(); ?>
                                <label for="location_id">Unit/Project <span style="color: red;">*</span></label>
                                <input class="form-control" type="hidden" name="location_id" id="location_id" value="{{ $project['id'] }}" required />
                                <input class="form-control" type="text" name="location_name" id="location_name" value="{{ $project['name'] }}" disabled="disabled" required />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $job_title = \DB::table("job_title")->get(); ?>
                                <label for="job_title_code">Job Level <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="job_title_code" id="job_title_code" required>
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($job_title as $data)
                                    <option value="{{ $data->id }}">{{ $data->job_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $divisi = App\Models\Master\Divisi::where('pnum','=',Session::get('pnum'))->orderBy('name', 'asc')->get(); ?>
                                <label for="eeo_cat_code">Division <span style="color: red;">*</span></label>
                                <select class="form-control eeo_cat_code select2" name="eeo_cat_code" id="eeo_cat_code" required>
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($divisi as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?php $job_department = \DB::table("job_department")->where("pnum", Session::get('pnum'))->orderBy("job_dept_desc", "ASC")->get(); ?>
                                <label for="department">Department <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="department" id="department" required>
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($job_department as $data)
                                    <option value="{{ $data->id }}">{{ $data->job_dept_desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-check d-flex align-items-center">
                                <label class="form-check-input" for="days_type">Back Office</label>
                                <input class="form-check-label" type="checkbox" name="days_type" id="days_type" checked />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h4><b>Report To</b></h4>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php $employee = \DB::table("employee")->where("termination_id", 0)->where("location_id", $project->id)->where("emp_status", 1)->orderBy("employee_id", "ASC")->get(); ?>
                                <label for="emp_sup">Name</label>
                                <select class="form-control select2" name="emp_sup" id="emp_sup">
                                    <option value="">--- Not Selected ---</option>
                                    @foreach($employee as $data)
                                    <option value="{{ $data->emp_number }}">{{ $data->employee_id }} - {{ $data->emp_fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="rt_type">Type Report</label>
                                <select class="form-control" name="rt_type" id="rt_type">
                                    <option value="">--- Not Selected ---</option>
                                    <option value="1">Langsung</option>
                                    <option value="2">Tidak Langsung</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1" style="padding-top: 26px;">
                            <div class="form-group">
                                <a href="javascript:void(0)" id="BTN_ADD_NEW" name="BTN_ADD_NEW" class="btn btn-primary">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="report_to_table" name="report_to_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Name</th>
                                        <th>Name</th>
                                        <th>ID Report Method</th>
                                        <th>Report Method</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="terminateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Detail Termination</h4>
            </div>
            <form action="{{ route('hrd.terminate') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="terminate_emp_id" id="terminate_emp_id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <?php $reason = \App\Models\Master\TerminationReason::lists('name', 'id')->prepend('-=Pilih=-', '0'); ?>
                    <div class="form-group">
                        {!! Form::label('reason_id', 'Reason') !!}
                        {!! Form::select('reason_id', $reason, null, ['class' => 'form-control', 'id' => 'reason_id']) !!}
                    </div>
                    <div class="form-group">
                        <label for="termination_date">Effective Date</label>
                        {{-- <input class="form-control" type="text" name="termination_date" id="termination_date" readonly="readonly" /> --}}
                        <input class="form-control" type="date" name="termination_date" required />
                    </div>
                    <div class="form-group">
                        <label for="note">Notes</label>
                        <textarea class="form-control" rows="5" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="unterminateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Detail Termination</h4>
            </div>
            <form action="{{ route('hrd.unterminate') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="terminate_emp_id" id="terminate_emp_id" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="note">Notes</label>
                        <textarea class="form-control" rows="5" name="note" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection