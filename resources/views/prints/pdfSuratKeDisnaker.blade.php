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
						<p>Lampiran  : 2 (dua) lembar</p>
						<p>Perihal	 : <strong>Pemberitahuan</strong></p>
					</div>
					<div class="kepada">
						<p>Kepada Yth:</p><br>
						<p>Dinas Tenaga Kerja</p><br>
						<p>Pemerintah {{$dataProject->Kota_domisili_PT}}</strong></p>
					</div>
					<div class="bodysurat">
						<p>Dengan Hormat,</p><br>
						<p>Berkaitan dengan Peraturan BPJS Ketenagakerjaan Nomor 7 Tahun 2015 Tentang Petunjuk Pelaksanaan Pembyaran
						   Manfaat Jaminan Hari Tua sebagaimana tertuang dalam pasal 4 ayat 3, bersama ini kami sampaikan
						   {{$dataProject->Keterangan_Keluar}} kami yang bekerja di PT {{$dataProject->PT_Proyek}} dengan
						   data-data tenaga kerja sebagai berikut:</p><br>
						
						<p>Nama					:	{{$dataProject->Staf_Metland}}</p><br>
						<p>Tempat,Tanggal lahir :	{{$dataProject->Tempat_Lahir_Staf}{{$dataProject->Tgl_Lahir_Staf}}</p><br>
						<p>NIK					:	{{$dataProject->NIK_Staf}}</p><br>
						<p>Jabatan				:	{{$dataProject->Jabatan_Staf}}</p><br>
						<p>Alamat				:	{{$dataProject->Alamat_Staf}}</p><br>
						<p>Masa Kerja			:	{{$dataProject->MasaKerja_Staf}}</p><br>						
														
						<p>Demikian surat ini dibuat untuk mendapatkan legalisir dari Dinas Tenaga Kerja Pemerintah {{$dataProject->Kota_domisili_PT}} agar 
						   agar dapat dipergunakan dalam pengurusan BPJS Ketenagakerjaan Jaminan Hari Tua yang bersangkutan.</p><br>
						<p>Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p><br>
						<p>Hormat Kami,</p><br><br><br>
						<p>{{$dataProject->Nama_Atasan}}
						   {{$dataProject->Jabatan_Atasan}}</p>
						<br>
					</div>
					
			   </center>
			</div>
			<br><br>
		
        </div>
</body>
</html>