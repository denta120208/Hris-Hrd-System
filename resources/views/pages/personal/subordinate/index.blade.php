@extends('_main_layout')

@section('content')
<style type="text/css">
    .modal-xtra-large{
        width: 950px;
        margin: auto;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({});
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
            $(".modal-body #emp_id").val(id);
            $('#personalTab').load("{{ route('personalEmp') }}/personal/" + id, function (result) {
                $('.active a').tab('show');
            });
        });
        $('[data-toggle="tab"]').click(function (e) {
            console.log($('#emp_id').val());
            var $this = $(this),
                    loadurl = "{{ route('personalEmp') }}/" + $this.attr('href') + "/" + $('#emp_id').val(),
                    targ = $this.attr('data-target');
            $.get(loadurl, function (data) {
                $(targ).html(data);
            });
            $(this).tab('show');
            return false;
        });
        $('#addEmp').on("click", ".open-addModal", function () {});
        $('select.eeo_cat_code option:first').attr('disabled', true);
        $('#emp_status option:first').attr('disabled', true);
        $(document).on("click", ".open-terminateModal", function () {
            var id = $(this).data('id');
            $(".modal-body #emp_id").val(id);
        });
        $('select.reason_id option:first').attr('disabled', true);
        $('#termination_date').datetimepicker({
            format: 'Y-m-d',
        });
    });
</script>
<div class="container">
    <!--<div style="margin-bottom: 50px;"></div>-->
    <div class="row">
        <!--<div style="margin-bottom: 60px;"></div>-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Subordinate</h2>
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Photo</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Join Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subs as $sub)
                            <?php $jobTitle = \App\Models\Master\JobMaster::where('id', $sub->job_title_code)->first(); ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    @if($sub->epic_picture)
                                    @if($sub->epic_picture_type == '2')
                                    <img style="height: 100px;width: 100px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($sub->epic_picture) }}"/>
                                    @elseif($sub->epic_picture_type == '1')
                                    <img style="height: 100px;width: 100px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $sub->epic_picture }}"/>
                                    @else
                                    <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                                    @endif
                                    @else
                                    <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                                    @endif
                                </td>
                                <td>{{ $sub->employee_id }}</td>
                                <td>{{ $sub->emp_firstname.' '.$sub->emp_middle_name.' '.$sub->emp_lastname }}</td>
                                <td>@if($jobTitle) {{ $jobTitle->job_title }} @endif</td>
                                <td>{{ $sub->joined_date }}</td>
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $sub->emp_number }}"><i class="fa fa-eye"></i></a>
                                </td>
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
                <img id="img"/>
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
@endsection