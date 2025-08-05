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
				<div class="headeratas">
					<p>{{ $empSup->location->city }}, {{ date('d-m-Y', strtotime($reqPunish->created_at)) }}</p>
					<p>Nomor : {{ $punish->punish_doc_no }}</p>
					<p>Hal	 : <strong>Surat Teguran</strong></p>
				</div>
				<div class="headeratas2">
					<p>Kepada :</p>
					<p>Sdr/i. {{ ucwords(strtolower($empSub->emp_fullname)) }}</p>
					<p>Jabatan : {{ ucwords(strtolower($empSub->job_title->job_title)) }}</p>
					<p>Proyek/Unit : {{ $empSub->location->name }}</p>
				</div>
				<div class="bodytengah1">
					<p>Dengan Hormat,</p><br>
					<p>Sehubungan dengan pelanggaran Saudara/i, yaitu <strong>{{ $reqPunish->punish_reason }}</strong> yang melanggar Peraturan Perusahaan Pasal <strong>{{ $reqPunish->punish_pasal }}</strong> dengan ini kami memberikan <strong>Surat Teguran</strong> kepada Saudara/i.</p><br>
					<p>Surat teguran ini berlaku 6 bulan sejak tanggal dikeluarkan.</p><br>
					<p>Demikian Surat Teguran ini disampaikan, agar Saudara/i lebih memperhatikan dan menjalankan tugas dan tanggung jawab Saudara/i dengan baik.</p><br>

					<p>Hormat Kami,</p><br><br><br>
					<br>
					<p>{{ ucwords(strtolower($empSup->emp_fullname)) }}</p>
				</div>
				<div class="headerbawah">
					<p>Tembusan:
					<ol>
						<li>Direksi</li>
						<li>HRD Dept</li>
					</ol></p>
				</div>
			</div>
		</div>
</body>
</html>