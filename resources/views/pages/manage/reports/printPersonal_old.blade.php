<html>
    <header>
        <script>
            $(document).ready(function()
            {
                $('#cicilan_table').DataTable();
            } );
        </script>

        <style>
            .pagebreak { page-break-before: always; }
            @page {
                margin: 10mm;
                /*                margin-top: 94.08px;
                                margin-bottom: 75.84px;
                                margin-left: 94.08px;
                                margin-right: 75.84px;*/
            }

            ol.ur {list-style-type: upper-roman;}
            ol.la {list-style-type: lower-alpha;}
            ol.num {list-style-type: decimal;}
            ol.lr {list-style-type: lower-roman;}

            table, th, td {
                border: 0px black;
            }
            th, td {
                padding: 1px;
            }
            ol {
                list-style: none;
                margin: 0;
                padding: 5px;
            }
            li {
                text-align: justify;
                margin: 0;
                padding: 1px;
            }
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
                text-align:right;
                margin-top:-98px;
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
                margin-left: 3em;
                text-align:center;
                margin-top: -1em;
                font-size: 12px;
                font-family: "Arial Narrow", Arial, sans-serif;
            }

            div.headerbawahtengah3{
                    /*padding-left: 5em;*/
                /*margin-left: 3em;*/
                text-align:left;
                /*                margin-top: -1em;*/
                font-size: 14px;
                font-family: "Arial Narrow", Arial, sans-serif;
                /*margin-bottom: -30px;*/
            }

            .nomorsurat{
                /*    padding-left: 5em;*/
                /*                margin-left: 3em;*/
                text-align:center;
                margin-top: -1em;
                font-size: 22.5px;
                font-family: "Arial Narrow", Arial, sans-serif;
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
                font-size: 16px;
                font-family: Calibri, Helvetica, Arial, sans-serif;

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
                font-size: 14px;
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
                text-align: center;
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
                /*                padding-left: 3em;*/
                font-size: 12px;
                font-family: "Arial Narrow", Arial, sans-serif;
            }
            div.termAndConditionAtas{
                text-align:left;
                font-size: 12px;
                margin-bottom:-1em;
                font-family: "Arial Narrow", Arial, sans-serif;
            }

            div.termAndConditionAtas2{
                text-align:left;
                font-size: 10px;
                margin-left: 10px;
                /*                 margin-bottom:-1em;*/
                font-family: "Arial Narrow", Arial, sans-serif;
            }

            div.termAndConditionBawah{
                text-align:left;
                margin-left: 3em;
                font-size: 14px;
                font-family: Calibri, Helvetica, Arial, sans-serif;
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
                /*                padding-left: 3em;*/
                font-size: 12px;
                font-family: "Arial Narrow", Arial, sans-serif;
            }

            div.dataBookingEntry{
                font-size: 12px;
                margin-top: -15px;
                font-family: "Arial Narrow", Arial, sans-serif;
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

            table.table1{
                border-collapse: collapse;
                border: 1px solid black;
                width: 100%;
            }

            table.table1 tr{
                border-collapse: collapse;
                border: 1px solid black;
                height: 20px;
            }

            table.table1 td{
                border-collapse: collapse;
                border: 1px solid black;
            }

            table.table2{
                border-collapse: collapse;
                border: 1px solid black;
                width: 100%;
            }

            table.table2 tr{
                border-collapse: collapse;
                border: 1px solid black;
                height: 60px;
            }

            table.table2 td{
                border-collapse: collapse;
                border: 1px solid black;
            }

            table.tableSignature{
                border-collapse: collapse;
                border: 1px solid black;
                width: 100%;
            }

            table.tableSignature tr{
                border-collapse: collapse;
                border: 1px solid black;
                height: 0px;
            }

            table.tableSignature td{
                border-collapse: collapse;
                border: 1px solid black;
                /*height: 0px;*/
            }
            /*tr{*/
            /*    font-size: 11px;*/
            /*    text-align: left;*/
            /*    height: 20px;*/
            /*    vertical-align: bottom;*/
            /*}*/

            li{
                margin-bottom: 10px;
            }

            /*            #table{
                            font-size: 18px;
                            margin-top: -5em;
                            font-family: "Arial Narrow", Arial, sans-serif;
                        }*/

            .header,
            .footer {
                width: 100%;
                text-align: center;
                position: fixed;
            }
            .header {
                top: 0px;
            }
            .footer {
                border-top: 2px solid #000;
                bottom: 0px;
            }
            .pagenum:before {
                content: counter(page);
            }

            div.halaman{
                border-right: 2px solid #000;
                text-align: left;
                font-family: "Arial Narrow", Arial, sans-serif;
                font-size: 12px;
                width: 10%;
            }
            div.notes{
                /*               border-left: 2px solid #000;*/
                margin-top: -20px;
                /*               position: absolute;*/
                text-align: right;
                font-family: "Arial Narrow", Arial, sans-serif;
                font-size: 12px;
                width: 100%;
            }
        </style>
    </header>
    <body>
    <div class="row">
        <table style="width:100%;margin-top: 20px;">
            <tr>
                <td>
                    <div class="headerbawahtengah3">
                        <p><b>PT. METROPOLITAN LAND</b></p>
                    </div>
                </td>
                <!-- <td>
                    <div class="headerbawahtengah3" style="text-align: right;">
                        F-PROJECT/PER-06
                    </div>
                </td> -->
            </tr>
            <!-- <tr>
                <td>
                    <div class="headerbawahtengah3">
                        <p><b>DISTRIBUSI SURAT RILIS</b></p>
                    </div>
                </td>
            </tr> -->
        </table>
    </div>
    <br>
    <br>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <table style="width:100%;">
                    <tr>
                        <td rowspan="4">
                            @if($pic)
                                @if($pic->epic_picture_type == '2')
                                    <img style="height: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode($pic->epic_picture) }}"/>
                                @elseif($pic->epic_picture_type == '1')
                                    <img style="height: 450px;" class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ $pic->epic_picture }}"/>
                                @else
                                    <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                                @endif
                            @else
                                <img src="{{ asset('images\personal\FOTO_DEFAULT.gif') }}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="Customer">
                                PROYEK
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                {{strtoupper($dataProject['PROJECT_NAME'])}} - {{strtoupper($dataProject['PROJECT_KEC'])}} {{strtoupper($dataProject['PROJECT_KOTA'])}}
                            </div>
                        </td>
                    </tr>
                    <?php $noType = 1; ?>
                    @foreach($dataReqType as $type)
                        @if($noType == 1)
                            <tr style="height:40px">
                                <td>
                                    <div class="Customer">
                                        TYPE
                                    </div>
                                </td>
                                <td>
                                    <div class="Customer">
                                        :
                                    </div>
                                </td>
                                <td>
                                    <div class="Customer">
                                        {{strtoupper($type->BLOK_NAME.' '.$type->BLOK_CODE.' ('.$type->UNIT_LB.'/'.$type->UNIT_LT.')')}}
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    <div class="Customer">
                                    </div>
                                </td>
                                <td>
                                    <div class="Customer">
                                        :
                                    </div>
                                </td>
                                <td>
                                    <div class="Customer">
                                        {{strtoupper($type->BLOK_NAME.' '.$type->BLOK_CODE.' ('.$type->UNIT_LB.'/'.$type->UNIT_LT.')')}}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <?php $noType += 1; ?>
                    @endforeach

                    <?php $noUnit = 1; ?>
                    @foreach($dataReqType as $type1)
                        <?php
                        $dataUnit = DB::select("select min(NOUNIT_CHAR) as MIN_UNIT, max(NOUNIT_CHAR) as MAX_UNIT
                                                from MD_RELEASE_UNIT
                                                where MD_RELEASE_BLOK_ID_INT = ".$type1->MD_RELEASE_BLOK_ID_INT);
                        ?>
                        @if($noUnit == 1)
                        <tr style="height:40px">
                            <td>
                                <div class="Customer">
                                    BLOK/NO
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    :
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    {{strtoupper($type1->BLOK_NAME)}} : {{$dataUnit[0]->MIN_UNIT}} s/d {{$dataUnit[0]->MAX_UNIT}} = {{strtoupper($type1->JML_UNIT)}} UNIT
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td>
                                <div class="Customer">
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    :
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    {{strtoupper($type1->BLOK_NAME)}} : {{$dataUnit[0]->MIN_UNIT}} s/d {{$dataUnit[0]->MAX_UNIT}} = {{strtoupper($type1->JML_UNIT)}} UNIT
                                </div>
                            </td>
                        </tr>
                        @endif
                        <?php $noUnit += 1; ?>
                    @endforeach
                    <tr style="height: 40px;">
                        <td>
                            <div class="Customer">
                                NO SURAT
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                {{strtoupper($datarReqRelease['MD_RELEASE_NOCHAR'])}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="Customer">
                                TANGGAL
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                :
                            </div>
                        </td>
                        <td>
                            <div class="Customer">
                                {{strtoupper($dateRequest)}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <table class="table1">
                        <tr>
                            <td><div class="Customer"><b><center>NO.</center></b></div></td>
                            <td><div class="Customer"><b><center>LAMPIRAN</center></b></div></td>
                            <td style="width: 110px"><div class="Customer"><b><center>ADA</center></b></div></td>
                            <td><div class="Customer"><b><center>TIDAK ADA</center></b></div></td>
                            <td style="width: 330px"><div class="Customer"><b><center>KETERANGAN</center></b></div></td>
                        </tr>
                        <tr>
                            <td><div class="Customer"><center>1</center></div></td>
                            <td><div class="Customer">SURAT RILIS</div> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><div class="Customer"><center>2</center></div></td>
                            <td><div class="Customer">DAFTAR HARGA</div> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><div class="Customer"><center>3</center></div></td>
                            <td><div class="Customer">GAMBAR DENAH TAMPAK</div> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><div class="Customer"><center>4</center></div></td>
                            <td><div class="Customer">DENAH SITE PLAN</div> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><div class="Customer"><center>5</center></div></td>
                            <td><div class="Customer">SPESIFIKASI BANGUNAN</div> </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <table class="table2">
                    <tr style="height: 0px">
                        <td><div class="Customer"><b><center>NO.</center></b></div></td>
                        <td><div class="Customer"><b><center>JABATAN</center></b></div></td>
                        <td><div class="Customer"><b><center>NAMA</center></b></div></td>
                        <td><div class="Customer"><b><center>TANGGAL</center></b></div></td>
                        <td><div class="Customer"><b><center>PARAF</center></b></div></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>1</center></div></td>
                        <td><div class="Customer">{{$dataAssign1['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign1['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>2</center></div></td>
                        <td><div class="Customer">{{$dataAssign2['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign2['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>3</center></div></td>
                        <td><div class="Customer">{{$dataAssign3['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign3['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>4</center></div></td>
                        <td><div class="Customer">{{$dataAssign4['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign4['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>5</center></div></td>
                        <td><div class="Customer">{{$dataAssign5['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign5['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>6</center></div></td>
                        <td><div class="Customer">{{$dataAssign6['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign6['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><div class="Customer"><center>7</center></div></td>
                        <td><div class="Customer">{{$dataAssign7['SPK_ASSIGN_JOB_NAME']}}</div> </td>
                        <td><div class="Customer">{{$dataAssign7['SPK_ASSIGN_NAME']}}</div> </td>
                        <td></td>
                        <td></td>
                    </tr>
{{--                    <tr>--}}
{{--                        <td><div class="Customer"><center>8</center></div></td>--}}
{{--                        <td><div class="Customer">{{$dataAssign8['SPK_ASSIGN_JOB_NAME']}}</div> </td>--}}
{{--                        <td><div class="Customer">{{$dataAssign8['SPK_ASSIGN_NAME']}}</div> </td>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td><div class="Customer"><center>9</center></div></td>--}}
{{--                        <td><div class="Customer">{{$dataAssign9['SPK_ASSIGN_JOB_NAME']}}</div> </td>--}}
{{--                        <td><div class="Customer">{{$dataAssign9['SPK_ASSIGN_NAME']}}</div> </td>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td><div class="Customer"><center>10</center></div></td>--}}
{{--                        <td><div class="Customer">{{$dataAssign10['SPK_ASSIGN_JOB_NAME']}}</div> </td>--}}
{{--                        <td><div class="Customer">{{$dataAssign10['SPK_ASSIGN_NAME']}}</div> </td>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td><div class="Customer"><center>11</center></div></td>--}}
{{--                        <td><div class="Customer">{{$dataAssign11['SPK_ASSIGN_JOB_NAME']}}</div> </td>--}}
{{--                        <td><div class="Customer">{{$dataAssign11['SPK_ASSIGN_NAME']}}</div> </td>--}}
{{--                        <td></td>--}}
{{--                        <td></td>--}}
{{--                    </tr>--}}
                </table>
            </div>
        </div>
    </div>

    <!--end Page 1 -->
    <div class="pagebreak"> </div>

    <div class="row">
        <table style="width:100%;margin-top: 20px;">
            <tr>
                <td>
                    <div class="headerbawahtengah3">
                        <p>{{$dataProject['PROJECT_KEC']}}</p>
                    </div>
                </td>
                <td>
                    <div class="headerbawahtengah3">
                        :
                    </div>
                </td>
                <td>
                    <div class="headerbawahtengah3">
                        {{strtoupper($dateRequest)}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="headerbawahtengah3">
                        <p></p>
                    </div>
                </td>
                <td>
                    <div class="headerbawahtengah3">
                        :
                    </div>
                </td>
                <td>
                    <div class="headerbawahtengah3">
                        {{strtoupper($datarReqRelease['MD_RELEASE_NOCHAR'])}}
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p>Kepada Yth,<br>
                    <b>Bapak Anhar Sudradjat</b><br>
                    Direktur Utama PT. Metropolitan Land, Tbk.<br>
                    di Bekasi</p>
            </div>
        </div>
    </div>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p><b>Hal : Rilis Unit di Perumahan {{$dataProject['PROJECT_NAME']}}</b></p>
            </div>
        </div>
    </div>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p>Dengan Hormat,<br>
                Bersama surat kami mengajukan Rilis Unit dengan rincian sebagai Berikut:<br></p>

                <table style="width: 100%">
                    <?php $totalUnit = 0; ?>
                    @foreach($dataReqType as $type2)
                        <?php
                            $charUnit = '';
                            $dataUnit = DB::select("select NOUNIT_CHAR
                                                from MD_RELEASE_UNIT
                                                where MD_RELEASE_BLOK_ID_INT = ".$type2->MD_RELEASE_BLOK_ID_INT);

                            foreach ($dataUnit as $unit)
                            {
                                $charUnit .= $unit->NOUNIT_CHAR.',';
                            }
                        ?>
                        <tr style="height: 30px">
                            <td>
                                <div class="Customer">
                                    - {{strtoupper($type2->BLOK_NAME.' Blok '.$type2->BLOK_CODE.' '.$type2->BLOK_NUMBER)}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    :
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    {{$charUnit}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    =
                                </div>
                            </td>
                            <td>
                                <div class="Customer">
                                    {{$type2->JML_UNIT}} Unit
                                </div>
                            </td>
                        </tr>
                        <?php $totalUnit += $type2->JML_UNIT; ?>
                    @endforeach
                        <tr style="height: 30px">
                            <td>
                                <div class="Customer">
                                    <b>TOTAL</b>
                                </div>
                            </td>
                            <td>
                                <div class="Customer"></div>
                            </td>
                            <td>
                                <div class="Customer"></div>
                            </td>
                            <td>
                                <div class="Customer"></div>
                            </td>
                            <td>
                                <div class="Customer">
                                    <b>{{$totalUnit}} Unit</b>
                                </div>
                            </td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p>PERHITUNGAN HARGA</p>
                <table style="width: 100%">
                    @foreach($dataDetailReyType as $detailType)
                        <tr>
                            <td colspan="6"><div class="Customer">{{strtoupper($detailType->BLOK_NAME.' '.$detailType->BLOK_CODE.' Tipe '.$detailType->UNIT_LT.'/'.$detailType->UNIT_LB)}}</div></td>
                        </tr>
                        <tr>
                            <td colspan="6"><div class="Customer">a. Perhitungan Harga Bangunan</div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">1. Construction Cost</div></td>
                            <td><div class="Customer">(a)</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer">{{number_format($detailType->MD_RELEASE_COST_NUM,0,'','.')}}/m2</div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">2. Delivery Cost <b>({{number_format($detailType->MD_RELEASE_DELIVERY_PERCENT,1,'.','.')}}%/tahun)</b></div></td>
                            <td><div class="Customer">(b)=(a)*{{number_format($detailType->MD_RELEASE_DELIVERY_PERCENT,1,'.','.')}}%</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer"><div class="Customer">{{number_format($detailType->MD_RELEASE_DELIVERY_NUM,0,'','.')}}/m2</div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">3. Safety Factor <b>2.5%</b></div></td>
                            <td><div class="Customer">(c)=(a)*2.5%</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_SAFETY_NUM,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">4. Company Profit <b>{{number_format($detailType->MD_RELEASE_COMPANY_PROFIT_PERCENT,1,'.','.')}}%</b></div></td>
                            <td><div class="Customer">(d)=(a)*{{number_format($detailType->MD_RELEASE_COMPANY_PROFIT_PERCENT,1,'.','.')}}%</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_COMPANY_PROFIT,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">5. Design</div></td>
                            <td><div class="Customer">(e)</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_DESIGN_NUM,0,',','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">6. IMB</div></td>
                            <td><div class="Customer">(f)</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_IMB_NUM,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_OTHERS_PERCENT,0,'','.')}}%</b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_OTHERS_NUM,0,'','.')}}</b></div></td>
                        </tr>
                        <tr style="background-color: #c2c2a3;">
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b>Harga Rilis</b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b>=</b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_BUILDING_TOTAL_NUM,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td colspan="6"><div class="Customer">b. Perhitungan Harga Tanah</div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer">- Harga Tanah</div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer"></div></td>
                            <td><div class="Customer">=</div></td>
                            <td style="text-align: right"><div class="Customer">{{number_format($detailType->MD_RELEASE_LAND_NUM,0,'','.')}}/m2</div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_OTHERS_LAND_PERCENT,0,'','.')}}%</b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_RELEASE_OTHERS_LAND_NUM,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr style="background-color: #c2c2a3;">
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b>Harga Rilis</b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b></b></div></td>
                            <td><div class="Customer"><b>=</b></div></td>
                            <td style="text-align: right"><div class="Customer"><b>{{number_format($detailType->MD_LAND_TOTAL_NUM,0,'','.')}}/m2</b></div></td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p>Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih</p>
            </div>
        </div>
    </div>
    <br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="Customer">
                <p>Hormat kami,<br>
                   PT. METROPOLITAN LAND, TBK<br>
                   {{strtoupper($dataProject['PROJECT_NAME'])}}</p>
            </div>
        </div>
    </div>
    <br><br>
    <div class="dataBookingEntry">
        <div class="row" >
             <div class="col-lg-12">
                 <table class="tableSignature">
                     <tr>
                         <td>
                             <div class="Customer" style="text-align: center;">
                                 {{$dataAssign1['SPK_ASSIGN_JOB_NAME']}}
                                 <br><br><br><br><br><br><br><br><br><br>
                             </div>
                         </td>
                         <td>
                             <div class="Customer" style="text-align: center;">
                                 {{$dataAssign2['SPK_ASSIGN_JOB_NAME']}}
                                 <br><br><br><br><br><br><br><br><br><br>
                             </div>
                         </td>
                         <td>
                             <div class="Customer" style="text-align: center;">
                                 {{$dataAssign3['SPK_ASSIGN_JOB_NAME']}}
                                 <br><br><br><br><br><br><br><br><br><br>
                             </div>
                         </td>
                     </tr>
                     <tr style="height: 0px">
                         <td>
                             <div class="Customer" style="text-align: center">
                                 {{$dataAssign1['SPK_ASSIGN_NAME']}}
                             </div>
                         </td>
                         <td>
                             <div class="Customer" style="text-align: center">
                                 {{$dataAssign2['SPK_ASSIGN_NAME']}}
                             </div>
                         </td>
                         <td>
                             <div class="Customer" style="text-align: center">
                                 {{$dataAssign3['SPK_ASSIGN_NAME']}}
                             </div>
                         </td>
                     </tr>
                 </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="dataBookingEntry">
        <div class="row" >
            <div class="col-lg-12">
                <table class="tableSignature">
                    <tr>
                        <td>
                            <div class="Customer" style="text-align: center;">
                                {{$dataAssign4['SPK_ASSIGN_JOB_NAME']}}
                                <br><br><br><br><br><br><br><br><br><br>
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center;">
                                {{$dataAssign5['SPK_ASSIGN_JOB_NAME']}}
                                <br><br><br><br><br><br><br><br><br><br>
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center;">
                                {{$dataAssign6['SPK_ASSIGN_JOB_NAME']}}
                                <br><br><br><br><br><br><br><br><br><br>
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center;">
                                {{$dataAssign7['SPK_ASSIGN_JOB_NAME']}}
                                <br><br><br><br><br><br><br><br><br><br>
                            </div>
                        </td>
                    </tr>
                    <tr style="height: 0px">
                        <td>
                            <div class="Customer" style="text-align: center">
                                {{$dataAssign4['SPK_ASSIGN_NAME']}}
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center">
                                {{$dataAssign5['SPK_ASSIGN_NAME']}}
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center">
                                {{$dataAssign6['SPK_ASSIGN_NAME']}}
                            </div>
                        </td>
                        <td>
                            <div class="Customer" style="text-align: center">
                                {{$dataAssign7['SPK_ASSIGN_NAME']}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <br><br>
{{--    <div class="dataBookingEntry">--}}
{{--        <div class="row" >--}}
{{--            <div class="col-lg-12">--}}
{{--                <table class="tableSignature">--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center;">--}}
{{--                                {{$dataAssign7['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                <br><br><br><br><br><br><br><br><br><br>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center;">--}}
{{--                                {{$dataAssign8['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                <br><br><br><br><br><br><br><br><br><br>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center;">--}}
{{--                                {{$dataAssign9['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                <br><br><br><br><br><br><br><br><br><br>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center;">--}}
{{--                                {{$dataAssign10['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                <br><br><br><br><br><br><br><br><br><br>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr style="height: 0px">--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center">--}}
{{--                                {{$dataAssign7['SPK_ASSIGN_NAME']}}--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center">--}}
{{--                                {{$dataAssign8['SPK_ASSIGN_NAME']}}--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center">--}}
{{--                                {{$dataAssign9['SPK_ASSIGN_NAME']}}--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="Customer" style="text-align: center">--}}
{{--                                {{$dataAssign10['SPK_ASSIGN_NAME']}}--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!--end Page 2 -->
    <div class="pagebreak"> </div>

    <div class="row" style="margin-top: 20px;">
        <p>
            DAFTAR RILIS UNIT PROYEK {{strtoupper($dataProject['PROJECT_NAME'])}}<br><br>
            {{strtoupper($datarReqRelease['MD_RELEASE_NOCHAR'])}}<br>
            {{strtoupper($dateRequest)}}
        </p>
        <br><br>
        <table class="table2">
            <tr style="height: 0px">
                <td style="text-align: center"><div class="Customer"><b>NO</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>KODE</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>NO. BLOK</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>NO UNIT</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>TYPE</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>LB (M2)</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>LT (M2)</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>HB (M2)</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>HT (M2)</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>JUMLAH HB</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>JUMLAH HT</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>TOTAL HARGA RILIS</b></div></th>
                <td style="text-align: center"><div class="Customer"><b>KETERANGAN SERTIFIKAT</b></div></th>
            </tr>
            <?php $no = 1; ?>
            @foreach($dataDetailLampiran as $detailLampiran)
            <tr style="height: 0px">
                <td style="text-align: right;"><div class="Customer">{{$no}}</div></td>
                <td><div class="Customer">{{$detailLampiran->BLOK_CODE}}</div></td>
                <td><div class="Customer">{{$detailLampiran->BLOK_NUMBER}}</div></td>
                <td><div class="Customer">{{$detailLampiran->NOUNIT_CHAR}}</div></td>
                <td><div class="Customer">{{$detailLampiran->BLOK_NAME}}</div></td>
                <td><div class="Customer">{{$detailLampiran->UNIT_LB}}</div></td>
                <td><div class="Customer">{{$detailLampiran->UNIT_LT}}</div></td>
                <td style="text-align: right;"><div class="Customer">{{number_format($detailLampiran->MD_BUILDING_TOTAL_NUM,0,'','.')}}</div></td>
                <td style="text-align: right;"><div class="Customer">{{number_format($detailLampiran->MD_LAND_TOTAL_NUM,0,'','.')}}</div></td>
                <td style="text-align: right;"><div class="Customer">{{number_format($detailLampiran->JML_HB,0,'','.')}}</div></td>
                <td style="text-align: right;"><div class="Customer">{{number_format($detailLampiran->JML_HT,0,'','.')}}</div></td>
                <td style="text-align: right;"><div class="Customer">{{number_format($detailLampiran->TOTAL_RILIS,0,'','.')}}</div></td>
                <td><div class="Customer">{{$detailLampiran->KETERANGAN}}</div></td>
            </tr>
            <?php $no += 1; ?>
            @endforeach
        </table>
        <br><br>
        <div class="dataBookingEntry">
            <div class="row" >
                <div class="col-lg-12">
                    <table class="tableSignature">
                        <tr>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign1['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign2['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign3['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 0px">
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign1['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign2['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign3['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <br><br>
        <div class="dataBookingEntry">
            <div class="row" >
                <div class="col-lg-12">
                    <table class="tableSignature">
                        <tr>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign4['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign5['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign6['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center;">
                                    {{$dataAssign7['SPK_ASSIGN_JOB_NAME']}}
                                    <br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </td>
                        </tr>
                        <tr style="height: 0px">
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign4['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign5['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign6['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                            <td>
                                <div class="Customer" style="text-align: center">
                                    {{$dataAssign7['SPK_ASSIGN_NAME']}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

{{--        <br><br>--}}
{{--        <div class="dataBookingEntry">--}}
{{--            <div class="row" >--}}
{{--                <div class="col-lg-12">--}}
{{--                    <table class="tableSignature">--}}
{{--                        <tr>--}}

{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center;">--}}
{{--                                    {{$dataAssign8['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                    <br><br><br><br><br><br><br><br><br><br>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center;">--}}
{{--                                    {{$dataAssign9['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                    <br><br><br><br><br><br><br><br><br><br>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center;">--}}
{{--                                    {{$dataAssign10['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                    <br><br><br><br><br><br><br><br><br><br>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center;">--}}
{{--                                    {{$dataAssign11['SPK_ASSIGN_JOB_NAME']}}--}}
{{--                                    <br><br><br><br><br><br><br><br><br><br>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                        <tr style="height: 0px">--}}

{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center">--}}
{{--                                    {{$dataAssign8['SPK_ASSIGN_NAME']}}--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center">--}}
{{--                                    {{$dataAssign9['SPK_ASSIGN_NAME']}}--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center">--}}
{{--                                    {{$dataAssign10['SPK_ASSIGN_NAME']}}--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div class="Customer" style="text-align: center">--}}
{{--                                    {{$dataAssign11['SPK_ASSIGN_NAME']}}--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    </body>
    </html>