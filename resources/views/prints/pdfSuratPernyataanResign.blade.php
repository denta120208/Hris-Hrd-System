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
							<p><strong>S U R A T  P E R N Y A T A A N</strong></p>						
					</div>
					<div class="headeratas">
						<p>Sehubungan dengan berakhirnya hubungan kerja atas nama saya sebagai {{$dataProject->Jabatan_Staf}} terhitung sejak tanggal {{$dataProject->LastDay_Date}}, maka dengan ini saya :</p><br>
						<p>Nama					:	{{$dataProject->Staf_Metland}}</p><br>
						<p>Tempat,Tanggal lahir :	{{$dataProject->Tempat_Lahir_Staf}{{$dataProject->Tgl_Lahir_Staf}}</p><br>
						<p>Alamat				:	{{$dataProject->Alamat_Staf}}</p><br>
												
						<p>Menyatakan bahwa :</p><br>
						   <p>1. Dengan berakhirnya status kepegawaian saya di PT Metropolitan Land Tbk, saya tidak akan memberikan data dan informasi perusahaan yang bersifat rahasia kepada pihak lain, dan tidak akan menggunakan data dan informasi perusahaan dalam bentuk apapun untuk kepentingan pribadi maupun pihak lain.</p><br>
						   <p>2. Pelanggaran terhadap hal-hal yang telah disebutkan didalam surat pernyataan, maka saya bersedia untuk menerima konsekuensi hukum yang ada.</p><br>
						   <p>3. Atas pernyataan saya tersebut di atas, saya tidak akan mengajukan tuntutan dalam bentuk apapun dikemudian hari kepada perusahaan.</p><br>
						   
						<br><br>
						<p>Demikian surat pernyataan ini saya buat dengan sebenarnya.</p><br>
						<p>{{$dataProject->Nama_Kota}},{{$dataProject->TglCetak}}</p>
						<br><br>
						<p>materai Rp.6000</p>
						<br><br>
						<p>{{$dataProject->Nama_Staf}}</p><br>
					</div>
					
			   </center>
			</div>
			<br><br>
		
        </div>
</body>
</html>