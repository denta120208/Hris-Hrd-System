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
        var table = $('#eduTable').DataTable({
            dom: 'l<"toolbar">frtip',
            "pageLength": 25,
        });
        // $('#eduTable').on('click', 'tbody tr', function () {
        //     var data = table.row( $(this) ).data();
        //     var id = $(data[0]).attr("data-id"); // get attribute data-id from TD
        //     // console.log(id);
        //     // alert(id);
        //     // console.log(this.dataset.id, $(this).data().id, $(this).data('id'));
        //     window.location = "/personalEmp/personal/"+id;
        // } );
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
    });
</script>
<div class="container">
    <h2>Education Detail Report</h2>
    <div class="row">
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1;
                    $kt = $kr = $tkt = $tkr = 0; ?>
                    <table id="eduTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Education</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data->emp_firstname.' '.$data->emp_middle_name.' '.$data->emp_lastname }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $data->emp_number }}"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
<?php $no++; ?>
                            @endforeach
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection