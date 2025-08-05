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
            }
            .textblue{
                color: blue;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 10pt;
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
                font-size: 10pt;
                text-align: justify;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            div.headeratas{
                padding-left: 2em;
                /*margin-left: 9em;*/
                margin-top:-1em;
                font-size: 10pt;
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
            $birthDay = indonesianDate(date('Y-m-d', strtotime($employee->emp_birthday)));
            $empJoinDate = indonesianDate(date('Y-m-d', strtotime($employee->emp_join_date)));

            $fullName = ($employee->emp_firstname != null) ? $employee->emp_firstname : "";
            $fullName .= ($employee->emp_middle_name != null) ? " " . $employee->emp_middle_name : "";
            $fullName .= ($employee->emp_lastname != null) ? " " . $employee->emp_lastname : "";
            
            $supFullName = ($employee->sup_firstname != null) ? $employee->sup_firstname : "";
            $supFullName .= ($employee->sup_middle_name != null) ? " " . $employee->sup_middle_name : "";
            $supFullName .= ($employee->sup_lastname != null) ? " " . $employee->sup_lastname : "";
            ?>
            <div>
                <center>
                    <div class ="header">
                        <img src="{{asset('images/metland_logo.png')}}" width="130" height="21" alt="metland_logo"/>
                        <div><strong>F-HO&PROJECT/HRD-07 Rev.04</strong></div>
                    </div>
                    <div class ="judul">
                        <strong>Formulir Exit Interview</strong>						
                    </div>
                    <table style="width: 100%;" class="tablesection1">
                        <tr class="tablesection1" >
                            <td style="width: 30%;" class="datadiri">NIK</td>
                            <td style="width: 70%;" class="datadiri">: {{$employee->employee_id}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Nama Karyawan</td>
                            <td style="width: 70%;" class="datadiri">: {{$fullName}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Jabatan</td>
                            <td style="width: 70%;" class="datadiri">: {{$employee->job_level}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Departemen</td>
                            <td style="width: 70%;" class="datadiri">: {{$employee->dept_name}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Status Kepegawaian</td>
                            <td style="width: 70%;" class="datadiri">: {{$employee->status_name}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Tanggal Mulai Bekerja</td>
                            <td style="width: 70%;" class="datadiri">: {{$empJoinDate}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Tanggal Mengundurkan Diri</td>
                            <td style="width: 70%;" class="datadiri">: {{$terminationDate}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 30%;" class="datadiri">Nama Atasan Langsung</td>
                            <td style="width: 70%;" class="datadiri">: {{$supFullName}}</td>
                        </tr>
                        <tr class="tablesection1">
                            <th colspan="5">Alasan Pengunduran Diri</th>
                        </tr>
                    </table>
                    <table style="width: 100%;" class="tablesection1">
                        <tr class="tablesection1">
                            <td style="width: 3%;" class="textsection2">No</td>
                            <td style="width: 67%;"></td>
                            <td style="width: 10%; font-style: italic" class="textsection2 textblue">Tidak puas</td>
                            <td style="width: 10%; font-style: italic" class="textsection2 textblue">Tidak ada Komentar</td>
                            <td style="width: 10%; font-style: italic" class="textsection2 textblue">Puas</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">I</td>
                            <td style="font-weight: bold" class="contenttext textblue">Hubungan dengan atasan Langsung</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">a</td>
                            <td class="contenttext">Koordinasi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">b</td>
                            <td class="contenttext">Kepemimpinan</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">c</td>
                            <td class="contenttext">Hubungan personal</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">d</td>
                            <td class="contenttext">Pemberian instruksi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">e</td>
                            <td class="contenttext">Pemberian motivasi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">f</td>
                            <td class="contenttext">Kerjasama Tim</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">g</td>
                            <td class="contenttext">Komunikasi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="contenttext" colspan="5" style="height:50px; vertical-align: text-top;">Kesimpulan:</td>
                        </tr>
                    </table>
                    <table style="width: 100%;" class="tablesection1">
                        <tr class="tablesection1">
                            <td class="textsection2">II</td>
                            <td style="font-weight: bold" class="contenttext textblue">Departemen</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 3%;" class="textsection2">a</td>
                            <td style="width: 67%;" class="contenttext">Koordinasi</td>
                            <td style="width: 10%;" class="textsection2">( &nbsp; &nbsp; )</td>
                            <td style="width: 10%;"class="textsection2">( &nbsp; &nbsp; )</td>
                            <td style="width: 10%;" class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">b</td>
                            <td class="contenttext">Hubungan personal</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">c</td>
                            <td class="contenttext">Kerjasama Tim</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">d</td>
                            <td class="contenttext">Komunikasi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="contenttext" colspan="5" style="height:50px; vertical-align: text-top;">Kesimpulan:</td>
                        </tr>
                    </table>
                    <table style="width: 100%;" class="tablesection1">
                        <tr class="tablesection1">
                            <td class="textsection2">III</td>
                            <td style="font-weight: bold" class="contenttext textblue">Kepegawaian</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 3%;" class="textsection2">a</td>
                            <td style="width: 67%;" class="contenttext">Status Kepegawaian</td>
                            <td style="width: 10%;" class="textsection2">( &nbsp; &nbsp; )</td>
                            <td style="width: 10%;" class="textsection2">( &nbsp; &nbsp; )</td>
                            <td style="width: 10%;" class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">b</td>
                            <td class="contenttext">Remunerasi dan benefit yang diterima</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">c</td>
                            <td class="contenttext">Area ruang kerja</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">d</td>
                            <td class="contenttext">Perlengkapan penunjang kerja</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">e</td>
                            <td class="contenttext">Tugas & tanggungjawab yang diemban</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">f</td>
                            <td class="contenttext">Kesempatan & jenjang karir internal</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="contenttext" colspan="5" style="height:50px; vertical-align: text-top;">Kesimpulan:</td>
                        </tr>
                    </table>
                    
                    
                    <table style="width: 100%;" class="tablesection1">
                        <tr class="tablesection1">
                            <td class="textsection2">IV</td>
                            <td style="font-weight: bold" class="contenttext textblue">Lain-lain</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 3%;" class="textsection2">a</td>
                            <td style="width: 67%;" class="contenttext">Alasan lain terkait pengunduran diri:</td>
                            <td style="width: 10%;"></td>
                            <td style="width: 10%;"></td>
                            <td style="width: 10%;"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td style="width: 3%;" class="textsection2">b</td>
                            <td style="width: 67%;" class="contenttext">Masukan untuk kemajuan perusahaan:</td>
                            <td style="width: 10%;"></td>
                            <td style="width: 10%;"></td>
                            <td style="width: 10%;"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">c</td>
                            <td class="contenttext">Serah terima inventaris dan perlengkapan kerja lainnya:</td>
                            <td style="font-style: italic" class="textsection2 textblue">Selesai</td>
                            <td style="font-style: italic" class="textsection2 textblue">Belum selesai</td>
                            <td style="font-style: italic" class="textsection2 textblue">Keterangan</td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">1. Tanda pengenal</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">2. Kartu nama</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">3. Alat tulis</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">4. Check list barang inventaris di ruang kerja</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">5. Seragam</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">6. Kartu asuransi</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">d</td>
                            <td class="contenttext">Serah terima pekerjaan ke atasan rekan kerja karyawan pengganti (termasuk TDP/PTDP)</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">e</td>
                            <td class="contenttext">Penghapusan alamat email, finger print(absensi),akses web, IT system, MPS, HRIS</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">(Departemen HRD koordinasi dengan Departemen IT)</td>
                            <td class="textsection2"></td>
                            <td class="textsection2"></td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">f</td>
                            <td class="contenttext">Penghitungan outstanding (bila ada) yang terkaitdengan departemen keuangan</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2"></td>
                            <td class="contenttext">dan koperasi</td>
                            <td class="textsection2"></td>
                            <td class="textsection2"></td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">g</td>
                            <td class="contenttext">Penyerahan surat keterangan kerja</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">h</td>
                            <td class="contenttext">Penandatanganan surat pernyataan menjaga rahasia perusahaan</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">i</td>
                            <td class="contenttext">Penyerahan sumbangan buku untuk perpustakaan PT Metropolitan Land Tbk</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2">( &nbsp; &nbsp; )</td>
                            <td class="textsection2"></td>
                        </tr>
                        <tr class="tablesection1">
                            <td class="textsection2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table style="width: 100%;" class="tablesection1">
                        <tr>
                            <td style="width: 30%;" class="contenttext">Bekasi, {{$terminationDate}}</td>
                            <td style="width: 70%;"></td>
                        </tr>
                        <tr style="height: 50px">
                            <td style="vertical-align: text-top;" class="contenttext">Departemen HRD</td>
                            <td style="vertical-align: text-top;" class="contenttext">Karyawan</td>
                        </tr>
                        <tr>
                            <td class="contenttext">( &emsp; &emsp; &emsp; &emsp; &emsp; )</td>
                            <td class="contenttext">( {{$fullName}} )</td>
                        </tr>
                    </table>

                    <p style="page-break-before: always">
                        
                    <div class ="header">
                        <img src="{{asset('images/metland_logo.png')}}" width="130" height="21" alt="metland_logo"/>
                        <div><strong>Lampiran Form : F-HO&PROJECT/HRD-07 Rev.04</strong></div>
                    </div>

                    <div class ="judul">
                        <p><strong>SURAT PERNYATAAN</strong></p><br>						
                    </div>
                    <div class="headeratas">
                        <p>Sehubungan dengan berakhirnya hubungan kerja atas nama saya sebagai {{$employee->job_level}} terhitung sejak tanggal {{$terminationDate}}, maka dengan ini saya :</p><br>
                        <table style="width: 100%" class="contentdata">
                            <tr>
                                <td style="width: 20%; vertical-align: text-top">
                                    <p>Nama</p>
                                </td>
                                <td style="width: 80%">
                                    <p>:  {{$fullName}} </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top">
                                    Tanggal lahir
                                </td>
                                <td>
                                    : {{$birthDay}}
                                </td>
                            </tr>
                            <tr >
                                <td style="vertical-align: text-top">
                                    Alamat
                                </td>
                                <td>
                                    : {{$employee->emp_street1}}
                                </td>
                            </tr>
                        </table>

                        <p>Menyatakan bahwa :</p>
                        <ol>
                            <li><p>Dengan berakhirnya status kepegawaian saya di PT Metropolitan Land Tbk, saya tidak akan memberikan data dan informasi perusahaan yang bersifat rahasia kepada pihak lain, dan tidak akan menggunakan data dan informasi perusahaan dalam bentuk apapun untuk kepentingan pribadi maupun pihak lain. </p></li>
                            <li><p>Pelanggaran terhadap hal-hal yang telah disebutkan didalam surat pernyataan, maka saya bersedia untuk menerima konsekuensi hukum yang ada. </P></li>
                            <li><p>Atas pernyataan saya tersebut di atas, saya tidak akan mengajukan tuntutan dan gugatan dalam bentuk apapun dikemudian hari kepada perusahaan. </P></li>
                        </ol>

                        <br>
                        <p>Demikian surat pernyataan ini saya buat dengan sebenarnya.</p>
                        <p>Bekasi, {{$terminationDate}}</p>
                        <br>
                        <p>materai Rp.10000</p>
                        <br>
                        <p>{{$fullName}}</p><br>
                    </div>
                </center>
            </div>
            <br><br>
        </div>
    </body>
</html>