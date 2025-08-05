<html>
    <header>
        <style>
            @page {
                margin:75,84px
            }
            /*            table, tr {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }*/
            .tablesection1{
                border: 1px solid black;
                border-collapse: collapse;
            }
            .judul{
                font-size: 15pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
                text-decoration: underline;
            }
            .judul2{
                font-size: 12pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            .textblue{
                color: blue;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 12pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            .textsection2{
                text-align: center;
                font-size: 8pt;
            }
            .datadiri{
                text-align: left;
                font-size: 8pt;
            }
            .contenttext{
                text-align: left;
                font-size: 8pt;
                font-weight: bold
            }
            th, td {
                padding: 1px;
            }
            table.contentdata{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 12pt;
                text-align: justify;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            div.headeratas{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 12pt;
                text-align: justify;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            div.headeratas2{
                padding-left: 2em;
                margin-left: 9em;
                text-align:center;
                margin-top:-1em;
                font-size: 10px
            }
            div.bodytengah1{
                padding-left: 2em;
                margin-left: 9em;
                text-align:center;
                margin-top:-1em;
                font-size: 10px
            }
            div.headerbawah{
                margin-top:-3em;
                text-align:right;
                font-size: 8px;
            }

        </style>
    </header>
    <!--<body onload="window.print()">-->
    <body onload="window.print()">
    <!--<body>-->
        <div class="row">
            <!--TEMPAT LAMPIRAN-->
            <?php

            function indonesianDate($tanggal) {
                $bulan = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
                $pecahkan = explode('-', $tanggal);

                // variabel pecahkan 0 = tahun
                // variabel pecahkan 1 = bulan
                // variabel pecahkan 2 = tanggal

                return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
            }

            $terminationDate = indonesianDate(date('Y-m-d', strtotime($employee->termination_date)));
            $empJoinDate = indonesianDate(date('Y-m-d', strtotime($employee->emp_join_date)));
            $nowFormat = indonesianDate(date('Y-m-d', strtotime($now)));

            $fullName = ($employee->emp_firstname != null) ? $employee->emp_firstname : "";
            $fullName .= ($employee->emp_middle_name != null) ? " " . $employee->emp_middle_name : "";
            $fullName .= ($employee->emp_lastname != null) ? " " . $employee->emp_lastname : "";
            ?>
            <div>
                <center>

                    <div>
                        <br>
                        <br>
                        <br>
                        <div class ="judul">
                            <strong>S U R A T &emsp; K E T E R A N G A N</strong>
                        </div>
                        <div class="judul2">
                            <strong>No. ___/Ket/HRD/Metland/__/__</strong>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="headeratas">
                        <p>Yang bertanda tangan dibawah ini :</p><br>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 20%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 10%">
                                    : 
                                </td>
                                <td style="width: 70%">
                                    <strong> Herlan Maulana Muhammad </strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Jabatan
                                </td>
                                <td>
                                    : 
                                </td>
                                <td>
                                    <strong> General Manager HRD & GA </strong>
                                </td>
                            </tr>
                            <tr >
                                <td style="vertical-align: text-top">

                                </td>
                                <td>
                                </td>
                                <td>
                                    <strong> PT Metropolitan Land, Tbk </strong>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <p>Menerangkan bahwa :</p>
                        <br>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 20%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 10%">
                                    : 
                                </td>
                                <td style="width: 70%">
                                    <strong> {{$fullName}} </strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Jabatan
                                </td>
                                <td>
                                    : 
                                </td>
                                <td>
                                    <strong> {{$employee->job_level}} </strong>
                                </td>
                            </tr>
                            <tr >
                                <td style="vertical-align: text-top">

                                </td>
                                <td>
                                </td>
                                <td>
                                    <strong> PT Metropolitan Land, Tbk </strong>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <p>Adalah benar karyawan di PT Metropolitan Land, Tbk terhitung sejak tanggal {{$empJoinDate}} sampai dengan {{$terminationDate}} dengan jabatan tersebut diatas. </p><br>
                        <div>Yang bersangkutan mengundurkan diri atas permintaan sendiri.</div>
                        <div>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sesuai keperluan.</div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 60%; vertical-align: text-top">

                                </td>
                                <td style="width: 40%">
                                    Bekasi, {{$nowFormat}}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">

                                </td>
                                <td>
                                    <strong> PT Metropolitan Land, Tbk </strong>
                                </td>
                            </tr>
                            <tr style="height: 75px;">
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">

                                </td>
                                <td style="text-decoration: underline;">
                                    Herlan Maulana Muhammad
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">

                                </td>
                                <td>
                                    General Manager HRD & GA
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div>
            <br><br>
        </div>
    </body>
</html>