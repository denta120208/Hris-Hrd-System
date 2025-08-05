<html>
    <header>
        <script>
            $(document).ready(function() 
            {
                $('#cicilan_table').DataTable();
            } );
        </script>
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
                            <p><b>Appraisal Report</b></p>
                            <p><b>Project : {{ $locationData }}</b></p>
                            <!-- <p><b>Dir Ops : {{ $diropsData }}</b></p> -->
                            <p><b>Period Appraisal : {{ $year }}</b></p>
                        </div>
                </center>
            </div>
        </div>
        <br>
        <br>
        <?php $no = 1; ?>
        <table class="table1 stripe hover compact" id="appraisalTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <!-- <th>Project</th> -->
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Join Date</th>
                    <th>Level</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Status Karyawan</th>
                    <th>Kategori Form PA</th>
                    <!-- <th>Tahun Appraisal</th> -->
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
                    <!-- <td>{{ $appr->location_name }}</td> -->
                    <td>{{ $appr->nik }}</td>
                    <td>{{ $appr->emp_fullname }}</td>
                    <td>{{ date("d-m-Y", strtotime($appr->joined_date)) }}</td>
                    <td>{{ $appr->job_title }}</td>
                    <td>{{ $appr->division }}</td>
                    <td>{{ $appr->department }}</td>
                    <td>{{ $appr->employment_status == "Karyawan Tetap" ? "Tetap" : $appr->employment_status }}</td>
                    <td align="center">{{ $appr->code_appraisal }}</td>
                    <!-- <td>{{ $appr->period_year }}</td> -->
                    <td align="right">{{ $appr->appraisal_value_per_evaluators }}</td>
                    <td align="right">{{ number_format($appr->nilai_awal,0,',',',') }}</td>
                    <td align="right">{{ $appr->item_pengurangan }}</td>
                    <td align="right">{{ number_format($appr->nilai_akhir,0,',',',') }}</td>
                </tr>
                <?php $no++; ?>
                @endforeach
            </tbody>
        </table>

        <br><br><br>

        <table class="table1" id="table1" style="border: none;" width="100%" >
            <tr>
                @if($locationData == 'Kantor Pusat' || $locationData == 'All Project')
                <th colspan="6" style="text-align: center;">Menyetujui</th>
                @else
                <th colspan="2" style="text-align: center;">Menyetujui</th>
                @endif
            </tr>
            <tr>
                @if($locationData == 'Kantor Pusat' || $locationData == 'All Project')
                <td style="text-align: center;"><br><br><br><br><br></td>
                <td style="text-align: center;"><br><br><br><br><br></td>
                <td style="text-align: center;"><br><br><br><br><br></td>
                <td style="text-align: center;"><br><br><br><br><br></td>
                <td style="text-align: center;"><br><br><br><br><br></td>
                @else
                <td style="text-align: center;"><br><br><br><br><br></td>
                @endif
                <td style="text-align: center;"><br><br><br><br><br></td>
            </tr>
            <tr>
                @if($locationData == 'Kantor Pusat' || $locationData == 'All Project')
                <td style="text-align: center;width:200px">Wahyu Sulistio<br><br>Direktur</td>
                <td style="text-align: center;width:200px">Nitik Hening Muji Raharjo<br><br>Direktur</td>
                <td style="text-align: center;width:200px">Andi Surya Kurnia<br><br>Direktur</td>
                <td style="text-align: center;width:200px">Santoso<br><br>Direktur</td>
                <td style="text-align: center;width:200px">Olivia Surodjo<br><br>Direktur</td>
                @elseif($locationData == 'Metland Transyogi Cibubur' || $locationData == 'Metland Cileungsi' ||
                    $locationData == 'Hotel Horison Ultima Seminyak' || $locationData == 'Horison Ume Suites & Villas' ||
                    $locationData == 'Horison Ultima Kertajati' || $locationData == 'Metland Hotel Cirebon')
                    <td style="text-align: center;width:200px">Wahyu Sulistio<br><br>Direktur</td>
                @elseif($locationData == 'Metland Tambun' || $locationData == 'Metland Cibitung' ||
                    $locationData == 'Metland Cikarang' || $locationData == 'Metland Kertajati')
                    <td style="text-align: center;width:200px">Nitik Hening Muji Raharjo<br><br>Direktur</td>
                @elseif($locationData == 'Recreation & Sport Facility')
                    <td style="text-align: center;width:200px">Andi Surya Kurnia<br><br>Direktur</td>
                @elseif($locationData == 'Mal Metropolitan Bekasi' || $locationData == 'M Gold Tower' ||
                    $locationData == 'Grand Metropolitan Mall' || $locationData == 'Mal Metropolitan Cileungsi' ||
                    $locationData == 'Kaliana Apartment')
                    <td style="text-align: center;width:200px">Santoso<br><br>Direktur</td>
                @elseif($locationData == 'Metland Menteng' || $locationData == 'Metland Puri' ||
                    $locationData == 'Metland Cyber Puri' || $locationData == 'Hotel Horison Ultima Bekasi' || 
                    $locationData == 'Plaza Metropolitan' || $locationData == 'Metland Hotel Bekasi' || $locationData == 'One District Puri')
                    <td style="text-align: center;width:200px">Olivia Surodjo<br><br>Direktur</td>
                @endif
                <td style="text-align: center;width:200px">Anhar Sudradjat<br><br>Direktur Utama</td>
            </tr>
        </table>
    </body>
</html>