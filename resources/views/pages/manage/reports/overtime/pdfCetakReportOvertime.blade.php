<html>
    <header>
        <style>
            @page { margin: 10mm;}
            div.headeratas{
                padding-left: 2em;
                margin-left: 9em;
                text-align:center;
                margin-top:-1em;
                font-size: 10px
            }

            div.headeratas5{
                padding-left: 2em;
                margin-left: 9em;
                text-align:center;
                margin-top:5em;
                font-size: 10px
            }

            div.headeratastengah{
                padding-left: 2em;
                /*margin-left: 8em;*/
                text-align:left;
                margin-top:-1em;
                margin-left:20em;
                font-size: 10px
            }
            div.headerbawahtengah{
                padding-left: 2em;
                margin-left: -1em;
                text-align:center;
                margin-top: 1em;
                font-size: 12px;
            }
            div.headerbawahtengah2{
            /*    padding-left: 5em;*/
                margin-top: 1em;
                font-size: 12px;
            }
            div.headerbawahtengah3{
            /*    padding-left: 5em;*/
                margin-top: 1em;
                font-size: 14px;
            }

            div.headerataskiri{
                text-align:left;
                margin-right:-7em;
                margin-top: -1em;
            }

            div.headerataskiri5{
                text-align:left;
                margin-right:-7em;
                margin-top: -30px;
                font-size: 9px;
            }

            div.headeratastengah5{
                padding-left: 2em;
                /*margin-left: 8em;*/
                text-align:left;
                margin-top: -30px;
                margin-left:20em;
                font-size: 9px;
            }

            div.headerataskanan5{
                margin-top:-30px;
                text-align:right;
                font-size: 9px;
            }
            div.headerbawahtengah5{
            /*    padding-left: 5em;*/
                margin-left: 5em;
                text-align:center;
                margin-top: 1em;
                font-size: 12px;
            }

            div.headerbawahkiri{
                text-align:left; 
            }
            div.headerataskanan{
                margin-top:2em;
                text-align:right;
                 font-size: 8px;
            }

            div.headerbawahkanan{
                margin-top:-3em;
                text-align:right;
                font-size: 8px;
            }
            table.kananatas{
                align:right;
            }

            div.tanggalbawah{
                 text-align: left;
                 font-size: 11px;
            }


            div.ttdatas{
               margin-top:0em;

               text-align: left;
               font-size: 11px;
            }

            div.ttdbawah{
               margin-top:2em;
               text-align: left;
            }

            div.salesbawah{
               margin-top:0em;
               margin-right:8em;
               margin-bottom:5em;
               text-align: right;
            }

            div.bawah{
               margin-right:6em;
               text-align: right;
            }

            div.tableCustomer{
                 text-align:left;
                 margin-left: 2em;
                 padding-left: 2em;
            }
            div.termAndConditionAtas{
                 text-align:left;
                 font-size: 10px;
                 margin-bottom:-1em;
            }

            div.termAndConditionBawah{
                 text-align:left;
                 margin-left: 3em;
                 font-size: 10px;
            }
            div.termAndConditionNextPage{
                 text-align:left;
                 padding: 1em;
                 font-size: 12px;
                 margin-top:0em;
            }

            div.rekeningAtasTermConditions{
                 text-align:center;
                 margin-left: 2em;
                 font-size: 12px;
            }
            div.rekeningBawahTermConditions{
                 text-align:center;
                 margin-left: -2em;
                 font-size: 12px;
            }

            div.Customer{
                padding-left: 3em;
                font-size: 11px;
            }

            div.dataBookingEntry{
                 font-size: 11px;
                 margin-top: -5em;
            }

            div.page-break {
                page-break-after: always;
            }

            div.tabelCicilan{
                font-size: 13px;
                text-align: center;
                padding: 1em;
                padding-bottom: 1em;
            }

            div.parafTermCondition{
                 text-align: right;
                 font-size: 11px;    
            /*     margin-bottom: -1000px;  */
            }


            .table1 thead{
                font-size: 11px;
                text-align: center;
                margin-bottom: 1em;  
            }
            .table1 tbody{
                font-size: 11px;
                text-align: left;
            }
            
            .table1 {
                border-collapse: collapse;
            }

            .table1, .table1 th, .table1 td {
                border: 1px solid black;
                padding: 7px;
            }

            /* @media print { */
            #watermark {
                position: fixed;
                top: 50px;
                left: 10%;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }

            #watermark p {
                position: absolute;
                top: 50px;
                left: 10%;
                right: 0;
                bottom: 0;
                font-size: 100px;
                color: #0c0c0c;
                font-size: 130px;
                font-family: "Arial Black", "Arial Bold";
                opacity: 0.15;
                pointer-events: none;
            }

            @page :left {
                @top-left {
                    content: element(watermark);
                }
            }

            @page :right {
                @top-right {
                    content: element(watermark);
                }
            }
            /* } */
        </style>
    </header>
    <body>
    <div class="row">
        <div id="watermark">
            <p>Metland</p>
        </div>
    </div>
        <div class="row">
            <div>
                <center>
                    <div class="headerbawahtengah">
                        <h2><b>Overtime Report</b></h2>
                        <h3><b>{{ $location_name }}</b></h3>
                        <h3><b>{{ date("d/m/Y", strtotime($start_date)) }} - {{ date("d/m/Y", strtotime($end_date)) }}</b></h3>
                    </div>
                </center>
            </div>
        </div>
        <hr>
        <?php $no = 1; ?>
        <table class="table1 stripe hover compact" cellspacing="0" width="100%">
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
    </body>
</html>

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
