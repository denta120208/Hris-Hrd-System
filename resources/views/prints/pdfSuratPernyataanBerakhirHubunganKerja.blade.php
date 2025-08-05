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
                font-size: 15pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            .judul2{
                font-size: 10pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
            }
            .header{
                display: flex;
                justify-content: space-between;
                font-size: 10pt;
                font-family: "Trebuchet MS", Tahoma, sans-serif;
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
                    <div class ="header">
                        <img src="{{asset('images/metland_logo.png')}}" width="130" height="21" alt="metland_logo"/>
                        <div><strong>Lampiran Form : F-HO&PROJECT/HRD-07 Rev.04</strong></div>
                    </div>
                    <div>
                        <br>
                        <br>
                        <div class ="judul"><strong>SURAT PERNYATAAN</strong></div>
                        <br>
                        <br>
                    </div>
                    <div class="headeratas">
                        <p>Sehubungan dengan berakhirnya hubungan kerja atas nama saya sebagai {{$employee->job_level}} terhitung sejak tanggal ...., maka dengan ini saya :</p>
                        <br>
                        <table style="width: 100%" class="contentdata">
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
                                    Tanggal Lahir
                                </td>
                                <td>
                                    : .../{{$empBirthday}}
                                </td>
                            </tr>
                            <tr style="height: 30px">
                                <td style="vertical-align: text-top">
                                    Alamat
                                </td>
                                <td style="vertical-align: text-top">
                                    : {{$employee->emp_street1}}
                                </td>
                            </tr>
                        </table>
                        <p>Menyatakan bahwa :</p>
                        <ol>
                            <li>
                                Dengan berakhirnya status kepegawaian saya di PT Metropolitan Land Tbk, saya tidak akan memberikan data dan informasi perusahaan yang bersifat rahasia kepada pihak lain, dan tidak akan menggunakan data dan informasi perusahaan dalam bentuk apapun untuk kepentingan pribadi maupun pihak lain.
                            </li>
                            <li>
                                Pelanggaran terhadap hal-hal yang telah disebutkan didalam surat pernyataan, maka saya bersedia untuk menerima konsekuensi hukum yang ada.
                            </li>
                            <li>
                                Atas pernyataan saya tersebut di atas, saya tidak akan mengajukan tuntutan dan gugatan dalam bentuk apapun dikemudian hari kepada perusahaan.
                            </li>
                            
                        </ol>
                        <p>Demikian surat pernyataan ini saya buat dengan sebenarnya.</p>
                        <br>
                        <div>
                            Bekasi, {{$nowFormat}}	
                        </div>
                        <div style=" padding: 50px 0;">
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