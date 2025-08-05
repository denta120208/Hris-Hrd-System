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
                <div class="headeratas">
                    <p>Nama Kota, tanggal cetak</p>
					<p>Nomor : {{nomor_surat_MCU}}/HRD/S.Kel/I/20</p><br>
					<p>Perihal Pengantar Psikotest</p>
					
	            </div>
				<div class="headeratas2">
                    <p>Kepada Yth:</p>
					<p>{{$dataProject->Nama_Konsultan}}<br></p>
					<p>{{$dataProject->Alamat_Konsultan}}<br></p>
					<p>{{$dataProject->Kota_Konsultan}}<br></p>
                </div>
           </center>
        </div>
        <br><br>
		<div class="bodytengah1">
            <p>Dengan hormat,</p><br><br>
			<p>Bersama surat ini kami kirimkan 1 (satu) orang calon karyawan PT {{$dataProject->Nama_PT}}. Proyek/Unit {{$dataProject->Nama_Unit}}, untuk dilakukan test kesehatan atas nama :<br></p>
			<p>Hari, tanggal : hari/tanggal {{$dataProject->hari_Tgl_psikotes}}</p><br>
			<p>Waktu	  	 :	jam {{$dataProject->jam_mcu}} </p><br>
			<p>Paket Test 	: {{$dataProject->paket_mcu}} </p><br>
			<p>Lokasi Test	: {{$dataProject->Alamat_Konsultan}} {{$dataProject->Kota_Konsultan}}</p><br>
			<p>Nama Peserta	: {{$dataProject->Nama_staf}} </p><br>
			
			<p>Demikian surat pengantar kami, kami harap laporan hasil tes tersebut dapat segera diberikan kepada kami, untuk tagihannya agar di atasnamakan PT {{$dataProject->Nama_PT}} 
               <br></p><br>
            <p>Terima kasih atas perhatian dan kerjasamanya.</p><br>
			
		<br><br>
        <div class="headerbawah">
		<p>
            Hormat Kami,<br>
            <p>{{$dataProject->PROJECT_PT}}</p><br><br><br>
            <p>{{$dataProject->NamaHRD}}<br></p>
            <p>{{$dataProject->JabatanHRD}}</p><br>
			<p>Cc : HRD Pusat</p>
        </div> 
        </div>
</body>
</html>