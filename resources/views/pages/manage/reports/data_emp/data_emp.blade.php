@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'csvHtml5'
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
<div class="container">
    <h2>Data Karyawan</h2>
    <div class="row">
        <form action="{{ route('hrd.view_data_karyawan') }}" method="post">
<!--            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
            
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="emp_name">Name</label><br>
                    <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Name" value="{{ $param['emp_name'] }}" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="employee_id">NIK</label><br>
                    <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" value="{{ $param['employee_id'] }}" />
                </div>
            </div>
            <div class="col-lg-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    {!! Form::label('location_id', 'Project') !!}<br>
                    <select class="form-control" name="location_id" id="location_id">
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataLocation as $data)
                        <option value="{{ $data->id }}" {{ $param['location_id'] == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">   
                <div class="form-group">
                    {!! Form::label('emp_status', 'Employment Status') !!}<br>
                    <select class="form-control" name="emp_status" id="emp_status">
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataEmploymentStatus as $data)
                        <option value="{{ $data->id }}" {{ $param['emp_status'] == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    {!! Form::label('eeo_cat_code', 'Divisi') !!}<br>
                    <select class="form-control" name="eeo_cat_code" id="eeo_cat_code">
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataDivisi as $data)
                        <option value="{{ $data->id }}" {{ $param['eeo_cat_code'] == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>Employee Status</label><br>
                    <select name="termination_id" class="form-control">
                        <option value="">--- Not Selected ---</option>
                        @if(isset($param['termination_id']))
                            <option value="1" {{ $param['termination_id'] == "1" ? "selected" : "" }}>Active</option>
                            <option value="2" {{ $param['termination_id'] == "2" ? "selected" : "" }}>Past</option>
                        @else
                            <option value="1" selected="yes">Active</option>
                            <option value="2">Past</option>
                        @endif
                    </select>
                </div>
                <div class="form-group pull-right">
                    <label style="visibility: hidden;">action</label><br>
                    <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
        <div style="margin-bottom: 140px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Location</th>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>DOB</th>
                                <th>ID Card</th>
                                <th>Gender</th>
                                <th>Marital Status</th>
                                <th>Address 1</th>
                                <th>City 1</th>
                                <th>Provinces 1</th>
                                <th>Address 2</th>
                                <th>City 2</th>
                                <th>Provinces 2</th>
                                <th>Mobile</th>
                                <th>Work Email</th>
                                <th>Personal Email</th>
                                <th>Join Date</th>
                                <th>Tax ID</th>
                                <th>Tax Status</th>
                                <th>BPJS KS</th>
                                <th>BPJS TK</th>
                                <th>Religion</th>
                                <th>Education</th>
                                <th>Start Contract</th>
                                <th>End Contract</th>
                                <th>Employment Status</th>
                                <th>Job Level</th>
                                <th>Job Title</th>
                                <th>Division</th>
                                <th>Department</th>
                                <th>SubUnit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataEmployee as $emp)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $emp->location_name }}</td>
                                <td>{{ $emp->employee_id }}</td>
                                <td>{{ $emp->emp_fullname }}</td>
                                <td>{{ formatDate($emp->emp_birthday) }}</td>
                                <td>'{{ $emp->emp_ktp }}</td>
                                <td>
                                    @if($emp->emp_gender == "1")
                                    Laki-Laki
                                    @elseif($emp->emp_gender == "2")
                                    Perempuan
                                    @else
                                    @endif
                                </td>
                                <td>{{ $emp->emp_marital_status }}</td>
                                <td>{{ $emp->emp_street1 }}</td>
                                <td>{{ $emp->city_code }}</td>
                                <td>{{ $emp->provin_code }}</td>
                                <td>{{ $emp->emp_street2 }}</td>
                                <td>{{ $emp->city_code_res }}</td>
                                <td>{{ $emp->provin_code_res }}</td>
                                <td>'{{ $emp->emp_mobile }}</td>
                                <td>{{ $emp->emp_work_email }}</td>
                                <td>{{ $emp->emp_oth_email }}</td>
                                <td>{{ date("Y-m-d", strtotime($emp->joined_date)) }}</td>
                                <td>'{{ $emp->npwp }}</td>
                                <td>{{ $emp->status_pajak }}</td>
                                <td>'{{ $emp->bpjs_ks }}</td>
                                <td>'{{ $emp->bpjs_tk }}</td>
                                
                                <td>{{ $emp->agama }}</td>
                                <td>{{ $emp->institute }}</td>
                                <td>{{ date("Y-m-d", strtotime($emp->econ_extend_start_date)) }}</td>
                                <td>{{ date("Y-m-d", strtotime($emp->econ_extend_end_date)) }}</td>
                                
                                <td>{{ $emp->employment_status }}</td>
                                <td>{{ $emp->job_title }}</td>
                                <td>{{ $emp->job_level }}</td>
                                <td>{{ $emp->job_category }}</td>
                                <td>{{ $emp->job_dept_desc }}</td>
                                <td>{{ $emp->work_station }}</td>
                                <td>
                                    @if(empty($emp->termination_id) || $emp->termination_id == NULL)
                                    Active
                                    @else
                                    Past
                                    @endif
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
<?php

function formatDate($date, $format = 'Y-m-d') {
    if (!empty($date)) {
        $dat = \DateTime::createFromFormat($format, $date);
        $stat = $dat && $dat->format($format) === $date;
        if ($stat == false) {
            $finalDate = \DateTime::createFromFormat('M d Y h:i:s A', $date)->format($format);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    } else {
        return "";
    }
}
?>
@endsection