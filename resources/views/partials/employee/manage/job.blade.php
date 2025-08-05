<?php
function date_formated($date){
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#job_empId').val( $('#emp_id').val() );
        $('#jobDtlSave').hide();
        $('#jobSave').hide();
        $('#jobCancel').hide();
        $('#jobDtlCancel').hide();
        $('#viewContractFrom').hide();
        $('#viewContractLink').show();
        $('.editRt').hide();
        $('.deleteButton').hide();
        $('#addRt').hide();
        $('#joined_date').datetimepicker("option", "disabled", true );
        $("#joined_date").prop('disabled', true);
        $('#jobDtl').click(function(){
            $('#jobForm input[type="text"]').prop("readonly", false);
            $('#work_station').prop("disabled", false);
            $('#location_id').prop("disabled", false);
            $('#estatus').prop("disabled", false);
            $('#job_title_code').prop("disabled", false);
            $('#days_type').prop("disabled", false);
            $('#divisi').prop("disabled", false);
            $('#department').prop("disabled", false);

            $('#econ_extend_start_date').prop("disabled", true);
            $('#econ_extend_end_date').prop("disabled", true);

            $('#coun_code').prop("disabled", false);
            $('#eattach_filename').prop("disabled", false);
            $('#job_title_code').prop("disabled", false);
            $('.editRt').show();
            $('.deleteButton').show();
            $('#addRt').show();
            $('#viewContractFrom').show();
            $('#viewContractLink').hide();
            $('#jobDtl').hide();
            $('#jobSave').show();
            $('#jobCancel').show();
            $("#joined_date").prop('disabled', false);
            $('#joined_date').datetimepicker({
                format: 'Y-m-d',
            });
        });
        $('#jobCancel').click(function(){
            $('#jobForm input[type="text"]').prop("readonly", true);
            
            $('#work_station').prop("disabled", true);
            $('#location_id').prop("disabled", true);
            $('#estatus').prop("disabled", true);
            $('#job_title_code').prop("disabled", true);
            $('#days_type').prop("disabled", true);

            $('#econ_extend_start_date').prop("disabled", true);
            $('#econ_extend_end_date').prop("disabled", true);

            $('.editRt').hide();
            $('.deleteButton').hide();
            $('#addRt').hide();
            $('#viewContractFrom').hide();
            $('#viewContractLink').show();
            $('#jobDtl').show();
            $('#jobSave').hide();
            $('#jobCancel').hide();
            $('#joined_date').datetimepicker("option", "disabled", true );
            $("#joined_date").prop('disabled', true);
        });
        $('#joined_date').datetimepicker({
            format: 'Y-m-d',
        });
        // $('#econ_extend_start_date').datetimepicker({
        //     format: 'Y-m-d',
        // });
        // $('#econ_extend_end_date').datetimepicker({
        //     format: 'Y-m-d',
        // });
        $(document).on("click", ".open-edtModal", function () {
            var id = $(this).data('id');
            var unit = $('#work_station').val();
            $(".modal-body #rpt_id").val( $(this).data('id') );
            if(id > 0){
                $.ajax({
                    url: '{{ route('personal.getReportToDtl') }}',
                    type: 'get',
                    data: {id:id},
                    dataType: 'json',
                    success:function(data){
                        var name = data['emp_firstname'] + ' ' + data['emp_lastname']
                        $('#emp_sup').val(name);
                        $('#emp_supId').val(data['erep_sup_emp_number']);
                        $('#emp_subId').val( $('#emp_id').val() );
                        $('#rt_type').val( data['erep_reporting_mode'] );
                    }
                });
            }
        });
        $('#emp_sup').autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('personalEmp.getSupReportTo') }}",
                    dataType: "json",
                    type: "GET",
                    data: {
                        emp_sup: request.term,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            var d = item.split('|');
                            return {
                                label: d[1],
                                value: d[1],
                                id: d[0],
                                emp_number: d[0]
                            };
                        }));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                $('#emp_supId').val(ui.item.emp_number),
                $('#emp_subId').val( $('#emp_id').val() )
            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
        $('#emp_sup').autocomplete( "option", "appendTo", ".eventInsForm" );
    });
    function deleteConfirmation(e) {
        if (!confirm("Delete report to?")) {
            e.preventDefault();
        }
    }
</script>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<form id="jobForm" enctype="multipart/form-data" method="POST" action="{{ route('personalEmp.jobDtl') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="job_empId" id="job_empId" />
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="job_level">Job Title</label>
            <input class="form-control" type="text" name="job_level" id="job_level" value="{{ $emp->job_level }}" readonly="readonly" />
        </div>
    </div>
<!--    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="job_spec">Job Specification</label>
            <input class="form-control" type="text" name="job_spec" id="job_spec" value="Not Defined" readonly="readonly" />
        </div>
    </div>-->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php $estatus = App\Models\Master\EmploymentStatus::lists('name', 'id')->prepend('-=Pilih=-', '0');?>
            <div class="form-group">
                {!! Form::label('estatus', 'Employment Status') !!}
                {!! Form::select('estatus', $estatus, $emp->emp_status, ['class' => 'form-control', 'id' => 'estatus', 'disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
<!--    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="job_cat">Job Category</label>
            <input class="form-control" type="text" name="job_cat" id="job_cat" value="-" readonly="readonly" />
        </div>
    </div>-->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="joined_date">Joined Date</label>
            <?php $joinDate = date_formated($emp->joined_date) ?>
            <input class="form-control" type="text" name="joined_date" id="joined_date" value="{{ $joinDate && ($joinDate != '01-01-1970') ? date_formated($emp->joined_date) : '-' }}" readonly="readonly" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php $subunit = App\Models\Master\Subunit::lists('name', 'id')->prepend('-=Pilih=-', '0');?>
            <div class="form-group">
                {!! Form::label('work_station', 'SubUnit') !!}
                {!! Form::select('work_station', $subunit, $emp->work_station, ['class' => 'form-control', 'id' => 'work_station', 'disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php $location = \App\Models\Master\Location::lists('name', 'old_id')->prepend('-=Pilih=-', '0');?>
            <div class="form-group">
                {!! Form::label('location_id', 'Location') !!}
                {!! Form::select('location_id', $location, $emp->location_id, ['class' => 'form-control', 'id' => 'location_id', 'disabled' => 'disabled']) !!}
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $job = App\Models\Master\JobMaster::lists('job_title', 'id')->prepend('-=Pilih=-', '0');?>
        <div class="form-group">
            {!! Form::label('job_title_code', 'Job Level') !!}
            {!! Form::select('job_title_code', $job, $emp->job_title_code, ['class' => 'form-control', 'id' => 'job_title_code', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $divisi = App\Models\Master\Divisi::where('pnum','=',$location_pnum)->orderBy('name', 'asc')->lists('name', 'id')->prepend('-=Pilih=-', '0');?>
        <div class="form-group">
            {!! Form::label('division', 'Division') !!}
            {!! Form::select('eeo_cat_code', $divisi, $emp->eeo_cat_code, ['class' => 'form-control', 'id' => 'divisi', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $department = App\Models\Master\Department::where('pnum','=',$location_pnum)->orderBy('job_dept_desc', 'asc')->lists('job_dept_desc', 'id')->prepend('-=Pilih=-', '0');?>
        <div class="form-group">
            {!! Form::label('division', 'Department') !!}
            {!! Form::select('job_dept_id', $department, $emp->job_dept_id, ['class' => 'form-control', 'id' => 'department', 'disabled' => 'disabled']) !!}
        </div>
    </div>
@if($contract)
<?php

$start_date = $end_date = '';
$start_date = $contract->econ_extend_start_date;
$end_date = $contract->econ_extend_end_date;
//dd(date_formated($end_date));
?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <?php ?>
            <label for="econ_extend_start_date">Contract Start Date</label>
            <input class="form-control" type="text" name="econ_extend_start_date" id="econ_extend_start_date" value="{{ $start_date && date_formated($start_date) != '01-01-1970' ? date_formated($start_date) : '-' }}" disabled="disabled" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="econ_extend_start_date">Contract End Date</label>
            <input class="form-control" type="text" name="econ_extend_end_date" id="econ_extend_end_date" value="{{ $end_date && date_formated($end_date) != '01-01-1970' ? date_formated($end_date) : '-' }}" disabled="disabled" />
        </div>
    </div>
@else
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="econ_extend_start_date">Contract Start Date</label>
            <input class="form-control" type="date" name="econ_extend_start_date" id="econ_extend_start_date" disabled="disabled" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <label for="econ_extend_end_date">Contract End Date</label>
            <input class="form-control" type="date" name="econ_extend_end_date" id="econ_extend_end_date" disabled="disabled"/>
        </div>
    </div>
@endif
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-check d-flex align-items-center">
            <label class="form-check-input" for="days_type">Back Office</label>
            <input class="form-check-label" type="checkbox" name="days_type" id="days_type" @if($emp->days_type == 1) checked @endif disabled="disabled"/>
        </div>
    </div>
    <button class="btn btn-primary" id="jobSave">Save</button>
    <br>
</form>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4>Report To</h4>
    <a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addRt"></i></a>
    <table id="data-table-basic" class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Report Method</th>
            <th id="edit"></th>
        </tr>
        </thead>
        <tbody>
            @if($reports)
                <?php $no = 1;?>
                @foreach($reports as $row)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                <td>{{ $row->reporting_method_name }}</td>
                <td>
                    <a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="{{ $row->id }}"><i class="fa fa-check-circle editRt" title="Edit" id="editRt"></i></a>
                    &nbsp;
                    <a onclick="deleteConfirmation(event)" class="deleteButton" id="deleteButton" href="{{ route('personalEmp.deleteReportTo', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a>
                </td>
                    <?php $no++;?>
                @endforeach
            </tr>
            @else
            <tr>
                <td colspan="3">No Data</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4>Subordinate</h4>
    <table id="data-table-basic" class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Report Method</th>
        </tr>
        </thead>
        <tbody>
        @if($subs)
            <?php $no = 1;?>
            @foreach($subs as $row)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                    <td>{{ $row->reporting_method_name }}</td>
                    <?php $no++;?>
                    @endforeach
                </tr>
                @else
                    <tr>
                        <td colspan="3">No Data</td>
                    </tr>
                @endif
        </tbody>
    </table>
</div>
<button class="btn btn-success" id="jobDtl">Edit</button>
<button class="btn btn-danger" id="jobCancel">Cancel</button>
<div id="edtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModal">Leave Approval</h4>
            </div>
            <form action="{{ route('personalEmp.setReportTo') }}" method="POST" class="eventInsForm">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="rpt_id" id="rpt_id" />
                    <input type="hidden" name="emp_supId" id="emp_supId" />
                    <input type="hidden" name="emp_subId" id="emp_subId" />
                    <div class="form-group">
                        <label for="emp_sup">Name</label>
                        <input class="form-control" type="text" name="emp_sup" id="emp_sup" />
                    </div>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="rt_type">Type Report</label>
                            <select class="form-control" name="rt_type" id="rt_type">
                                <option value="">-=Pilih=-</option>
                                <option value="1">Langsung</option>
                                <option value="2">Tidak Langsung</option>
                            </select>
                        </div>
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