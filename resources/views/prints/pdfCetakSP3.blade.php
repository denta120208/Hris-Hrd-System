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
					<p>Perihal Surat Peringatan III (ketiga) atas Tunggakan </p>
					<p>Pembayaran Tanah dan Bangunan : Cluster + Kode Unit  <br>
					   Perumahan : {{$dataProject->PROJECT_DESC}}<br></p>
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
			<p>Sehubungan dengan Surat Peringatan kami ke I (Pertama)dan II (Kedua) yang telah disampaikan kepada Bapak/Ibu tidak mendapat tanggapan 
			   dan perhatian untuk melaksanakan kewajiban pembayaran seluruh tunggakan atas tanah dan bangunan yang telah dibeli yaitu Angsuran 
			   ........... & ................  
			   Sampai dengan tanggal surat ini dibuat, Jumlah tunggakan yang harus dibayar adalah sebesar Rp {{$dataProject->TotalCicilan}} 
			   (jumlah angsuran terhutang Rp {{$dataProject->NilaiCicilan}} dan total denda Rp {{$dataProject->NilaiDenda}}).
			   Kami menyimpulkan bahwa Bapak/Ibu tidak mempunyai itikad baik untuk menyelesaikan tunggakan pembayaran yang menjadi kewajiban 
			   Bapak/Ibu.
			<br></p>
			
			<p>Menurut catatan administrasi kami, terhitung sejak tanggal {{$dataProject->CicilanPalingTua}} hingga tanggal ditandatanganinya surat 
			   ini ternyata Bapak / Ibu tidak lagi melaksanakan pembayaran angsuran untuk Tanah dan Bangunan di {{Cluster + Kode Unit}}  di 
			   Perumahan {{$dataProject->PROJECT_DESC}}. <br></p><br>
			<p>Mengacu pada Perjanjian Pengikatan Jual Beli (PPJB) yang telah disepakati dan di tegaskan sebagai berikut:<br></p>
            <p>Pasal 12 ayat 2.b</p><br>
			<p>"PIHAK PERTAMA akan memberitahukan kepada PIHAK KEDUA mengenai kelalaian pembayaran PIHAK KEDUA tersebut sebanyak 3 (tiga) kali 
			   berturut-turut, apabila keterlambatan pembayaran telah melebihi 30 (tigapuluh) hari dan pemberitahuan tersebut tidak ditanggapi 
			   PIHAK KEDUA dengan  dilakukannya pembayaran secara penuh atas angsuran dan denda (jika ada) yang terhutang, maka PIHAK PERTAMA 
			   berhak melakukan pembatalan secara sepihak atas PERJANJIAN ini, tanpa memerlukan pembatalan oleh Pengadilan dan dengan ini 
			   mengesampingkan ketentuan dalam Pasal 1266 dan Pasal 1267 Kitab Undang-Undang Hukum Perdata Indonesia ("KUHPerdata")"</p><br>
			<p>Pasal 13 ayat 1.a</p><br> 
			<p>1. PIHAK PERTAMA dan PIHAK KEDUA sepakat satu sama lain bahwa PERJANJIAN ini dapat dibatalkan apabila terjadi hal-hal sebagai berikut:<br></p>	
			<p>a. Dalam hal PIHAK KEDUA tidak memenuhi kewajiban untuk membayar harga Tanah dan Bangunan sebagaimana dimaksud pada ketentuan Pasal 2 PERJANJIAN ini.<br></p>
			<p>Pasal 14 ayat 1 dan 2<br></p>
			<p>PIHAK PERTAMA dan PIHAK KEDUA sepakat satu sama lain bahwa apabila PERJANJIAN ini menjadi batal, maka akan berlaku ketentuan-ketentuan sebagai berikut:<br></p>	
			<p>1. Tanah dan Bangunan yang menjadi objek dari PERJANJIAN ini tetap merupakan hak milik PIHAK PERTAMA sepenuhnya dan oleh karenanya PIHAK PERTAMA sepenuhnya berhak 
			      untuk menawarkan dan atau menjual kembali Tanah dan Bangunan tersebut.<br></p>	
			<p>2. PIHAK KEDUA berkewajiban untuk menyerahkan Tanah dan Bangunan dimaksud dalam keadaan kosong dan baik kepada PIHAK PERTAMA selambat lambatnya dalam waktu 14 
			     (empat belas) hari terhitung sejak adanya pembatalan PERJANJIAN dan PIHAK KEDUA menerima surat pembatalan PERJANJIAN yang akan dibuat tersendiri oleh PIHAK 
				 PERTAMA, untuk setiap hari keterlambatan pengosongan tersebut PIHAK KEDUA setuju membayar denda sebesar Rp. 500.000,00 (lima ratus ribu rupiah) perhari kepada 
				 PIHAK PERTAMA.<br></p>	
			
			<p>Bahwa untuk menghindari hal-hal yang tidak diinginkan bersama, maka kami mengharapkan agar Bapak/Ibu segera melaksanakan pembayaran Tanah dan Bangunan dimaksud 
			   selambat lambatnya tanggal {{$dataProject->TglDateline}}.</p><br>
			<p>Apabila dalam batas waktu tersebut Bapak/Ibu belum juga melaksanakan kewajiban menyelesaikan seluruh tunggakan pembayaran rumah maka dengan sangat terpaksa kami 
			   akan melakukan pembatalan secara sepihak sesuai dengan Perjanjian Pengikatan Jual Beli (PPJB) yang telah disepakati bersama.</p><br> 
			<p>Demikian surat pemberitahuan ini kami sampaikan atas perhatiannya diucapkan terima kasih.</p><br>
		</div> 
		<br><br>
        <div class="headerbawah">
            Hormat Kami,<br>
            {{$dataProject->PROJECT_PT}}<br><br><br>
            {{$dataProject->NamaChiefFinance}}<br>
            <p>Chief Finance</p><br>
			Cc : {{$dataProject->NamaGM}}
        </div> 
        </div>
</body>
</html>