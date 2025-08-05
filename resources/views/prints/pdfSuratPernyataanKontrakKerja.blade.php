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
                font-family: Tahoma, sans-serif;
            }
            .judul2{
                font-size: 10pt;
                font-family: Tahoma, sans-serif;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 10pt;
                font-family: Tahoma, sans-serif;
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
                font-family: Tahoma, sans-serif;
            }
            table.contentdata1{
                /*padding-left: 2em;*/
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 10pt;
                text-align: justify;
                font-family: Tahoma, sans-serif;
            }
            div.headeratas{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 10pt;
                text-align: justify;
                font-family: Tahoma, sans-serif;
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
            $empBirthday = indonesianDate(date('Y-m-d', strtotime($employee->emp_birthday)));

            $fullName = ($employee->emp_firstname != null) ? $employee->emp_firstname : "";
            $fullName .= ($employee->emp_middle_name != null) ? " " . $employee->emp_middle_name : "";
            $fullName .= ($employee->emp_lastname != null) ? " " . $employee->emp_lastname : "";
            ?>
            <div>
                <center>
                    <div>
                        <br>
                        <div class ="judul"><strong>SURAT PERNYATAAN</strong></div>	
                        <br>
                    </div>
                    <div class="headeratas">
                        <p>Yang bertandatangan di bawah ini:</p>
                        <br>
                        <table style="width: 100%" class="contentdata1">
                            <tr>
                                <td style="width: 25%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 75%">
                                    <p>:  {{$fullName}} </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Tempat/Tanggal Lahir
                                </td>
                                <td>
                                    : .../{{$empBirthday}}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    NIK
                                </td>
                                <td>
                                    : {{$employee->employee_id}}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    No. KTP
                                </td>
                                <td>
                                    : {{$employee->emp_ktp}}
                                </td>
                            </tr>
                            <tr style="height: 30px">
                                <td style="vertical-align: text-top">
                                    Alamat (sesuai KTP)
                                </td>
                                <td style="vertical-align: text-top">
                                    : {{$employee->emp_street1}}
                                </td>
                            </tr>
                            <tr style="height: 30px">
                                <td style="vertical-align: text-top">
                                    Korespondensi
                                </td>
                                <td style="vertical-align: text-top">
                                    : {{$employee->emp_street1}}
                                </td>
                            </tr>
                        </table>
                        <p>Dengan ini memberikan pernyataan sesungguhnya sebagai berikut:</p>
                        <ol>
                            <li>
                                Bahwa saya bekerja sebagai Tenaga Honorer dan ditempatkan sebagai {{$employee->job_level}} di {{$employee->location_name}} per tanggal .... s/d ..... (... Bulan) yang bertugas dengan waktu kerja sesuai kebutuhan perusahaan dan dapat di review kembali setelah jangka waktu tersebut.
                            </li>
                            <li>
                                Setiap melaksanakan tugas, maka saya akan hadir sesuai kebutuhan pekerjaan saya dan saya akan melaksanakan tugas pekerjaan yang ditetapkan oleh Direksi PT Metropolitan Land Tbk dengan sebaik-baiknya dan penuh rasa tanggung jawab.
                            </li>
                            <li>
                                Sebagai imbal jasa atas pelaksanaan tugas saya sebagai Tenaga Honorer ….. dan tugas lainnya dari Direksi PT Metropolitan Land Tbk, saya bersedia diberikan honor setiap bulan (terlampir).
                            </li>
                            <li>
                                Selama saya masih bertugas sebagai Tenaga Honorer …. dan tugas lainnya dari Direksi PT Metropolitan Land Tbk, maka saya akan mematuhi ketentuan-ketentuan yang ditetapkan oleh Direksi PT Metropolitan Land Tbk .
                            </li>
                            <li>
                                Bilamana tenaga saya tidak dibutuhkan lagi atau saya melakukan pelanggaran, tidak disiplin, dan dinilai tidak mampu dalam melaksanakan tugas, maka saya tidak berkeberatan dan tidak akan menuntut dalam bentuk apapun apabila saya diberhentikan sebagai Tenaga Honorer ….. dan tugas lainnya dari Direksi PT Metropolitan Land Tbk, tanpa harus adanya teguran atau Surat Peringatan terlebih dahulu.
                            </li>
                            <li>
                                Tunduk Kepada Peraturan Perusahaan PT Metropolitan Land Tbk.
                            </li>
                        </ol>
                        <p>Demikian surat pernyataan ini saya buat tanpa adanya paksaan dan tekanan dari pihak manapun, serta saya tanda tangani dalam keadaan sehat jasmani dan rohani.</p>
                        <br>
                        <div>
                            Dibuat di 	: Bekasi
                        </div>
                        <div>
                            Tanggal 	: {{$nowFormat}}
                        </div>
                        <div>
                            Yang membuat pernyataan,	
                        </div>
                        <div style="color: gray; padding: 50px 0;">
                            materai	
                        </div>
                        <div>
                            <strong>{{$fullName}}</strong>	
                        </div>
                    </div>
                </center>
            </div>
            <br><br>
        </div>
    </body>
</html>