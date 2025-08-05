<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#jobDtlSave').hide();
        $('#jobDtlCancel').hide();
        $('#viewContract').hide();
//        $('#editRt').hide();
        $('#addRt').hide();
        $('#jobDtl').click(function () {
            $('#jobForm input[type="text"]').prop("readonly", false);
//            $('#editRt').show();
            $('#addRt').show();
            $('#viewContract').show();
            $('#jobDtl').hide();
            $('#jobDtlSave').show();
            $('#jobDtlCancel').show();
        });
        $('#jobDtlCancel').click(function () {
            $('#jobForm input[type="text"]').prop("readonly", true);
//            $('#editRt').hide();
            $('#addRt').hide();
            $('#viewContract').hide();
            $('#jobDtl').show();
            $('#jobDtlSave').hide();
            $('#jobDtlCancel').hide();
        });
//        $('#joined_date').datetimepicker({
//            format: 'yyyy-mm-dd',
//        });
        // $('#econ_extend_start_date').datetimepicker({
        //     format: 'yyyy-mm-dd',
        // });
        // $('#econ_extend_end_date').datetimepicker({
        //     format: 'yyyy-mm-dd',
        // });
        $(document).on("click", ".open-edtModal", function () {
            var id = $(this).data('id');
            $(".modal-body #rt_id").val($(this).data('id'));
            console.log(id);
            if (id > 0) {
                $.ajax({
                    url: '{{ route('personal.getReportToDtl') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        var name = data['emp_firstname'] + ' ' + data['emp_middle_name'] + ' ' + data['emp_lastname'];
                        $('#emp_sup').val(name);
                        $('#rt_type').val(data['reason']);
                    }
                });
            }
        });
    });
</script>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <form id="jobForm">
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
                <label for="city_code">Employment Status</label>
                <input class="form-control" type="text" name="city_code" id="city_code" value="{{ $emp->estatus->name }}" readonly="readonly" />
            </div>
        </div>
        <!--    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="provin_code">Job Category</label>
                    <input class="form-control" type="text" name="provin_code" id="provin_code" value="-" readonly="readonly" />
                </div>
            </div>-->
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="joined_date">Joined Date</label>
                <?php $join_date = date_formated($emp->joined_date); ?>
                <input class="form-control" type="text" name="joined_date" id="joined_date" value="<?php
                if ($join_date != '01-01-1970' && $join_date != '01-01-1900') {
                    echo date_formated($emp->joined_date);
                }
                ?>" readonly="readonly" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <?php $subunit = App\Models\Master\Subunit::lists('name', 'old_id')->prepend('-=Pilih=-', '0'); ?>
                <div class="form-group">
                    {!! Form::label('work_station', 'SubUnit') !!}
                    {!! Form::select('work_station', $subunit, $emp->work_station, ['class' => 'form-control', 'id' => 'work_station', 'disabled' => 'disabled']) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <?php $location = \App\Models\Master\Location::lists('name', 'old_id')->prepend('-=Pilih=-', '0'); ?>
                <div class="form-group">
                    {!! Form::label('location_id', 'Location') !!}
                    {!! Form::select('location_id', $location, $emp->location_id, ['class' => 'form-control', 'id' => 'location_id', 'disabled' => 'disabled']) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $job = App\Models\Master\JobMaster::lists('job_title', 'id')->prepend('-=Pilih=-', '0'); ?>
            <div class="form-group">
                {!! Form::label('job_title_code', 'Job Level') !!}
                {!! Form::select('job_title_code', $job, $emp->job_title_code, ['class' => 'form-control', 'id' => 'job_title_code', 'disabled' => 'disabled']) !!}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $divisi = App\Models\Master\Divisi::lists('name', 'id')->prepend('-=Pilih=-', '0');?>
            <div class="form-group">
                {!! Form::label('division', 'Division') !!}
                {!! Form::select('eeo_cat_code', $divisi, $emp->eeo_cat_code, ['class' => 'form-control', 'id' => 'divisi', 'disabled' => 'disabled']) !!}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php $department = App\Models\Master\Department::lists('job_dept_desc', 'id')->prepend('-=Pilih=-', '0');?>
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
        ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="econ_extend_start_date">Contract Start Date</label>
                <input class="form-control" type="text" name="econ_extend_start_date" id="econ_extend_start_date" value="<?php echo date_formated($start_date); ?>" disabled="disabled" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="econ_extend_end_date">Contract End Date</label>
                <input class="form-control" type="text" name="econ_extend_end_date" id="econ_extend_end_date" value="<?php echo date_formated($end_date); ?>" disabled="disabled" />
            </div>
        </div>
        <!--    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="eattach_filename">Contract Details</label>
                    <input class="form-control" type="text" name="eattach_filename" id="eattach_filename" value="{{ $contract->eattach_filename }}" readonly="readonly" />
                    <a href="{{ route('view.contract', $emp->emp_number) }}" target="_blank" id="viewContract">{{ $contract->eattach_filename }}</a>
                </div>
            </div>-->
        @else
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="econ_extend_start_date">Contract Start Date</label>
                <input class="form-control" type="text" name="econ_extend_start_date" disabled="disabled" />
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="econ_extend_end_date">Contract End Date</label>
                <input class="form-control" type="text" name="econ_extend_end_date" disabled="disabled"/>
            </div>
        </div>
        <!--    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="coun_code">Contract Details</label>
                    <input class="form-control" type="text" name="coun_code" id="coun_code" value="-" disabled="disabled" />
                </div>
            </div>-->
        @endif
    </form>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4>Report To</h4>
    {{--<a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="0"><i class="fa fa-2x fa-plus-square-o" title="Add" id="addRt"></i></a>--}}
    <table id="data-table-basic" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Report Method</th>
    <!--            <th id="edit"></th>-->
            </tr>
        </thead>
        <tbody>
            @if($reports)
            <?php $no = 1; ?>
            @foreach($reports as $row)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                <td>{{ $row->reporting_method_name }}</td>
                <!--<td><a href="#edtModal" data-toggle="modal" class="open-edtModal" data-id="{{ $row->id }}"><i class="fa fa-check-circle" title="Edit" id="editRt"></i></a></td>-->
                <?php $no++; ?>
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
<!--<button class="btn btn-success" id="jobDtl">Edit</button>
<button class="btn btn-primary" id="jobDtlSave">Save</button>
<button class="btn btn-danger" id="jobDtlCancel">Cancel</button>-->

<div id="edtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edtModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="edtModal">Leave Approval</h4>
            </div>
            <form action="{{ route('setLeave') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="rt_id" id="rt_id" value="" />
                    <div class="form-group">
                        <label for="emp_sup">Name</label>
                        <input class="form-control" type="text" name="emp_sup" id="emp_sup" />
                    </div>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="rt_type">Type Report</label>
                            <select class="form-control" name="rt_type" id="rt_type">
                                <option value="">-=Pilih=-</option>
                                <opting value="1">Langsung</opting>
                                <opting value="2">Langsung</opting>
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