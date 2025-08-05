@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#start_date,#end_date').datetimepicker({
            useCurrent: false,
            format: 'Y-m-d',
            timepicker: false,
            // minDate: moment()
        });
        $('#start_date').datetimepicker().on('dp.change', function (e) {
            // var incrementDay = moment(new Date(e.date));
            // incrementDay.add(1, 'days');
            $('#end_date').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        $('#end_date').datetimepicker().on('dp.change', function (e) {
            // var decrementDay = moment(new Date(e.date));
            // decrementDay.subtract(1, 'days');
            $('#start_date').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
            scrollX: "120%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 50,
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
    });
</script>

<div class="container">
    <div class="row">
        <h2>Summary Attendance</h2>
        <form action="{{ route('hrd.rekap_absen') }}" method="post" class="form-inline">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="start_date">Start Date</label><br>
                    <input class="form-control" type="text" name="start_date" id="start_date" autocomplete="off" readonly="yes" />
                </div>
                <div class="form-group">
                    <label for="end_date">End Date</label><br>
                    <input class="form-control" type="text" name="end_date" id="end_date" autocomplete="off" readonly="yes"/>
                </div>
                <div class="form-group">
                    <label for="employee_id">Project</label><br>
                    <?php
                    if (session("project") == "HO" && Session::get('username') <> 'hrd_busdev') { // Jika Kantor Pusat Maka Semua Project Kebuka
                        $project = \App\Models\Master\Location::where('is_active', '=', 1)
                                ->orderBy('name', 'ASC')
                                ->lists('name', 'id')
                                ->prepend('-=Pilih=-', '0');
                    } else {
                        $project = \App\Models\Master\Location::where("code", session("project"))->lists('name', 'id');
                    }

                    // $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                    ?>
                    {!! Form::label('project', 'Project', ['class'=>'sr-only']) !!}
                    {!! Form::select('project', $project, '', ['class' => 'form-control', 'id' => 'project']) !!}
                </div>
                <div class="form-group pull-right" style="margin-right:440px;">
                    <label style="visibility: hidden;">action</label><br>
                    <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
        @if($dataAbsen <> 0)
        <div style="margin-bottom: 140px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="empTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No.</th> 
                                <th>NIK</th>
                                <th>Nama</th>
                                <?php $x = 3; ?>
                                @for($i = new DateTime($start_date); $i <= new DateTime($end_date); $i->modify('+1 day'))
                                <th id="{{ $x }}">{{ $i->format('m-d') }}</th>
                                <?php $x++; ?>
                                @endfor
                                <th style="font-weight: bold;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($arr as $row)
                            <?php
                            $add = 0;
                            $begin2 = new DateTime($start_date); // 203.77.232.195
                            $end2 = new DateTime($end_date);
                            ?>
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{ $row->comNIP }}</td>
                                <td>{{ $row->emp_fullname}}</td>
                                @for($i = $begin2; $i <= $end2; $i->modify('+1 day'))
                                <?php
                                $tgl = $i->format('Y-m-d');
                                $add += $row->$tgl;
                                ?>
                                @if($row->$tgl == 0.5)
                                <td>0.5</td>
                                @elseif($row->$tgl == 1.0)
                                <td>1</td>
                                @elseif($row->$tgl == 2.0)
                                <td>1 - KJ</td>
                                @else
                                <td>0</td>
                                @endif
<!--                                <td>{{$i->format('Y-m-d')}}</td>-->
<!--                                <td>@if($row->$tgl != NULL){{ $row->$tgl }} @else 0.0 @endif</td>-->
                                @endfor
                                <td>{{ $add }}</td>
                            </tr>
                            <?php $no += 1; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
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