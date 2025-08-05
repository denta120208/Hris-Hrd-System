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
            .judul{
                font-size: 14pt;
                font-family: Verdana, sans-serif;
                text-decoration: underline;
            }
            .judul2{
                font-size: 11pt;
                font-family: Verdana, sans-serif;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 10pt;
                font-family: Verdana, sans-serif;
            }
            .footer{
                font-size: 7pt;
                text-align: justify;
                font-family: Verdana, sans-serif;
            }
            th, td {
                padding: 1px;
            }
            table.contentdata{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 10pt;
                text-align: justify;
                font-family: Verdana, sans-serif;
            }
            div.headeratas{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 11pt;
                text-align: justify;
                font-family: Verdana, sans-serif;;
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
//            dd($employee->emp_end_date);
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
                        <div class ="judul"><strong>S U R A T &nbsp; K E P U T U S A N</strong></div>
                        <div class ="judul2"><strong>No. ../SK/METLAND/TGS/VI/23</strong></div><br><br>
                        <div class ="judul2"><strong>Tentang</strong><div>
                        <div class ="judul2"><strong>PENUGASAN JABATAN</strong><div><br><br>
                    </div>
                    <div class="headeratas">
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 15%; vertical-align: text-top;">
                                    <p>Menimbang</p>
                                </td>
                                <td style="width: 1%; vertical-align: text-top;">
                                    :
                                </td>
                                <td style="width: 84%; vertical-align: text-top;">
                                    <ol>
                                        <li>Adanya   kebutuhan  akan  jabatan   sebagai  ….	di Metland …. PT Metropolitan Land Tbk.</li>
                                        <li>Perlunya ditunjuk seseorang untuk bertugas dan bertanggung jawab dalam jabatan tersebut.</li>
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    <p>Memperhatikan</p>
                                </td>
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    <ol>
                                        <li>Persetujuan Direksi.</li>
                                    </ol>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    <p>Mengingat</p>
                                </td>
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    <ol>
                                        <li>Peraturan Perusahaan PT Metropolitan Land Tbk.</li>
                                        <li>Persetujuan Direksi.</li>
                                    </ol>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td colspan='3'>
                                    <div style="text-align: center"><strong>M E M U T U S K A N</strong><div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%; vertical-align: text-top;">
                                    <strong>Menetapkan</strong>
                                </td>
                                <td style="width: 3%; vertical-align: text-top;">
                                    :
                                </td>
                                <td style="width: 82%; vertical-align: text-top;">
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    Pertama
                                </td>
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    Terhitung tanggal <strong>......</strong> menugaskan <strong>Sdr. {{$fullName}}</strong> dengan jabatan <strong>…  (Junior …) Metland … – PT …  </strong> ke jabatan <strong>…. (Junior …) Metland … – PT …</strong>.
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    Kedua
                                </td>
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    Pelaksanaan tugas berpedoman kepada Job Description dan peraturan yang berlaku di PT Metropolitan Land Tbk dan bertanggung jawab kepada ….. – PT …..
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    Ketiga
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    Bahwa jabatan yang dibebankan hendaknya dilaksanakan dengan penuh rasa tanggung jawab.
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top;">
                                    Keempat
                                <td style="vertical-align: text-top;">
                                    :
                                </td>
                                <td style="vertical-align: text-top;">
                                    Apabila di kemudian hari ternyata terdapat kekurangan/ kekeliruan dalam Surat Keputusan ini, maka akan diadakan perubahan atau perbaikan seperlunya.
                                </td>
                            </tr>
                        </table>
                        <br><br>
                        
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 50%; vertical-align: text-top">
                                    
                                </td>
                                <td style="width: 50%">
                                    Ditetapkan di : Bekasi
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Kepada ybs : 
                                </td>
                                <td style="text-decoration: underline">
                                    Pada taggal : {{$nowFormat}}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                </td>
                                <td>
                                    <strong>PT. METROPOLITAN LAND Tbk</strong>
                                </td>
                            </tr>
                            <tr style="height: 75px;">
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    
                                </td>
                                <td>
                                    <strong>{{$fullName}}</strong>
                                </td>
                            </tr>
                        </table>
                        <br><br>
                        <div class="footer">
                            <div>Tembusan:</div>
                            <ol>
                                <li>
                                    Direksi
                                </li>
                                <li>
                                    General Manager
                                </li>
                                <li>
                                    Arsip
                                </li>                                
                            </ol>
                        </div>
                    </div>
                </center>
            </div>
            <br><br>
        </div>
    </body>
</html>