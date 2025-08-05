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
                font-size: 12pt;
                font-family: "Arial Narrow", Arial, sans-serif;
                text-decoration: underline;
            }
            .judul2{
                font-size: 10pt;
                font-family: "Arial Narrow", Arial, sans-serif;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 10pt;
                font-family: "Arial Narrow", Arial, sans-serif;
            }
            th, td {
                padding: 1px;
            }
            div{
                line-height: 95%;
            }
            table.contentdata{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 10pt;
                text-align: justify;
                font-family: "Arial Narrow", Arial, sans-serif;
            }
            div.headeratas{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 11pt;
                text-align: justify;
                font-family: "Arial Narrow", Arial, sans-serif;
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
                        <div class ="judul"><strong>SURAT PERINTAH KERJA</strong></div>
                        <div class ="judul2"><strong>No.: …/SPK/HRD/ML/../21</strong></div><br>				
                    </div>
                    <div class="headeratas">
                        <p>Yang bertandatangan di bawah ini:</p>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 10%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 90%">
                                    <p>:  <strong>Herlan Maulana Muhamad</strong> </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Jabatan
                                </td>
                                <td>
                                    : General Manager HRD & GA/Kuasa Direksi
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top" colspan="2">
                                    Dalam hal ini bertindak dalam kedudukan tersebut di atas, dari dan karenanya sah bertindak untuk dan atas nama <strong>PT Metropolitan Land, Tbk.</strong> suatu perseroan terbatas yang didirikan dan tunduk pada hukum Negara Republik Indonesia, berkedudukan di Kota Bekasi (selanjutnya disebut “<strong>Pemberi Tugas</strong>”);
                                </td>
                            </tr>
                        </table>
                        <p>Dengan ini memberikan pekerjaan kepada:</p>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 25%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 75%">
                                    <p>:  <strong>{{$fullName}}</strong> </p>
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
                                    Alamat Korespondensi
                                </td>
                                <td style="vertical-align: text-top">
                                    : {{$employee->emp_street1}}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top" colspan="2">
                                    Dalam hal ini bertindak untuk dan atas nama dirinya sendiri (selanjutnya disebut “<strong>Penerima Tugas</strong>”).
                                </td>
                            </tr>
                        </table>
                        <p>Dengan ini memberikan pekerjaan kepada:</p>
                        <ol>
                            <li>
                                <div><strong>Pekerjaan :</strong></div>
                                <div>Melakukan pekerjaan yang terkait dengan Departemen {{$employee->job_level}} di Metland Kantor Pusat (selanjutnya disebut “<strong>Pekerjaan</strong>”).</div>
                                <br>
                            </li>
                            <li>
                                <div><strong>Jangka Waktu: </strong></div>
                                <div>... (...terbilang...) bulan terhitung sejak {{$empJoinDate}} sampai dengan ..... dan di evaluasi per 3 (tiga) bulan serta dapat diakhiri sewaktu-waktu apabila berdasarkan penilaian dan evaluasi, Penerima Tugas dianggap performanya tidak sesuai dengan yang diharapkan Pemberi Tugas.</div>
                                <br>
                            </li>
                            <li>
                                <div><strong>Biaya Pekerjaan dan Cara Pembayaran: </strong></div>
                                <div>Sebesar Rp. .... ( ....terbilang..... ) per hari  untuk minimal 20 (dua puluh) hari kehadiran dan maksimal 25 (dua puluh lima) hari kehadiran dan berlaku ketentuan pengurangan kehadiran per hari  sebesar Rp. .... (....terbilang....) per hari, tidak dipotong PPh. </div>
                                <div>Biaya Pekerjaan akan dibayarkan pada tanggal 30 setiap bulannya.</div>
                                <br>
                            </li>
                            <li>
                                <div><strong>Lokasi Pekerjaan: Metland Kantor Pusat</strong></div>
                                <br>
                            </li>
                            <li>
                                <div><strong>Pelaksanaan Pekerjaan: </strong></div>
                                <div>5 (lima) hari kerja dalam 1 (satu) minggu.</div>
                                <br>
                            </li>
                            <li>
                                <div><strong>Syarat dan Ketentuan Lain: </strong></div>
                                <ol type="a">
                                    <li>Penerima Tugas wajib melaksanakan Pekerjaan dengan sebaik-baiknya dan secara tepat waktu sesuai dengan tugas-tugas yang diberikan oleh Pemberi Tugas </li>
                                    <li>Penerima Tugas wajib membuat dan menyerahkan laporan hasil pekerjaan secara berkala kepada Pemberi Tugas, yaitu pada setiap hari Senin.</li>
                                    <li>Penerima Tugas wajib mematuhi peraturan perusahaan yang berlaku pada PT Metropolitan Land Tbk.</li>
                                </ol>
                            </li>
                        </ol>
                        <p>Demikian Surat Perintah Kerja ini dibuat dan ditandatangani pada tanggal {{$nowFormat}} untuk dilaksanakan oleh Penerima Tugas dengan sebaik-baiknya.</p>
                        <br>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 50%; vertical-align: text-top">
                                    <strong>Penerima Tugas,</strong>
                                </td>
                                <td style="width: 50%">
                                    <strong>Pemberi Tugas,</strong>
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
                                    <strong>{{$fullName}}</strong>
                                </td>
                                <td>
                                    <strong>Herlan Maulana Muhammad</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
            </div>
        </div>
    </body>
</html>