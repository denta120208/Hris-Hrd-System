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
					<div class="header1">
						<p>{{$dataProject->Kota}}, {{$dataProject->TanggalSurat}}</p><br><br>
						<p>Nomor : {{$dataProject->Nomor_Surat}}/S.Ket/HRD/{{bulan}}/{{tahun}}</p><br>
						<p>Perihal	 : <strong>Berakhirnya Hubungan Kerja</strong></p>
					</div>
					<div class="kepada">
						<p>Kepada :</p><br>
						<p>Bapak/Ibu/Sdr. {{$dataProject->NamaStaf}}</p><br>
						<p>di tempat</strong></p>
					</div>
					<div class="bodysurat">
						<p>Dengan Hormat,</p><br>
						<p>Sehubungan dengan Bapak/Ibu/Sdr yang telah {{$dataProject->Alasan_berakhir_Staf}} {{Pensiun/PensiunDini/PHK/PKWT/Resign/Meninggal}}, dan telah mendapatkan persetujuan dari Direksi PT Metropolitan Land Tbk, 
						   maka dengan ini disampaikan bahwa terhitung tanggal {{$dataProject->LastDay_Date}} hubungan kerja Bapak/Ibu/Sdr dengan
						   perusahaan berakhir.</p><br>
						 <p>Untuk itu kami akan segera menyelesaikan perhitungan pensiun atas nama Bapak/Ibu/Sdr.</p><br>
																	
						<p>Demikian kami disampaikan, atas perhatian dan kerjasama-nya kami ucapkan terima kasih.</p><br>
						   
						<p>Hormat Kami,</p><br><br><br>
						<p>{{$dataProject->Nama_Atasan}}
						   {{$dataProject->Jabatan_Atasan}}</p>
						<br>
						<p>Tembusan:
						   - Direksi
						   - GM Proyek {{$dataProject->Nama_Proyek}}
						   - HRD Dept</p><br>
					</div>
					
			   </center>
			</div>
			<br><br>
		
        </div>
</body>
</html>