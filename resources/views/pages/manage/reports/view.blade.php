@extends('_main_layout')

@section('content')
<?php
//    print_r($emp->emp_birthday);
function date_formated($date){
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>
<div class="container">
    <h2>Personal Data</h2>
    <div style="margin-bottom: 20px;"></div>
    <a class="btn btn-success" href="{{ URL('/hrd/pPersonal/'.$emp->emp_number) }}" onclick="window.open(this.href).print(); return false">
        <i>
            Print Data Personal
        </i>
    </a>
    <!-- <button class="btn btn-success" id="printEmp" onclick="PrintEmp({{ $emp->emp_number }})">Print Personal</button> -->
    <!-- <button class="btn btn-success" id="printQuali" onclick="PrintQuali({{ $emp->emp_number }})">Print Qualification</button> -->
    <div style="margin-bottom: 20px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            
            $date = new DateTime($emp->joined_date);
            $now = new DateTime();
            $interval = $now->diff($date);
            $yos = '';
            if($interval->y <= 1){
                $yos = $interval->y.' Year - '.$interval->m.' Months';
            }else{
                $yos = $interval->y.' Years -'.$interval->m.' Months';
            }
//            print_r($yos); die;
            ?>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <div class="col-lg-3 col-md-3 col-sm-3">
                @if($pic)
                    @if($pic->epic_picture_type == '2')
                        <img  class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                    @elseif($pic->epic_picture_type == '1')
                        <img  class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                    @else
                        <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                    @endif
                @else
                    <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label for="emp_name">Employee Name</label>
                        <input class="form-control" type="text" name="emp_name" id="emp_name" value="{{ $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname }}" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="emp_dob">DOB</label>
                        <input class="form-control" type="text" name="emp_dob" id="emp_dob" value="{{ date_formated($emp->emp_birthday) }}" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="yos">Period of Employment</label>
                        <input class="form-control" type="text" name="yos" id="yos" value="{{ $yos }}" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="job_title">Job Level</label>
                        <input class="form-control" type="text" name="job_title" id="job_title" value="{{ $emp->job_title->job_title }}" disabled="disabled" />
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 30px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Attendance (2 Years Before)</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($ijin))
                <?php $no = 1;?>
                @foreach($ijin as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->keterangan }}</td>
                        <td>{{ $row->comIjin }}</td>
                        <td>{{ $row->id }}</td>
                    </tr>
                    <?php $no++;?>
                @endforeach
                @else
                    <td colspan="4">No Data</td>
                @endif
                </tbody>
            </table>
            <h3>Reward</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Reward Type</th>
                    <th>Year</th>
                </tr>
                </thead>
                <tbody>
                @if(!$eRewards->isEmpty())
                    <?php $no = 1;?>
                    @foreach($eRewards as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->reward_name->name }}</td>
                            <td>{{ $row->year_reward }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <td colspan="3">No Data</td>
                @endif
                </tbody>
            </table>
            <h3>Promotion</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Promotion Date</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
                </thead>
                <tbody>
                @if(!$ePromots->isEmpty())
                    <?php $no = 1;?>
                    @foreach($ePromots as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->hrd_approved_at }}</td>
                            <td>{{ $row->level_from->job_title }}</td>
                            <td>{{ $row->level_to->job_title }}</td>
                            <?php $no++;?>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="6">No Data</td></tr>
                @endif
                </tbody>
            </table>
            <h3>Punishment</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Punishment Type</th>
                    <th>Reason</th>
                    <th>Year</th>
                </tr>
                </thead>
                <tbody>
                @if(!$punishs->isEmpty())
                <?php $no = 1;?>
                @foreach($punishs as $row)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $row->punishment_type->name }}</td>
                        <td>{{ $row->punish_reason }}</td>
                        <td>{{ date("m-Y", strtotime($row->hrd_approved_at)) }}</td>
                    </tr>
                @endforeach
                @else
                    <tr><td colspan="4">No Data</td></tr>
                @endif
                </tbody>
            </table>
            <h3>Education</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Level</th>
                    <th>Institution Name</th>
                    <th>Major</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                @if(!$edus->isEmpty())
                    <?php $no = 1;?>
                    @foreach($edus as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $row->education->name }}</td>
                            <td>{{ $row->institute }}</td>
                            <td>{{ $row->major }}</td>
                            <td>{{date('d-m-Y', strtotime(substr( $row->start_date, 0, 11))) }}</td>
                            <td>{{date('d-m-Y', strtotime(substr( $row->end_date, 0, 11))) }}</td>
                            <?php $no++;?>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="5">No Data</td></tr>
                @endif
                </tbody>
            </table>
            <h3>Training</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Training Name</th>
                    <th>Sertificate No</th>
                    <th>Sertificate Date</th>
                    <th>Expired Date</th>
                </tr>
                </thead>
                <tbody>
                @if(!$trains->isEmpty())
                    <?php $no = 1;?>
                    @foreach($trains as $row)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>@if($row->license_id == 1) {{ $row->train_name }} @else {{ $row->trainning->name }} @endif</td>
                            <td>{{ $row->license_no }}</td>
                            <td>{{ $row->license_issued_date }}</td>
                            <td>{{ $row->license_expiry_date }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <td colspan="5">No Data</td>
                @endif
                </tbody>
            </table>

            <h3>Karyawan Join (1 Bulan Terakhir)</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Tanggal Join</th>
                </tr>
                </thead>
                <tbody>
                @if($joinedEmployees->count() > 0)
                    <?php $no = 1;?>
                    @foreach($joinedEmployees as $employee)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->emp_firstname . ' ' . $employee->emp_middle_name . ' ' . $employee->emp_lastname }}</td>
                            <td>{{ $employee->job_title }}</td>
                            <td>{{ date('d-m-Y', strtotime($employee->joined_date)) }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <tr><td colspan="5">Tidak ada data karyawan join dalam 1 bulan terakhir</td></tr>
                @endif
                </tbody>
            </table>

            <h3>Karyawan Terminate (1 Bulan Terakhir)</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jabatan Terakhir</th>
                    <th>Tanggal Terminate</th>
                </tr>
                </thead>
                <tbody>
                @if($terminatedEmployees->count() > 0)
                    <?php $no = 1;?>
                    @foreach($terminatedEmployees as $employee)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->emp_firstname . ' ' . $employee->emp_middle_name . ' ' . $employee->emp_lastname }}</td>
                            <td>{{ $employee->job_title }}</td>
                            <td>{{ date('d-m-Y', strtotime($employee->term_date)) }}</td>
                        </tr>
                        <?php $no++;?>
                    @endforeach
                @else
                    <tr><td colspan="5">Tidak ada data karyawan terminate dalam 1 bulan terakhir</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
function PrintEmp(id){
    $.ajax({
        type: 'get',
        url: "{{ route('hrd.pPersonal') }}",
        data: {emp_number:id},
        dataType: "html",
        success: function(result) {
            var mywindow = window.open('', 'my div');
            mywindow.document.write(result);
            mywindow.print();
            mywindow.close();
            return true;
        }
    });
}
function PrintQuali(id){
    $.ajax({
        type: 'get',
        url: "{{ route('hrd.pQualification') }}",
        data: {emp_number:id},
        dataType: "html",
        success: function(result) {
            var mywindow = window.open('', 'my div');
            mywindow.document.write(result);
            mywindow.print();
            mywindow.close();
            return true;
        }
    });
}
</script>
@endsection