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
						<p><strong>S U R A T  K E T E R A N G A N</strong></p>
						<p><strong>No. …/Ket/METLAND/HRD/{{bulan}}/{{tahun}}</strong></p>
						
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>				Nama		:  {{$dataProject->Nama_HRD}} 
									Jabatan     :  {{$dataProject->Jabatan_HRD}} PT{{$dataProject->PT_Metland}}</p><br><br>
											
					<p>Menerangkan bahwa:</p>
					<p>				Nama		:  {{$dataProject->Nama_Staf}} 
									Jabatan     :  {{$dataProject->Jabatan_Staf}} PT {{$dataProject->PT_Metland}}</p><br>	
						
				   <p>Menerangkan bahwa yang bersangkutan adalah benar karyawan PT {{$dataProject->PT_Metland}} Unit/Proyek {{$dataProject->Nama_Proyek}} 
				      terhitung sejak tanggal {{$dataProject->Tgl_Staf_Joined}} sampai dengan {{$dataProject->Tgl_Surat}} dengan jabatan tersebut di atas.</p><br>
				   <p>Yang bersangkutan {{$dataProject->Alasan_Resign}}.</p><br>
				   <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p><br>
					<br><br>
					<p>Ditetapkan di :	Bekasi</p>
					<p>Kepada ybs :				Pada tanggal 	:	{{$dataProject->Tanggal}}</p>
					<p>					{{$dataProject->Nama_PT}}</p><br><br><br>
					<p>					{{$dataProject->Nama_HRD/GM/Dirut}}</p><br>
					<p>					{{$dataProject->Jabatan_HRD/GM/Dirut}}</p>
					<br>
				</div>
				
           </center>
        </div>
        <br><br>
		
        </div>
</body>
</html>