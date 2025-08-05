<html>
    <header>
        <style>
			@page { margin: 10mm;}
			.judul{
				margin: auto 0;
				text-align:center;
			}
			div.headeratas{
				margin: 0 auto;
				/*padding-left: 2em;*/
				text-align:center;
				font-size: 10px
			}
			.headeratas > p{
				margin: inherit;
				padding-top: 1em;
				width: 800px;
				text-align:center;
			}
			.headeratas > ol {
				margin: inherit;
				text-align: justify;
				padding-left: 300px;
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
						<p><strong>No. {{ $demo->demo_doc_no }}</strong></p>
						<p><strong>Tentang</strong></p>
						<p><strong>DEMOSI</strong></p>
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>Menimbang:
						<ol>
							<li>Adanya kebutuhan akan jabatan {{ $reqDemo->level_to->job_title }} di {{ $empSub->location->name }}</li>
						</ol>
					</p><br>
											
					<p>Memperhatikan:
						<ol>
							<li>Persetujuan Direksi.</li>
						</ol>
					</p><br>
					<p>Mengingat:
					<ol>
						<li>Peraturan Perusahaan PT Metropolitan Land Tbk.</li>
						<li>Persetujuan Direksi.</li>
					</ol>
					</p><br>
					   <p><strong>M E M U T U S K A N</strong></p>
					   <p>Menetapkan		:</p><br>
					   <p>Pertama		: Terhitung tanggal {{ date('d-m-Y', strtotime($reqDemo->created_at)) }} memdemosikan Sdr/i.{{ $empSub->emp_fullname }} dari jabatan {{ $reqDemo->level_from->job_title }} Dept. {{ $empSub->emp_dept->name }}, {{ $empSub->location->companny }}
										  menjadi {{ $reqDemo->level_to->job_title }}
										  </p><br>
					   <p>Kedua			: Pelaksanaan tugas berpedoman kepada Job Description dan peraturan yang berlaku di PT Metropolitan Land Tbk dan bertanggung jawab kepada {{ $empSup->emp_fullname }} PT {{ $empSup->location->companny }}.</p><br>
					   <p>Ketiga		: Bahwa jabatan yang dibebankan hendaknya dilaksanakan dengan penuh rasa tanggung jawab.</p><br>
					   <p>Kedua			: Apabila di kemudian hari ternyata terdapat kekurangan/kekeliruan dalam Surat Keputusan ini, maka akan diadakan perubahan atau perbaikan seperlunya.</p><br>
					<br><br>
				   <p>Ditetapkan di :	Bekasi</p>
				   <p>Kepada ybs : Pada tanggal: {{ date('d-m-Y', strtotime($reqDemo->created_at)) }}</p>
				   <p>{{ $empSub->location->companny }}</p><br>
				   <p>{{ $hrd->name }}</p><br>
				   <p>GM/Dirut HRD</p>
				   <br>
				   <p>Tembusan:
					   <ol>
						   <li>Direksi</li>
						   <li>Arsip</li>
					   </ol>
				   </p>
			   </div>
           </center>
        </div>
        <br><br>
        </div>
</body>
</html>