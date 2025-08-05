@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#pTable').DataTable({});

    });
</script>
<div class="container">
    <div class="row">
        <h1>Administration Document</h1>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('emp_name', 'Employee Name') !!}
                        <input type="text" class="form-control" id="emp_name" name="emp_name" value="{{ $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname }}" disabled="disabled" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('employee_id', 'NIK') !!}
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ $emp->employee_id }}" disabled="disabled" />
                    </div>
                </div>
            </form>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="pTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Document</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    
                                </td>
                                <td>
                                    Surat Pernyataan Berakhir Hubungan Kerja
                                </td>
                                <td>
                                    <a href="{{ route('Printout.printSuratPernyataanBerakhirHubunganKerja', $emp->emp_number) }}" target="_blank"><i class="fa fa-print" title="Print Surat Pernyataan Berakhir Hubungan Kerja"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    2
                                </td>
                                <td>
                                    Surat Pernyataan Menjaga Rahasia Perusahaan
                                </td>
                                <td>
                                    <a href="{{ route('Printout.printSuratPernyataanMenjagaRahasiaPerusahaan', $emp->emp_number) }}" target="_blank"><i class="fa fa-print" title="Print Surat Pernyataan Menjaga Rahasia Perusahaan"></i></a>
                                </td>
                            </tr>
                            @if($emp->emp_status == 3 || $emp->emp_status == 4)
                            <tr>
                                <td>
                                    3
                                </td>
                                <td>
                                    Surat Perintah Kerja
                                </td>
                                <td>
                                    <a href="{{ route('Printout.printSuratPerintahKerja', $emp->emp_number) }}" target="_blank"><i class="fa fa-print" title="Print Surat Perintah Kerja"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    4
                                </td>
                                <td>
                                    Surat Pernyataan Kontrak Kerja
                                </td>
                                <td>
                                    <a href="{{ route('Printout.printSuratPernyataanKontrakKerja', $emp->emp_number) }}" target="_blank"><i class="fa fa-print" title="Print Surat Pernyataan Kontrak Kerja"></i></a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection