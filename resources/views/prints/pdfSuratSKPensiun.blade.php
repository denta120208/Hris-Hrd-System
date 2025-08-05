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
						<p><strong>S U R A T  K E P U T U S A N</strong></p>
						<p><strong>No. …/SK/METLAND/PEN/{{bulan}}/{{tahun}}</strong></p>
						<p><strong>Tentang</strong></p>
						<p><strong>MUTASI</strong></p>
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>Menimbang		:	1. Sehubungan dengan pengajuan pensiun dini Sdr. {{$dataProject->Nama_Staf}} di {{$dataProject->PT_Metland}}</p><br>
											
					<p>Memperhatikan	:	1. Surat dari {{$dataProject->GM_Proyek)}} PT {{$dataProject->PT_Proyek}}
					                        2. Persetujuan Direksi.</p><br>
					<p>Mengingat		:	1. Peraturan Perusahaan PT Metropolitan Land Tbk.
					</p><br>
											
					   <p><strong>M E M U T U S K A N</strong></p>
					   <p>Menetapkan		:</p><br>
					   <p>Pertama		: Terhitung tanggal {{$dataProject->Tanggal}} PT {{$dataProject->PT_Proyek}} mengakhiri perjanjian kerja dengan Sdr/i.{{$dataProject->Staf_Metland}}
										  </p><br>
					   <p>Kedua			: Yang bersangkutan telah bekerja di PT {{$dataProject->PT_Proyek}} sejak tanggal {{$dataProject->Staf_joined_date}}</p><br>
					   <p>Ketiga		: Bahwa jabatan yang dibebankan hendaknya dilaksanakan dengan penuh rasa tanggung jawab.</p><br>
					   <p>Kedua			: Apabila di kemudian hari ternyata terdapat kekurangan/kekeliruan dalam Surat Keputusan ini, maka akan diadakan perubahan atau perbaikan seperlunya.</p><br>
					   
					<br><br>
					<p>Ditetapkan di :	Bekasi</p>
					<p>Kepada ybs :				Pada tanggal 	:	{{$dataProject->Tanggal}}</p>
					<p>					{{$dataProject->Nama_PT}}</p><br><br><br>
					<p>					{{$dataProject->Nama_HRD/GM/Dirut}}</p><br>
					<p>					{{$dataProject->Jabatan_HRD/GM/Dirut}}</p>
					<br>
					<p>Tembusan :
							1. Direksi
							2. GM
							3. Arsip
					<br></p>
                </div>
				
           </center>
        </div>
        <br><br>
		
        </div>
</body>
</html>