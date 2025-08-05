@extends('salesadministration.pdfcetak')
@section('content_report')

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
            table, th, td {
                border: 0px black;
            }
            th, td {
                padding: 1px;
            }
            div.headeratas{
                padding-left: 2em;
                margin-left: 9em;
                text-align:center;
                margin-top:-1em;
                font-size: 10px
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
    <body>
        <div class="row">
       <!--TEMPAT LAMPIRAN-->
       <div>
           <center>
				
				<div class ="judul">
						<p><strong>SURAT PERINTAH DAN KUASA</strong></p><br>
						
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p><br>
					<p>				Nama		  :  {{$dataProject->Nama}} 
									Tanggal Lahir :  {{$dataProject->TglLahir}} 
									No. KTP		  :  {{$dataProject->NoKTP}} 
									Alamat     	  :  {{$dataProject->Alamat}}
									Sebagai Pihak : PEMBERI KUASA</p><br><br>
					<p>Pemberi Kuasa adalah pemegang rekening tabungan pada PT Bank Mandiri (Persero)Tbk.,Sebagai berikut:</p><br>						
					<p>Jenis Rekening		: Tabungan Mandiri</p><br>
					<p>Nomor Rekening		: {{$dataProject->No_Rekening_Bank}} </p><br>
					<p>Terdaftar atas nama  : {{$dataProject->Nama_Rekening_Bank}}</p><br>
					<p>Bank Mandiri Cabang  : {{$dataProject->Cabang_Bank}}</p><br><br>
					<p>Sehubungan dengan:</p><br>	
						<p>1. Pembayaran Manfaat Dana Pesangon berdasarkan Program Pensiun Untuk Kompensasi Pesangon (PPUKP) dari Perjanjian Kerja Sama 
						      Pengelolaan Dana Pesangon Dalam Program Pensiun Untuk Kompensasi Pesangon (PPUKP) Antara Dana PensiunLembaga Keuangan 
							  PT Bank Mandiri (Persero) Tbk. Dengan PT Metropolitan Land Tbk  nomor Mandiri DPLK :IBG.DPLK/PKS-PPUU.023/2017, Tanggal 
							  15 November  2017 ;</p><br>
						<p>2. Dokumen Surat Keterangan Kerja  dengan Nomor {{$dataProject->No_Surat_Keterangan}} tanggal {{$dataProject->Tgl_Surat_Keterangan}}</p><br>
						<p>3. Surat Permohonan Pembayaran Manfaat Dana PPUKP – {{$dataProject->No_Surat_Permohonan_Dana}}</p><br>

				   <p>Dengan ini memberikan perintahdankuasa dengan hak subtitusi kepada:</p><br>
				   <p>PT. Bank Mandiri (Persero) Tbk, suatu lembaga perbankan yang didirikan berdasarkan hukum Republik Indonesia yang berkedudukan di Jakarta 
				      dan berkantor pusat di Plaza Mandiri Jl. Jend Gatot Subroto, Kav. 36-38 Jakarta-Selatan, Jakarta 12190, selanjutnya disebut Penerima Kuasa, 
					  kuasa mana tidak dapat ditarik kembali dan tidak akan berakhir oleh sebab-sebab yang tercantum dalam pasal 1813 kitab undang-undang Hukum 
					  Perdata, untuk melakukan pembayaran/pemotongan dana dari rekening tersebut di atas sebesar Rp.{{$dataProject->Nominal_Permohonan_Dana}}
					  ({{$dataProject->Terbilang_Nominal_Permohonan_Dana}}) dan menyetorkannya kepada pihak PT Metropolitan Land Tbk pada tanggal {{$dataProject->Tgl_Setor_Dana}} 
					  dengan data rekening sebagai berikut :</p><br>
				   <p>Nomor Rekening Giro 	: {{$dataProject->No_Rek_Giro}}
					   Terdaftar atas nama 	: {{$dataProject->Nama_Rek_Giro}}	
					   Bank Mandiri Cabang  : {{$dataProject->Cabang_Bank_Rek_Giro}}</p><br>

				   <p>Segala risiko yang timbul sebagai akibat dari pemberian kuasa ini menjadi tanggung jawab Pemberi Kuasa sepenuhnya dan Pemberi Kuasa dengan ini melepaskan 
				      dan membebaskan pihak Penerima Kuasa dari segala bentuk tuntutan, klaim, gugatan, ganti rugi, atau keberatan apapun yang timbul dari Pemberi 
					  Kuasa sendiri atau dari pihak manapun sebagai akibat dari pelaksanaan kuasa ini. </p><br>
					<p>Demikian Surat ini dibuat dalam keadaan sebenarnya, tanpa ada paksaan dari pihak manapun untuk senantiasa dipatuhi oleh Penerima Kuasa.</p><br> 
					<br><br>
					<p>Ditetapkan di :	{{$dataProject->Kota_Proyek}}</p>
					<br><br><br>
					<p>{{$dataProject->Nama_Staf}} (Ahli Waris/Pasangan)</p><br>
				</div>				
           </center>
        </div>
        <br><br>
		
        </div>
</body>
</html>