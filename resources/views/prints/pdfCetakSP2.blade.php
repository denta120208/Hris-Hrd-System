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
					<p>Perihal Surat Peringatan II (kedua) atas Tunggakan </p>
					<p>Pembayaran Tanah dan Bangunan : {{$dataProject->Cluster}} {{$dataProject->NoUnit}  <br>
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
			<p>Menindak lanjuti surat kami No. {{$dataProject->NoSP1}} tanggal {{$dataProject->TglSP1}} tentang peringatan I atas adanya keterlambatan pembayaran angsuran Tanah 
			   dan Bangunan  {{$dataProject->NoUnit}} di Perumahan {{$dataProject->PROJECT_DESC}}  untuk angsuran bulan {{$dataProject->BulanSchedule}}
			   yang hingga kini belum ada realisasi pembayaran. 
			   Jumlah tunggakan yang harus dibayar adalah sebesar Rp. {{$dataProject->TotalTagihan}} (jumlah angsuran terhutang Rp. {{$dataProject->NilaiCicilan}} dan total denda per hari ini 
			   Rp. {{$dataProject->NilaiDenda}}), maka untuk menghindari hal-hal yang tidak diinginkan dikemudian hari, serta adanya tindakan hukum lebih lanjut 
			   terhadap Tanah dan Bangunan tersebut, bersama ini kami mengingatkan kembali agar bapak/ibu segera melaksanakan kewajibannya membayar 
			   tunggakan tersebut. </p><br>
			
			<p>Sekedar mengingatkan bahwa sebagaimana ketentuan yang telah disepakati dalam Perjanjian Pengikatan Jual Beli (PPJB), yaitu sebagai berikut: sebagai berikut:<br></p>
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
			<br>
			<p>Mengingat keterlambatan pembayaran angsuran atas Tanah dan Bangunan tersebut, maka kami minta agar Bapak/Ibu untuk segera melaksanakan kewajibannya membayar 
			   tunggakan angsuran dimaksud selambat-lambatnya pada tanggal {{$dataProject->TglPelunasan}} </p><br>
			
			<p>Sehubungan dengan hal-hal tersebut diatas, kami menunggu konfirmasi dari Bapak/Ibu melalui telepon di no. {{$dataProject->ProyekNoTelp}} atau di Fax ke:{{$dataProject->ProyekNoFax}}.</p><br>
			<br>
			<p>Demikian pemberitahuan ini kami sampaikan, atas perhatiannya kami ucapkan terima kasih.</p><br>
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