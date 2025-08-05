<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
use \koolreport\pivot\widgets\PivotTable;
use \koolreport\widgets\google\ColumnChart;
use \koolreport\drilldown\LegacyDrillDown;
use \koolreport\drilldown\DrillDown;
use \koolreport\datagrid\DataTables;
use Illuminate\Support\Str;
?>

@extends('_main_layout')

<style>
    .pagination>li>a, .pagination>li>span {
        padding: 0px !important;
        color: black !important;
        background-color: transparent !important;
        border-color: transparent !important;
    }

    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
        font-weight: bold;
        font-size: 120%;
        color: black !important;
        background-color: transparent !important;
        border-color: transparent !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        width: 100% !important;
    }

    .working-hours-less-than-eight-warning {
        background-color: yellow !important;
        color: black !important;
    }

    .working-hours-less-than-eight-danger {
        background-color: red !important;
        color: white !important;
    }
</style>

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#empTable').DataTable({
            dom: 'Bfrtip',
            pageLength: 50,
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
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
<div class="container">
    <div class="row">
        <h2>Attendance Emp DW</h2>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="{{ route('hrd.rekap_dw_perorang') }}" method="post" class="form-inline">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label for="start_date">Start Date *</label><br>
                        <input class="form-control" type="text" name="start_date" id="start_date" autocomplete="off" readonly="yes" required />
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date *</label><br>
                        <input class="form-control" type="text" name="end_date" id="end_date" autocomplete="off" readonly="yes" required />
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Project *</label><br>
                        <?php
                        if(session("project") == "HO" && Session::get('username') <> 'hrd_busdev') { // Jika Kantor Pusat Maka Semua Project Kebuka
                            $project = \App\Models\Master\Location::where('is_active','=',1)->orderBy("name", "ASC")->get();
                            //$project = \App\Models\Master\Location::where('is_active','=',1)->orderBy("name", "ASC")->lists('name','adms_dept_id')->prepend('-=Pilih=-', '0');
                            //dd($project);
                        }
                        else {
                            $project = \App\Models\Master\Location::where('is_active','=',1)->where("code", session("project"))->orderBy("name", "ASC")->get();
                            //$project = \App\Models\Master\Location::where("code", session("project"))->orderBy("name", "ASC")->lists('name','adms_dept_id');
                        }

//                        if (session("project") == "HO" && Session::get('username') <> 'hrd_busdev') { // Jika Kantor Pusat Maka Semua Project Kebuka
//                            $project = \App\Models\Master\Location::where('is_active', '=', 1)->orderBy("name", "ASC")->lists('name', 'adms_dept_id')->prepend('-=Pilih=-', '0');
//                        } else {
//                            $project = \App\Models\Master\Location::where("code", session("project"))->orderBy("name", "ASC")->lists('name', 'adms_dept_id');
//                        }

                        // $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                        ?>
                        {!! Form::label('project', 'Project', ['class'=>'sr-only']) !!}
                        <select class="form-control" name="project" id="project" required="yes">
                            <option value="0">-=Pilih=-</option>
                            @foreach($project as $pjt)
                            <option value="{{$pjt->adms_dept_id}}">{{$pjt->name}}</option>
                            @endforeach
                        </select>
<!--                        {!! Form::select('project', $project, '', ['class' => 'form-control', 'id' => 'project', 'required' => 'required']) !!}-->
                    </div>
                    <button class="btn btn-success" style="margin-top: 20px;">Search</button>
                </div>
            </form>
        </div>
        <br><br>
        <div style="margin-bottom: 60px;"></div>
        @if($IS_POST == true)
        <div class="data-table-list">
            <div class="table-responsive">
                <?php
                DataTables::create([
                    'name' => 'reportTable1',
                    'dataSource' => $report->dataStore('rekap_dw_perorang_table1'),
                    'themeBase' => 'bs4',
                    'showFooter' => false,
                    'cssClass' => [
                        'table' => 'table table-responsive table-striped'
                    ],
                    'columns' => [
                        'comNIP' => [
                            'label' => 'NIK',
                            'formatValue' => function ($value, $row) {
                                return $value;
                            }
                        ],
                        'comDisplayName' => [
                            'label' => 'Name',
                            'formatValue' => function ($value, $row) {
                                return $value;
                            }
                        ],
                        'JUMLAH_HARI' => [
                            'label' => 'Jumlah Hari',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'TOTAL_KEHADIRAN' => [
                            'label' => 'Jumlah Hadir',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'LESS_8_HOUR' => [
                            'label' => '< 8 Hours',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'S' => [
                            'label' => 'S',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'I' => [
                            'label' => 'I',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'TL' => [
                            'label' => 'TL',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CT' => [
                            'label' => 'CT',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'L' => [
                            'label' => 'L',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CL' => [
                            'label' => 'CL',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CB' => [
                            'label' => 'CB',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'OFF' => [
                            'label' => 'OFF',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CS' => [
                            'label' => 'CS',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CH' => [
                            'label' => 'CH',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'CK' => [
                            'label' => 'CK',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ],
                        'PV' => [
                            'label' => 'PV',
                            'formatValue' => function ($value, $row) {
                                return (float) $value;
                            }
                        ]
                    ],
                    'rowDetailData' => function ($row) use ($report) {
                        $stringRandom = Str::random(100);
                        $dataDetails = DB::select("EXEC sp_absen_employee_DW_detail '" . $row['comNIP'] . "', '" . $report->start_date_param . "', '" . $report->end_date_param . "', '" . $report->project_param . "'");

                        ob_start();
                        DataTables::create([
                            'name' => 'reportTable2' . $stringRandom,
                            'dataSource' => $dataDetails,
                            'themeBase' => 'bs4',
                            'showFooter' => false,
                            'cssClass' => [
                                'table' => 'table table-responsive table-striped'
                            ],
                            'columns' => [
                                // 'comNIP' => [
                                //     'label' => 'NIK',
                                //     'formatValue' => function ($value, $row) {
                                //         return $value;
                                //     }
                                // ],
                                'emp_fullname' => [
                                    'label' => 'Name',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'HARI' => [
                                    'label' => 'Day',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'comDate' => [
                                    'label' => 'Date',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'comIn' => [
                                    'label' => 'In',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'comOut' => [
                                    'label' => 'Out',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                // 'comTotalHours' => [
                                //     'label' => 'Total Hours',
                                //     'formatValue' => function ($value, $row) {
                                //         return $value . " Hours";
                                //     }
                                // ],
                                'comTotalHours' => [
                                    'label' => 'Total Hours',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'comIjin' => [
                                    'label' => 'Description',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ],
                                'workingHours' => [
                                    'label' => 'Waktu',
                                    'formatValue' => function ($value, $row) {
                                        return $value;
                                    }
                                ]
                            ],
                            'fastRender' => true,
                            'options' => [
                                "dom" => 'Blfrtip',
                                "buttons" => [
                                    'excel', 'pdf'
                                ],
                                'scrollX' => false,
                                'paging' => true,
                                'pageLength' => 10,
                                'searching' => true,
                                'autoWidth' => true,
                                'select' => false,
                                'columnDefs' => [['visible' => false, 'targets' => [7]]],
                                'createdRow' => 'function(row, data, dataIndex) {
                                    var hari = data.HARI;
                                    var comIn = data.comIn;
                                    var workingHours = parseFloat(data.workingHours);
                                    var comIjin = data.comIjin;
                                    if(comIjin === "" || comIjin === "-" || comIjin === null) {
                                        if(hari === "Saturday" || hari === "Sunday") {
                                        }
                                        else if (comIn <= "09:00:00" && workingHours < 8 && workingHours > 0) {
                                            $(row).find("td").addClass("working-hours-less-than-eight-warning");
                                        }
                                        else if(comIn > "09:00:00" || (comIn <= "09:00:00" && workingHours <= 0)) {
                                            $(row).find("td").addClass("working-hours-less-than-eight-danger");
                                        }
                                    }
                                }',
                            ],
                            'searchOnEnter' => false,
                            'searchMode' => 'or',
                        ]);
                        $dataReturn = ob_get_clean();

                        return $dataReturn;
                    },
                    'fastRender' => true,
                    'options' => [
                        "dom" => 'Blfrtip',
                        "buttons" => [
                            'excel', 'pdf'
                        ],
                        'scrollX' => true,
                        'paging' => true,
                        'pageLength' => 10,
                        'searching' => true,
                        'autoWidth' => true,
                        'select' => false
                    ],
                    'searchOnEnter' => false,
                    'searchMode' => 'or',
                ]);
                ?>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection