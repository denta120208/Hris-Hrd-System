@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<div class="container">
    <h2>Komposisi Employee Report</h2>
    <div style="margin-bottom: 50px;"></div>
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
                $emp_status = \App\Models\Master\EmploymentStatus::lists('name', 'id')->prepend('Employment Status', '0');
                ?>
                {!! Form::label('emp_status', 'Employment Status', ['class'=>'sr-only']) !!}
                {!! Form::select('emp_status', $emp_status, '', ['class' => 'form-control', 'id' => 'emp_status']) !!}
            </div>
            <div class="form-group">
                <?php
                $jobCategory = \App\Models\Employee\JobCategory::lists('name', 'id')->prepend('Divisi', '0');
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1;
                    $kt = $kr = $tkt = $tkr = 0; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Nos</th>
                                <th>Proyek</th>
                                <th>Tetap</th>
                                <th>Kontrak</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            @if($data->pnum == '1803')
                            <tr>
                                <td>{{ $no }}</td>
                                <td>Pusat & Residensial</td>
                                <td>{{ $data->karyawan_tetap }}</td>
                                <td>{{ $data->kontrak }}</td>
                                <td>{{ $data->karyawan_tetap + $data->kontrak }}</td>
                            </tr>
                            <?php $no++; ?>
                            @else
                            <?php
                            $kt += $data->karyawan_tetap;
                            $kr += $data->kontrak;
                            ?>
                            @endif
                            <?php
                            $tkt += $data->karyawan_tetap;
                            $tkr += $data->kontrak;
                            ?>
                            @endforeach
                            <tr>
                                <td>{{ $no }}</td>
                                <td>Komersial</td>
                                <td>{{ $kt }}</td>
                                <td>{{ $kr }}</td>
                                <td>{{ $kt + $kr }}</td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Grand Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $tkt + $tkr }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection