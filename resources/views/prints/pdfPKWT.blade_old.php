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
				<div class ="header">
					<p>F-HO&PROJECT/HRD-13</p>
				</div>
				<div class ="judul">
						<p><strong>KESEPAKATAN KERJA UNTUK WAKTU TERTENTU</strong></p>
						<p><strong>No. …/KKWT/HRD/ML/VIII/20</strong></p>
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>1. Nama 		: {{$dataProject->Nama_Metland}}</p>
					   <p>Jabatan 	: {{$dataProject->Jabatan_Metland}}</p>
					   <p>Alamat 	: {{$dataProject->Alamat_Metland}}</p>
					   <br>
					<p>Dalam Kesepakatan Kerja ini bertindak untuk dan atas nama Perusahaan PT. METROPOLITAN LAND TBK 
					   berkedudukan di Bekasi, selanjutnya sebagai Pengusaha disebut <strong>PIHAK PERTAMA</strong>.</p>
					<br><br>
					<p>2. Nama 		: {{$dataProject->Nama_Staf}}</p>
					   <p>Jabatan 	: {{$dataProject->Jabatan_Staf}}</p>
					   <p>Alamat 	: {{$dataProject->Alamat_Staf}}</p>
					   <br>
					<p>Dalam Kesepakatan Kerja ini sebagai Pekerja bertindak untuk dan atas nama sendiri yang selanjutnya di sebut <strong>PIHAK KEDUA</strong>.<br></p>
                </div>
				<div class="tengah">
                    <p>Pada hari ini {{$dataProject->Hari}} tanggal {{$dataProject->Tgl}} bertempat di Bekasi, PIHAK PERTAMA dan PIHAK KEDUA mengadakan Kesepakatan Kerja Untuk Waktu Tertentu, dengan 
					   ketentuan-ketentuan seperti tersebut dalam pasal-pasal berikut ini :</p>
				</div>
           </center>
        </div>
        <br><br>
		<div class="bodytengah1">
            <p>PASAL 1</p><br>
			<p>JANGKA WAKTU</p><br>
			<p>1. Kesepakatan ini dibuat untuk jangka waktu {{$dataProject->lama_kontrak}} ({{$dataProject->terbilang_kontrak}) tahun terhitung mulai tanggal {{$dataProject->awal_kontrak} sampai dengan tanggal {{$dataProject->akhir_kontrak}</p> <br>
			<p>2. Jika diperlukan Kesepakatan Kerja ini dapat diperpanjang sesuai dengan ketentuan yang berlaku.</p><br><br>
			
			<p>PASAL 2</p><br>
			<p>TUGAS DAN PENEMPATAN</p><br>
			<p>1. PIHAK PERTAMA mempekerjakan PIHAK KEDUA sebagai {{$dataProject->staf_posisi}} ({{$dataProject->staf_level}})  Dept. {{$dataProject->staf_dept}} Nama PT {{$dataProject->staf_PT}}</p><br>
            <p>2. PIHAK KEDUA akan melaksanakan tugas pekerjaannya dengan sebaik-baiknya.</p><br>
			<p>3. Bila dipandang perlu PIHAK PERTAMA dapat menempatkan PIHAK KEDUA pada tugas-tugas pekerjaan lain yang sesuai dengan kemampuannya.</p><br><br>
			
			<p>PASAL 3</p><br>
			<p>PENGUPAHAN</p><br>
			<p>Sebagai imbalan jasa atas pelaksanaan kewajiban-kewajibannya, PIHAK KEDUA akan menerima penghasilan pada setiap akhir bulan dari PIHAK PERTAMA sesuai perincian terlampir.</p><br>   
			
			<p>PASAL 4</p><br>
			<p>CUTI</p><br>
			<p>Cuti, Izin, dll diatur sesuai dengan ketentuan yang berlaku dalam Peraturan Perusahaan.</p><br>
			
			<p>PASAL 5</p><br>
			<p>PERATURAN DAN TATA TERTIB PERUSAHAAN</p><br>
			<p>1. Selama adanya hubungan kerja, PIHAK KEDUA wajib mematuhi ketentuan-ketentuan yang tercantum dalam Peraturan dan Tata Tertib Perusahaan.</p><br> 
			<p>2. Pelanggaran terhadap Peraturan dan Tata Tertib Perusahaan dapat dikenakan sanksi berupa bentuk Surat Teguran, Surat Peringatan, Skorsing atau Pemutusan Hubungan Kerja.</p><br>

			<p>PASAL 6</p><br>
			<p>PEMUTUSAN HUBUNGAN KERJA</p><br>
			<p>1. Hubungan kerja antara PIHAK PERTAMA dan PIHAK KEDUA dapat berakhir sebelum selesainya jangka waktu sebagaimana disebut dalam Pasal 1 Perjanjian Kerja ini dikarenakan sebab-sebab sebagai berikut:</p><br> 
			<p>(a) Pemutusan hubungan kerja sepihak yang dilakukan oleh PIHAK PERTAMA kepada PIHAK KEDUA dikarenakan PIHAK KEDUA melakukan pelanggaran terhadap ketentuan perundang-undangan dan/atau diduga melakukan perbuatan pidana dan/atau melanggar ketentuan sebagaimana disebut di dalam Peraturan Perusahaan.</p><br>
			<p>(b) Pemutusan hubungan kerja sepihak yang dilakukan oleh PIHAK KEDUA kepada PIHAK PERTAMA dikarenakan PIHAK KEDUA undur diri dan/atau berkeinginan untuk tidak meneruskan masa kerja.</p><br>
			
			<p>2. Dalam hal terjadinya kondisi sebagaimana disebut dalam ayat 1 huruf (a) Pasal ini, maka PIHAK KEDUA berdasarkan Perjanjian Kerja ini melepaskan haknya untuk menuntut kepada dan/atau menerima dari PIHAK PERTAMA berupa sisa pembayaran Upah sebesar yang ditetapkan berdasarkan Perjanjian Kerja ini 
			   terhitung efektif sejak dilakukannya pemutusan hubungan kerja oleh PIHAK PERTAMA sampai dengan masa berakhirnya jangka waktu Perjanjian Kerja ini serta melepaskan segala hak untuk menuntut ganti rugi lain yang terkait daripadanya apabila ada.</p><br>
			<p>3. Dalam hal terjadinya kondisi sebagaimana disebut dalam ayat 1 huruf (b) Pasal ini, maka PIHAK KEDUA wajib memberitahukan PIHAK PERTAMA melalui notifikasi tertulis paling lambat 1 (satu) bulan sebelumnya dan dalam hal ini PIHAK PERTAMA sepakat untuk melepaskan hak menuntut ganti rugi sebesar Upah yang ditetapkan berdasarkan Perjanjian Kerja ini sampai dengan jangka waktu Perjanjian Kerja berakhir.</p><br>
			<p>4. Hal mana apabila PIHAK KEDUA cukup untuk patut diduga terlibat dengan persoalan hukum (baik perdata dan/atau pidana) yang berkaitan langsung dan/atau tidak berkaitan dengan PIHAK PERTAMA, maka berdasarkan ketentuan Perjanjian Kerja ini tanpa perlu menunggu putusan hakim yang memiliki kekuatan hukum tetap, maka dapat diberlakukan kondisi sebagaimana dimaksud dalam ayat 1 huruf (a) di atas dengan memperhatikan ketentuan ayat 2 Pasal ini.</p><br>
			<p>5. Apabila PIHAK PERTAMA ataupun PIHAK KEDUA tidak ingin meneruskan Kesepakatan Perjanjian Kerja ini sampai pada sesuai jangka waktu yang telah disepakati bersama, maka baik PIHAK PERTAMA ataupun PIHAK KEDUA dapat memutuskan Perjanjian Kerja ini dengan cara memberitahukan 1 (satu) bulan sebelumnya kepada pihak lainnya dan masing-masing pihak telah setuju untuk tidak saling menggugat dan menuntut segala bentuk kerugian apapun yang timbul.</p><br>
			
			<p>PASAL 7</p><br>
			<p>PENYELESAIAN PERSELISIHAN</p><br>
			<p>Apabila dalam pelaksanaan Perjanjian Kerja ini timbul perselisihan, maka baik PIHAK PERTAMA maupun PIHAK KEDUA sepakat akan berusaha untuk menyelesaikan segala perselisihan yang timbul secara musyawarah.</p><br>

			<p>PASAL 8</p><br>
			<p>HAL HAL LAIN</p><br>
			<p>1. Dengan ditandatanganinya Perjanjian Kerja ini, dengan ini PIHAK KEDUA telah mengetahui dan patuh terhadap Peraturan Perusahaan dan/atau peraturan/ketentuan lain yang berlaku di PIHAK PERTAMA.<p><br>
			<p>2. Hal-hal lain mengenai syarat kerja, Hak dan Kewajiban dan sebagainya yang belum tercantum dalam Kesepakatan Perjanjian Kerja ini diatur sesuai dengan Peraturan Perusahaan dan ketentuan-ketentuan yang berlaku.</p><br>
			<p>3. Selain apa yang telah ditetapkan dalam Kesepakatan Kerja ini PIHAK KEDUA tidak berhak atas pembayaran tunjangan ataupun fasilitas lainnya, kecuali ditentukan lain oleh PIHAK PERTAMA secara tertulis.</p><br>
			<p>4. Jika terdapat kekeliruan dan atau kekurangan dalam Kesepakatan Kerja ini, maka dapat diadakan perbaikan-perbaikan dan atau perubahan-perubahan sebagaimana mestinya.</p><br>
			<br>
			<br>
			<p>Demikian Kesepakatan Kerja Untuk Waktu Tertentu ini dibuat dalam rangkap 2 (dua) dan mulai berlaku sejak tanggal ditanda tanganinya Kesepakatan Kerja ini.</p>
			<br><br>
		</div> 
		<br><br>
        <div class="headerbawah">
            <p>Bekasi, tanggal_tandatangan</p><br>
            <p>PIHAK PERTAMA										PIHAK KEDUA</p>
			<br><br><br><br>
			<p>{{$dataProject->Nama_Metland}}						{{$dataProject->Nama_Staf}}</p><br>
			<p>{{$dataProject->Jabatan_Metland}}</p><br>
        </div> 
        </div>
</body>
</html>