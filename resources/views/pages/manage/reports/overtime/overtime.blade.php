@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#table1').DataTable({
            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Overtime Report'
                }
            ]
        });
    });
</script>

<div class="container">
    <h2>Overtime Report</h2>
    <div class="row" style="padding-top: 20px;">
        <form action="{{ route('viewOvertimeReport') }}" method="get">
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('Project') !!}&nbsp;<span style="color: red;"><b>*</b></span>
                    <select class="form-control" name="location_id" id="location_id" required>
                        <option value="">--- Not Selected ---</option>
                        @foreach($dataLocation as $data)
                        <option value="{{ $data->id }}" {{ $param['location_id'] == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    {!! Form::label('Start Date') !!}&nbsp;<span style="color: red;"><b>*</b></span>
                    <input type="date" class="form-control" name="start_date_param" id="start_date_param" value="{{ $param['start_date'] }}" required />
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    {!! Form::label('End Date') !!}&nbsp;<span style="color: red;"><b>*</b></span>
                    <input type="date" class="form-control" name="end_date_param" id="end_date_param" value="{{ $param['end_date'] }}" required />
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group">
                    <label style="visibility: hidden;">action</label><br>
                    <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
        <div style="margin-bottom: 100px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                @if($IS_POST)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <a target="_blank" class="btn btn-sm btn-info" href="{{ URL('/printOvertimeReport/' . $param['location_id'] . '/' . $param['start_date'] . '/' . $param['end_date']) }}" onclick="window.open(this.href).print(); return false">
                                Print Report Overtime
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <table id="table1" class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Level</th>
                                        <th rowspan="2">Division</th>
                                        <th rowspan="2">Department</th>
                                        @for($i = 1; $i <= 31; $i++)
                                        <th colspan="2" style="text-align: center;">{{ $i }}</th>
                                        @endfor
                                        <th rowspan="2">Total Diff</th>
                                        <th rowspan="2">Total OT</th>
                                    </tr>
                                    <tr>
                                        @for($i = 1; $i <= 31; $i++)
                                        <th>Diff</th>
                                        <th>OT</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataOvertimeReport as $key => $data)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $data->employee_id }}</td>
                                        <td>{{ $data->emp_fullname }}</td>
                                        <td>{{ $data->job_title }}</td>
                                        <td>{{ $data->division }}</td>
                                        <td>{{ $data->department }}</td>
                                        <?php $total_diff = 0; $total_ot = 0; ?>
                                        @for($i = 1; $i <= 31; $i++)
                                        <?php
                                            $hours = 0;
                                            $total_hours = 0;
                                            $hours = 0;
                                            $total_hours = 0;
                                            foreach($data->details as $item) {
                                                $item->ot_date = formatDate($item->ot_date);
                                                $day = date("d", strtotime($item->ot_date));
                                                $day = (int) $day;
                                                if($day == $i) {
                                                    $hours += (float) $item->ot_hours;
                                                    $total_hours += (float) $item->ot_total_hours;
                                                    $total_diff += $hours;
                                                    $total_ot += $total_hours;
                                                }
                                            }
                                        ?>
                                        <td>{{ $hours }}</td>
                                        <td>{{ $total_hours }}</td>
                                        @endfor
                                        <?php $total_ot = ($total_ot > 56 ? 56 : $total_ot); ?>
                                        <td>{{ $total_diff }}</td>
                                        <td>{{ $total_ot }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('start_date_param').addEventListener('change', function() {
        var startDate = this.value;

        // Jika start_date dipilih, hitung tanggal maksimal 30 hari setelahnya
        if (startDate) {
            var startISO = new Date(startDate);
            var minEndDate = startISO.toISOString().split('T')[0];

            // kosongkan nilai end_date_param
            document.getElementById('end_date_param').value = null;

            // Set nilai min pada end_date_param
            document.getElementById('end_date_param').setAttribute('min', minEndDate);
        }
        else {
            // Reset nilai min dan max end_date_param jika start_date kosong
            document.getElementById('end_date_param').removeAttribute('min');
            document.getElementById('end_date_param').value = null;  // Reset nilai end_date
        }
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
