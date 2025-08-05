@extends('_main_layout')

@section('title', 'Terminate Report')

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb"></ul>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <h3 class="header smaller lighter blue" style="margin-top: 5px; margin-bottom: 25px;">Report Karyawan Terminate</h3>
                    
                    <!-- Filter -->
                    <div class="well">
                        <form method="GET" action="{{ route('report_emp_terminate') }}" id="filterForm">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>start Date</label>
                                                <input type="date" name="start_date" class="form-control" value="{{ isset($startDate) ? $startDate : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input type="date" name="end_date" class="form-control" value="{{ isset($endDate) ? $endDate : '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Project</label>
                                                <select name="project_id" class="form-control select2">
                                                    <option value="">--Pilih Project--</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" {{ (isset($projectId) && $projectId == $project->id) ? 'selected' : '' }}>
                                                            {{ $project->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Data -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Data Karyawan Terminate</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Department</th>
                                            <th>End Date</th>
                                            <th>Reason</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($arr) && count($arr) > 0)
                                            @foreach($arr as $key => $employee)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $employee->nik }}</td>
                                                    <td>{{ $employee->emp_fullname }}</td>
                                                    <td>{{ isset($employee->dept) ? $employee->dept : '-' }}</td>
                                                    <td>{{ isset($employee->termination_date) ? date('d-m-Y', strtotime($employee->termination_date)) : '-' }}</td>
                                                    <td>{{ isset($employee->reason) ? $employee->reason : '-' }}</td>
                                                    <td>{{ isset($employee->unit) ? $employee->unit : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endif
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

@push('styles')
<style>
.well {
    margin-bottom: 15px;
    padding: 15px;
    background-color: #f5f5f5;
}
.form-group {
    margin-bottom: 10px;
}
.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
}
.panel {
    margin: 15px 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 0;
    box-shadow: none;
    max-width: 100%;
}
.panel-heading {
    padding: 8px 12px;
    background: #fff;
    border-bottom: 2px solid #ddd;
}
.panel-body {
    padding: 10px;
}
.panel-title {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
}
.table {
    margin-bottom: 0;
    font-size: 13px;
}
.table th {
    background: #fff;
    font-weight: 600;
    border-bottom: 2px solid #ddd !important;
    padding: 6px !important;
}
.table > thead > tr > th,
.table > tbody > tr > td {
    padding: 6px !important;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #ddd;
}
.table-hover > tbody > tr:hover {
    background-color: #f9f9f9;
}
.table > tbody > tr:last-child > td {
    border-bottom: none;
}
.select2-container {
    width: 100% !important;
}
.justify-content-center {
    display: flex;
    justify-content: center;
}
.row {
    margin-left: -10px;
    margin-right: -10px;
}
.col-md-2, .col-md-3, .col-md-4 {
    padding-left: 10px;
    padding-right: 10px;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Pilih Project",
        allowClear: true,
        width: '100%'
    });

    $('#filterForm').on('submit', function(e) {
        var startDate = $('input[name="start_date"]').val();
        var endDate = $('input[name="end_date"]').val();
        
        if (!startDate || !endDate) {
            e.preventDefault();
            swal({
                title: "Peringatan",
                text: "Mohon isi tanggal mulai dan tanggal akhir",
                type: "warning"
            });
        }
    });
});
</script>
@endpush

@endsection