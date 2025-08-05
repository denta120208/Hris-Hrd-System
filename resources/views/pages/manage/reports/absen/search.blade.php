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
        $(document).ready(function(){
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
                timepicker:false,
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
            <h2>Attendance Emp</h2>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="{{ route('hrd.rekap_perorang') }}" method="post" class="form-inline">
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
                            <label for="end_date">Employee</label><br>
                            <input class="form-control" type="text" name="comDisplayName" id="comDisplayName" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label for="end_date">NIK</label><br>
                            <input class="form-control" type="text" name="comNIP" id="comNIP" autocomplete="off"/>
                        </div>
                        <div class="form-group">
                            <label for="employee_id">Project</label><br>
                            <?php
                                if(session("project") == "HO" && Session::get('username') <> 'hrd_busdev') { // Jika Kantor Pusat Maka Semua Project Kebuka
                                    $project = \App\Models\Master\Location::where('is_active','=',1)->orderBy("name", "ASC")->lists('name','id')->prepend('-=Pilih=-', '0');
                                }
                                else {
                                    $project = \App\Models\Master\Location::where("code", session("project"))->orderBy("name", "ASC")->lists('name','id');
                                }
                                
                                // $project = \App\Models\Attendance\ComDept::lists('comDept','id')->prepend('-=Pilih=-', '0');
                            ?>
                            {!! Form::label('project', 'Project', ['class'=>'sr-only']) !!}
                            {!! Form::select('project', $project, '', ['class' => 'form-control', 'id' => 'project']) !!}
                        </div>
                        <button class="btn btn-success" style="margin-top: 20px;">Search</button>
                    </div>
                </form>
            </div>
            <br><br>
            <div style="margin-bottom: 60px;"></div>
            @if($IS_POST == true)
            <?php
                DataTables::create([
                    'name' => 'reportTable1',
                    'dataSource' => $report->dataStore('rekap_perorang_table1'),
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
//                        $dataDetails = DB::select(
//                            "select b.comNIP,(a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) as comDisplayName,
//                                FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
//                                convert(char(8),convert(time(0),b.comIn)) as comIn,
//                                convert(char(8),convert(time(0),b.comOut)) as comOut,
//                                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday')
//                                THEN
//                                    FORMAT(DATEADD(HOUR, 0, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
//                                ELSE
//                                    CASE WHEN (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 0
//                                    THEN
//                                        FORMAT(DATEADD(HOUR, 0, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
//                                    ELSE
//                                        FORMAT(DATEADD(HOUR, -1, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
//                                    END
//                                END
//                                AS comTotalHours,
//                                termination_id,
//                                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday')
//                                THEN
//                                    DATEPART(HOUR, CONVERT(TIME, b.comTotalHours))
//                                ELSE
//                                    CASE WHEN (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 0
//                                    THEN
//                                        DATEPART(HOUR, CONVERT(TIME, b.comTotalHours))
//                                    ELSE
//                                        (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1)
//                                    END
//                                END
//                                AS workingHours,
//                                a.job_title_code,
//                                CASE WHEN b.comIjin_reason IS NULL OR CAST(b.comIjin_reason AS VARCHAR(MAX)) = ''
//                                THEN
//                                    b.comIjin
//                                ELSE
//                                    b.comIjin + ' - ' + CAST(b.comIjin_reason AS VARCHAR(MAX))
//                                END
//                                AS comIjin,
//                                DATENAME(WEEKDAY, b.comDate) AS HARI
//                                --FORMAT (b.comDate, 'dddd', 'id-id') AS HARI
//                            from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
//                            where a.termination_id = 0
//                            and b.comNIP IS NOT NULL
//                            ".$report->where_param."
//                            AND b.comNIP = '".$row['comNIP']."'
//                            ORDER BY b.comNIP,b.comDate"
//                        );
                        
                        $dataDetails = DB::select(
                            "select b.comNIP,a.emp_firstname,a.emp_middle_name,a.emp_lastname,
                                FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
                                convert(char(8),convert(time(0),b.comIn)) as comIn,
                                convert(char(8),convert(time(0),b.comOut)) as comOut,
                                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday')
                                THEN
                                    FORMAT(DATEADD(HOUR, 0, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
                                ELSE
                                    CASE WHEN (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 0
                                    THEN
                                        FORMAT(DATEADD(HOUR, 0, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
                                    ELSE
                                        FORMAT(DATEADD(HOUR, -1, CAST(b.comTotalHours AS VARCHAR(MAX))), 'HH:mm:ss')
                                    END
                                END
                                AS comTotalHours,
                                termination_id,
                                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday')
                                THEN
                                    DATEPART(HOUR, CONVERT(TIME, b.comTotalHours))
                                ELSE
                                    CASE WHEN (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 0
                                    THEN
                                        DATEPART(HOUR, CONVERT(TIME, b.comTotalHours))
                                    ELSE
                                        (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1)
                                    END
                                END
                                AS workingHours,
                                a.job_title_code,
                                CASE WHEN b.comIjin_reason IS NULL OR CAST(b.comIjin_reason AS VARCHAR(MAX)) = ''
                                THEN
                                    b.comIjin
                                ELSE
                                    b.comIjin + ' - ' + CAST(b.comIjin_reason AS VARCHAR(MAX))
                                END
                                AS comIjin,
                                DATENAME(WEEKDAY, b.comDate) AS HARI
                                --FORMAT (b.comDate, 'dddd', 'id-id') AS HARI
                            from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
                            where a.termination_id = 0
                            and b.comNIP IS NOT NULL
                            ".$report->where_param."
                            AND b.comNIP = '".$row['comNIP']."'
                            ORDER BY b.comNIP,b.comDate"
                        );
                        
                        $dataDetails = collect($dataDetails);


                        $dataDetails->transform(function ($dataDetail) {
                            $dataDetail->comDisplayName = $dataDetail->emp_firstname." ".$dataDetail->emp_middle_name." ".$dataDetail->emp_lastname; 
                            return $dataDetail;
                        });

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
                                'comDisplayName' => [
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
                                // 'workingHours' => [
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
                                'job_title_code' => [
                                    'label' => 'Jabatan',
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
                                'columnDefs' => [['visible' => false, 'targets' => [7,8]]],
                                'createdRow' => 'function(row, data, dataIndex) {
                                    var hari = data.HARI;
                                    var comIn = data.comIn;
                                    var workingHours = parseFloat(data.workingHours);
                                    var comIjin = data.comIjin;
                                    var job_title_code = data.job_title_code;
                                    if(job_title_code === "11" || job_title_code === "12" || job_title_code === "13" || job_title_code === "14" || job_title_code === "15" || job_title_code === "16" || job_title_code === "17" || job_title_code === "18") { // VICE GENERAL MANAGER Ke Atas
                                    }
                                    else { // SENIOR MANAGER Ke Bawah
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
@endsection