@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#appraisalTable').DataTable({
            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel'
                }
                // {
                //     extend: 'pdfHtml5',
                //     orientation: 'portrait',
                //     pageSize: 'A4'
                // },
                // {
                //     extend: 'print'
                // }
            ]
        });
    });
</script>
<div class="container">
    <h2>Appraisal Report</h2>
    <div class="row">
        <form action="{{ route('hrd.view_appraisal_emp') }}" method="post">
            <div class="col-lg-4">
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
            <!-- <div class="col-lg-4">   
                <div class="form-group">
                    {!! Form::label('dirops_dept_id', 'Dir Ops') !!}<br>
                    <select class="form-control" name="dirops_dept_id" id="dirops_dept_id">
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataDirOpsId as $data)
                        <option value="{{ $data->id }}" {{ $param['dirops_dept_id'] == $data->id ? "selected" : "" }}>{{ $data->job_dept_desc }}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('periodYear', 'Year') !!}<br>
                    <select name="periodYear" id="periodYear" class="form-control">
                        @for ($i=2024;$i<=2034;$i++)
                            @if($i == $year)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}">{{$i}}</option>
                            @endif
                        @endfor    
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
                    @if($viewData == 1) 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <a target="_blank" class="btn btn-sm btn-info" href="{{ URL('/hrd/print_appraisal_emp/' . $location_id . '/' . $dirops_dept_id . '/' . $periodYear) }}" onclick="window.open(this.href).print(); return false">
                                    <i>
                                        Print Data Appraisal
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- <br> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <table id="appraisalTable" class="table table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Project</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Join Date</th>
                                            <th>Level</th>
                                            <th>Division</th>
                                            <th>Department</th>
                                            <th>Status Karyawan</th>
                                            <th>Kategori Form PA</th>
                                            <th>Tahun Appraisal</th>
                                            <th>Nilai Evaluator</th>
                                            <th>Nilai Awal</th>
                                            <th>Item Pengurangan (ST/SP1/SP2/SP3)</th>
                                            <th>Nilai Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataAppraisal as $appr)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $appr->location_name }}</td>
                                            <td>{{ $appr->nik }}</td>
                                            <td>{{ $appr->emp_fullname }}</td>
                                            <td>{{ date("d-m-Y", strtotime($appr->joined_date)) }}</td>
                                            <td>{{ $appr->job_title }}</td>
                                            <td>{{ $appr->division }}</td>
                                            <td>{{ $appr->department }}</td>
                                            <td>{{ $appr->employment_status == "Karyawan Tetap" ? "Tetap" : $appr->employment_status }}</td>
                                            <td class="text-center">{{ $appr->code_appraisal }}</td>
                                            <td>{{ $appr->period_year }}</td>
                                            <td align="right">{{ $appr->appraisal_value_per_evaluators }}</td>
                                            <td class="text-right">{{ number_format($appr->nilai_awal,0,',',',') }}</td>
                                            <td class="text-right">{{ $appr->item_pengurangan }}</td>
                                            <td class="text-right">{{ number_format($appr->nilai_akhir,0,',',',') }}</td>
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
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#periodYear").datepicker( {
            format: "yyyy",
            startView: "months", 
            minViewMode: "months"
        });

        $('#periodYear').on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        
        // $('.datepicker').datepicker({
        //     format: 'dd/mm/yyyy',
        //     todayHighlight:'TRUE',
        //     autoclose: true,
        //     orientation: 'auto bottom'
        // });

        $('#banklist').dataTable();

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
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