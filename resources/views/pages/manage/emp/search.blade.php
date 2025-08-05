@extends('_main_layout')

@section('content')
    <style type="text/css">
        .modal-xtra-large{
            width: 1080px;
            margin: auto;
        }
    </style>
    <script type='text/javascript'>
    $(document).ready(function(){
        $('#empTable').DataTable({
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
        $('select.eeo_cat_code option:first').attr('disabled', true);
        $('#emp_status option:first').attr('disabled', true);
        $(document).on("click", ".open-terminateModal", function () {
            $(".modal-body #leave_id").val( $(this).data('id') );
            // var id = $(this).data('id');
            // $(".modal-body #emp_id").val(id);
            {{--$('#personalTab').load("{{ route('personalEmp') }}/personal/" + id, function (result) {--}}
            {{--    $('.active a').tab('show');--}}
            {{--});--}}
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
    </script>
<!--    <script type='text/javascript'>
        $(document).ready(function(){
            $('#empTable').DataTable({
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
            $('select.eeo_cat_code option:first').attr('disabled', true);
            $('#emp_status option:first').attr('disabled', true);
            $(document).on("click", ".open-terminateModal", function () {
                $(".modal-body #leave_id").val( $(this).data('id') );
                // var id = $(this).data('id');
                // $(".modal-body #emp_id").val(id);
                {{--$('#personalTab').load("{{ route('personalEmp') }}/personal/" + id, function (result) {--}}
                {{--    $('.active a').tab('show');--}}
                {{--});--}}
            });
            
            $(document).on("click", ".open-unterminateModal", function () {
                var id = $(this).data('id');
                $(".modal-body #terminate_emp_id").val(id);
            });
            //$('select.reason_id option:first').attr('disabled', true);
//            $('#termination_date').datetimepicker({
//                format: 'd-m-Y',
//                timepicker:false
//            });
        });
    </script>-->
    <div class="container">
        <a class="btn btn-primary open-addModal" id="addEmp" data-toggle="modal" href="#addModal">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Employee
        </a>
        <div style="margin-bottom: 50px;"></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('hrd.search_emp') }}" method="post" class ="form-inline">
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
                        <?php
                        $emp_status = \App\Models\Master\EmploymentStatus::lists('name','id')->prepend('Employment Status', '0');
                        ?>
                        {!! Form::label('emp_status', 'Employment Status', ['class'=>'sr-only']) !!}
                        {!! Form::select('emp_status', $emp_status, '', ['class' => 'form-control', 'id' => 'emp_status']) !!}
                    </div>
                    <div class="form-group">
                        <?php
                        $jobCategory = \App\Models\Employee\JobCategory::lists('name','id')->prepend('Divisi', '0');
                        ?>
                        {!! Form::label('eeo_cat_code', 'Divisi', ['class'=>'sr-only']) !!}
                        {!! Form::select('eeo_cat_code', $jobCategory, '', ['class' => 'form-control eeo_cat_code', 'id' => 'eeo_cat_code']) !!}
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $no = 1;?>
                <table id="empTable" class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Project/Unit</th>
                        <th>Join Date</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                            <td>{{ $emp->joined_date }}</td>
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
                                    <a href="{{ route('hrd.printSK', $emp->emp_number) }}"><i class="fa fa-file-pdf-o" aria-hidden="true" title="Picture"></i></a>
                                </td>
                            @else
                                <td>
{{--                               <i class="fa fa-edit"></i>--}}
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-edit"></i></a>
                                </td>
                                {{-- <td> --}}
                                {{--    <a id="show" href="#terminateModal" data-toggle="modal" class="open-terminateModal" data-id="{{ $emp->emp_number }}"><i class="fa fa-trash" title="Terminate"></i></a> --}}
                                {{--</td> --}}
                                @if($emp->emp_status == '2')
                                    <td>
                                        <a href="{{ route('hrd.renewContract', $emp->emp_number) }}"><i class="fa fa-file-archive-o" title="Renew Contract"></i></a>
                                    </td>
                                @else
                                    <td>
                                        <i class="fa fa-file-archive-o" title=""></i>
                                    </td>
                                @endif
                                <td>
                                    <a href="{{ route('personalEmp.empPic', $emp->emp_number) }}"><i class="fa fa-image" title="Picture"></i></a>
                                </td>
                            @endif
                        </tr>
                        <?php $no++;?>
                    @endforeach
                    </tbody>
                </table>
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
                        <?php $reason = \App\Models\Master\TerminationReason::lists('name','id')->prepend('-=Pilih=-', '0');?>
                        <div class="form-group">
                            {!! Form::label('reason_id', 'Reason') !!}
                            {!! Form::select('reason_id', $reason, null, ['class' => 'form-control', 'id' => 'reason_id']) !!}
                        </div>
                        <div class="form-group">
                            <label for="termination_date">Effective Date</label>
                            <input class="form-control" type="text" name="termination_date" id="termination_date" readonly="readonly" />
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