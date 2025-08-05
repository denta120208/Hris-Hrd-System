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
						<p><strong>No. …/SK/METLAND/TGS/{{bulan}}/{{tahun}}</strong></p>
						<p><strong>Tentang</strong></p>
						<p><strong>PENUGASAN JABATAN</strong></p>
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>Menimbang		:	1.	Hasil evaluasi terhadap kinerja Sdr/i.{{$dataProject->Staf_Metland}}
											2.  Perlunya peningkatan karir yang bersangkutan. </p><br>
					<p>Memperhatikan	:	1.	Usulan {{$dataProject->Div_Head_Metland}} {{$dataProject->PT_Metland}}
											2.	Persetujuan Direksi.</p><br>
					<p>Mengingat		:	1.	Peraturan Perusahaan PT Metropolitan Land Tbk.
											2.	Persetujuan Direksi.</p>
											
					   <p><strong>M E M U T U S K A N</strong></p>
					   <p>Menetapkan		:</p><br>
					   <p>Pertama		: Terhitung tanggal {{$dataProject->Tanggal}} mengangkat Sdr/i.{{$dataProject->Staf_Metland}} sebagai Karyawan Tetap dengan jabatan sebagai {{$dataProject->Level_Staf_Metland}} Dept. {{$dataProject->Dept_Metland}} PT {{$dataProject->PT_Metland}}</p><br>
					   <p>Kedua			: Pelaksanaan tugas berpedoman kepada Job Description dan peraturan yang berlaku di PT Metropolitan Land Tbk dan bertanggung jawab kepada {{$dataProject->Head_Div}} PT Metropolitan Land Tbk.</p><br>
					   <p>Ketiga		: Bahwa jabatan yang dibebankan hendaknya dilaksanakan dengan penuh rasa tanggung jawab.</p><br>
					   <p>Kedua			: Apabila di kemudian hari ternyata terdapat kekurangan/kekeliruan dalam Surat Keputusan ini, maka akan diadakan perubahan atau perbaikan seperlunya.</p><br>
					   
					<br><br>
					<p>Ditetapkan di :	Bekasi</p>
					<p>Kepada ybs :				Pada tanggal 	:	{{$dataProject->Tanggal}}</p>
					<p>{{$dataProject->Nama_PT}}</p><br>
					<p>{{$dataProject->Nama_HRD/Dirut}}</p><br>
					<p>{{$dataProject->Jabatan_HRD/Dirut}}</p>
					<br>
					<p>Tembusan :
							1.	Direksi
							2.	Vice Director
							3.	General Manager
							4.	Arsip
							<br></p>
                </div>
				
           </center>
        </div>
        <br><br>
		
        </div>
</body>
</html>