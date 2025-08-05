<html>
    <header>
        <style>
			@page { margin: 10mm;}
			div.headeratas{
				margin: 0 auto;
				padding-top: 70px;
				padding-bottom: 20px;
				text-align:justify;
				font-size: 12px;
				font-weight: bold;
			}
			.headeratas > p{
				width: 800px;
				text-align:justify;
			}
			.headeratas > ol {
				margin: inherit;
				text-align: justify;
				padding-left: 300px;
			}
			div.headeratas2{
				text-align:justify;
				margin-top:1em;
				font-size: 12px
			}
			div.bodytengah1{
				text-align:justify;
				margin-top:1em;
				font-size: 12px
			}
			div.headerbawah{
				margin-top:3em;
				text-align:justify;
				font-size: 10px;
			}
        </style>
    </header>
    <body>
        <div class="row">
       <!--TEMPAT LAMPIRAN-->
       <div>
           <center>
                <div class="headeratas">
                    <p>{{ $empSup->location->city }}, {{ date('d-m-Y', strtotime($reqPunish->created_at)) }}</p>
					<p>Nomor : {{ $punish->punish_doc_no }}</p>
					<p>Hal : {{ $reqPunish->punishment_type->descs }}</p>
                </div>
				<div class="headeratas2">
                    <p>Kepada Yth:</p>
					<p>Bapak/Ibu : {{ ucwords(strtolower($empSub->emp_fullname)) }}</p>
					<p>Jabatan : {{ ucwords(strtolower($empSub->job_title->job_title)) }}</p>
					<p>Proyek/Unit : {{ $empSub->location->name }}</p>
                </div>
           </center>
        </div>
        <br><br>
		<div class="bodytengah1">
            <p>Dengan hormat,</p><br><br>
			<p>Bersama ini kami sampaikan bahwa berdasarkan data / laporan {{ $reqPunish->punish_reason }} , Saudara telah melakukan pelanggaran terhadap Peraturan Perusahaan PT Metropolitan Land Tbk khususnya Pasal sebagai berikut:</p>
			<p style="padding-left: 35px; font-weight: bold;">{{ $reqPunish->punish_pasal }}</p>
			<p>Sehubungan dengan hal tersebut, maka kami memberikan <strong>{{ $reqPunish->punishment_type->descs }}</strong> kepada Saudara. Surat Peringatan ini berlaku selama 6 (enam) bulan sejak tanggal diterbitkan, apabila Saudara kembali melakukan pelanggaran yang sama, maka manajemen akan memberikan sanksi yang lebih tinggi.</p>

			<p>Surat Peringatan ini berpengaruh terhadap penerimaan bonus secara langsung dan dapat mengakibatkan penundaan kenaikan tingkat/jabatan maupun kenaikan gaji.</p>
			<p>Demikian Surat Peringatan ini kami berikan agar Saudara lebih baik dalam menjalankan tugas dan tanggung jawab Saudara.</p><br>

			<p>Hormat Kami,</p><br><br><br><br>
			<p>{{ ucwords(strtolower($empSup->emp_fullname)) }}</p>
		</div>
        <div class="headerbawah">
            <p>Tembusan :
				<ol>
					<li>Direksi</li>
					<li>HR Dept</li>
					<li>Arsip</li>
				</ol>
			</p>
        </div> 
        </div>
</body>
</html>