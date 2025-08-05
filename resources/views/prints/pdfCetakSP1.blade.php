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
					<p>Perihal Surat Peringatan I (pertama) atas Tunggakan</p>
					<p>Pembayaran Tanah dan Bangunan : {{$dataProject->Cluster}} {{$dataProject->NoUnit}   <br>
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
			<p>Bersama ini kami memberitahukan bahwa menurut catatan administrasi kami, sampai dengan tanggal surat ini dibuat,  
			   ternyata Bapak/Ibu masih menunggak pembayaran Tanah dan Bangunan {{$dataProject->NoUnit}} di Perumahan {{$dataProject->PROJECT_DESC}} 
			   untuk angsuran bulan {{$dataProject->BulanSchedule}}. Jumlah tunggakan yang harus dibayar adalah sebesar Rp. {{$dataProject->NilaiCicilan}}
			   (jumlah angsuran terhutang Rp. {{$dataProject->BillTerbilang}} dan total denda per hari ini Rp. {{$dataProject->BillDenda}}. 
			   Untuk menghindari hal yang tidak diinginkan bersama, maka kami minta tunggakan pembayaran tersebut beserta dengan denda-denda yang sudah 
			   dikenakan dapat segera dilunasi selambat-lambatnya tanggal {{$dataProject->BillDate}}</p> <br>
			<p>Hal ini juga dimaksudkan agar tidak terjadi penambahan beban biaya administrasi dan denda keterlambatan pembayaran yang nantinya akan 
			   semakin memberatkan pembayaran berikutnya atas Tanah dan Bangunan yang dimaksud.<br></p>
			<p>Dengan ini kami mengingatkan mengenai ketentuan yang telah disepakati dalam Perjanjian Pengikatan Jual Beli (PPJB), yaitu sebagai berikut:<br></p>
            <p>Pasal 12 ayat 2.a</p><br>
			<p>Apabila PIHAK KEDUA lalai untuk membayar angsuran harga Tanah dan Bangunan serta PPN sesuai dengan ketentuan Pasal 2 dan Pasal 3 PERJANJIAN 
			   ini pada waktu yang telah ditentukan, maka:</p><br>
			<p>a. PIHAK KEDUA dikenakan  denda keterlambatan yang dihitung dari jumlah angsuran terhutang sebesar 1‰ (satu permil) untuk tiap-tiap hari 
			      keterlambatan dan 4% (empat persen) untuk keterlambatan pembayaran yang mencapai 30 (tigapuluh) hari, apabila PIHAK KEDUA lalai 
				  membayar angsuran lebih dari 30 (tigapuluh) hari maka perhitungan denda akan dilakukan secara proposional.</p><br>   
			<p>Demikian surat peringatan kesatu ini kami sampaikan, untuk memenuhi Pasal 12 ayat 2 dalam Perjanjian Pengikatan Jual Beli (PPJB) yang 
			   telah Bapak/Ibu sepakati bersama yaitu tentang "Sanksi atas keterlambatan pembayaran Total Harga Pengikatan oleh PIHAK KEDUA".</p><br>
			<p>Namun demikian apabila setelah diterima surat ini ternyata Bapak/Ibu sudah melakukan pembayaran pelunasan tunggakan, maka kami 
			   mohon maaf dan untuk itu mohon konfirmasi melalui telepon di no. {{$dataProject->ProyekNoTelp}} atau di Fax ke : {{$dataProject->ProyekNoFax}}.</p><br> 
			<p>Atas perhatiannya kami ucapkan terima kasih.</p><br>
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