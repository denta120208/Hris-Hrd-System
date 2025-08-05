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
					<p>Nomor : </p>
					<p>Perihal Pembatalan Perjanjian Pengikatan Jual Beli </p>
					<p>Nomor: {{$dataProject->NomorPPJB}}<br>
	            </div>
				<div class="headeratas2">
                    <p>Kepada Yth:</p>
					<p>Bapak/Ibu : {{$dataProject->Nama_Customer}}<br></p>
					<p>{{$dataProject->Alamat}}<br></p>
					<p>{{$dataProject->Kota}}<br></p>
                </div>
           </center>
        </div>
        <br><br>
		<div class="bodytengah1">
            <p>Dengan hormat,</p><br><br>
			<p>Sehubungan dengan Surat yang telah kami sampaikan kepada Bapak/Ibu, yaitu :<br></p>
			<p>1. Nomor : {{$dataProject->NoSP1}} tanggal {{$dataProject->TglSP1}} tentang Peringatan I</p><br>
			<p>2. Nomor : {{$dataProject->NoSP2}} tanggal {{$dataProject->TglSP2}} tentang Peringatan II </p><br>
			<p>3. Nomor : {{$dataProject->NoSP3}} tanggal {{$dataProject->TglSP3}} tentang Peringatan III </p><br>
			
			<p>Sampai dengan ditandatanganinya surat ini, surat-surat kami tersebut diatas tidak memperoleh tanggapan yang baik dan Bapak/Ibu 
			   tidak melaksanakan kewajibannya untuk menyelesaikan seluruh tunggakan pembayaran tanah dan bangunan yang terletak di {{$dataProject->Cluster}} 
               {{$dataProject->NoUnit}} Perumahan {{$dataProject->ProjectName}}.<br></p>
            <p>Pasal 12 ayat 2.b</p><br>
			<p>Apabila PIHAK KEDUA lalai untuk membayar angsuran harga Tanah dan Bangunan serta PPN sesuai dengan ketentuan Pasal 2 dan Pasal 3 PERJANJIAN ini pada waktu yang 
			   telah ditentukan, maka:</p><br>
			<p>b. PIHAK PERTAMA akan memberitahukan kepada PIHAK KEDUA mengenai kelalaian pembayaran PIHAK KEDUA tersebut sebanyak 3 (tiga) kali berturut-turut, apabila 
			   keterlambatan pembayaran telah melebihi 30 (tigapuluh) hari dan pemberitahuan tersebut tidak ditanggapi PIHAK KEDUA dengan  dilakukannya pembayaran secara 
			   penuh atas angsuran dan denda (jika ada) yang terhutang, maka PIHAK PERTAMA berhak melakukan pembatalan secara sepihak atas PERJANJIAN ini, tanpa memerlukan 
			   pembatalan oleh Pengadilan dan dengan ini mengesampingkan ketentuan dalam Pasal 1266 dan Pasal 1267 Kitab Undang-Undang Hukum Perdata Indonesia ("KUHPerdata").</p><br>   
            <p>Pasal 13 ayat 1.a.</p><br>
			<p>1. PIHAK PERTAMA dan PIHAK KEDUA sepakat satu sama lain bahwa PERJANJIAN ini dapat dibatalkan apabila terjadi hal-hal sebagai berikut:</p><br>
			<p>a. Dalam hal PIHAK KEDUA tidak memenuhi kewajiban untuk membayar harga Tanah dan Bangunan sebagaimana dimaksud pada ketentuan Pasal 2 PERJANJIAN ini.</p><br>   
			<p>Pasal 14 ayat 1 dan 2<br></p>
			<p>PIHAK PERTAMA dan PIHAK KEDUA sepakat satu sama lain bahwa apabila PERJANJIAN ini menjadi batal, maka akan berlaku ketentuan-ketentuan sebagai berikut:<br></p>	
			<p>1. Tanah dan Bangunan yang menjadi objek dari PERJANJIAN ini tetap merupakan hak milik PIHAK PERTAMA sepenuhnya dan oleh karenanya PIHAK PERTAMA sepenuhnya berhak 
			      untuk menawarkan dan atau menjual kembali Tanah dan Bangunan tersebut.<br></p>	
			<p>2. PIHAK KEDUA berkewajiban untuk menyerahkan Tanah dan Bangunan dimaksud dalam keadaan kosong dan baik kepada PIHAK PERTAMA selambat lambatnya dalam waktu 14 
			     (empat belas) hari terhitung sejak adanya pembatalan PERJANJIAN dan PIHAK KEDUA menerima surat pembatalan PERJANJIAN yang akan dibuat tersendiri oleh PIHAK 
				 PERTAMA, untuk setiap hari keterlambatan pengosongan tersebut PIHAK KEDUA setuju membayar denda sebesar Rp. 500.000,00 (lima ratus ribu rupiah) perhari kepada 
				 PIHAK PERTAMA.<br></p>	
			
			<br>
			<p>Mengingat ketentuan tersebut diatas maka dengan ini kami menyatakan MEMBATALKAN SECARA SEPIHAK Perjanjian Pengikatan Jual Beli (PPJB) Nomor {{$dataProject->NoPPJB}} 
			   tanggal {{$dataProject->TglPPJB}}.</p><br>
			
			<p>Demikian pemberitahuan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.</p><br>
		</div> 
		<br><br>
        <div class="headerbawah">
		<p>
            Hormat Kami,<br>
            {{$dataProject->PROJECT_PT}}<br><br><br>
            {{$dataProject->NamaDirut}}<br></p>
            <p>{{$dataProject->JabatanDirut}}</p><br>
			<p>Cc : Departemen Legal</p>
        </div> 
        </div>
</body>
</html>