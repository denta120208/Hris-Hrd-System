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
				<div class ="judul">
						<p><strong>S U R A T  K E P U T U S A N</strong></p>
						<p><strong>No. {{ $mutasi->mt_doc_no }}</strong></p>
						<p><strong>Tentang</strong></p>
						<p><strong>MUTASI</strong></p>
				</div>
                <div class="headeratas">
                    <p>Yang bertanda tangan dibawah ini :</p>
					<p>Menimbang:
					<ol>
						<li>Adanya kebutuhan akan jabatan <strong>{{ $empSub->job_title->job_title }}</strong> di <strong>{{ $reqMut->project_to->name }}</strong></li>
						<li>Perlunya peningkatan karir yang bersangkutan.</li>
					</ol>
					</p><br>
					<p>Memperhatikan:
					<ol>
						<li>Persetujuan Direksi.</li>
					</ol>
					</p><br>
					<p>Mengingat:
					<ol>
						<li>Peraturan Perusahaan PT Metropolitan Land Tbk.</strong></li>
						<li>Persetujuan Direksi.</li>
					</ol>
					</p>

					   <p><strong>M E M U T U S K A N</strong></p>
					   <p>Menetapkan		:</p><br>
					<p>Pertama		: Terhitung tanggal {{ date('d-m-Y', strtotime($reqMut->hrd_approved_at)) }} memutasikan Sdr/i. <strong>{{ $empSub->emp_firstname." ".$empSub->emp_middle_name." ".$empSub->emp_lastname }}</strong>
						 dari jabatan "Jabatan Asal" Dept. <strong>{{ $reqMut->dept_from->name }}</strong> di <strong>{{$reqMut->project_from->name}}, {{$reqMut->project_from->companny}}</strong>
						menjadi "Jabatan Asal" Dept. <strong>{{ $reqMut->dept_to->name }}</strong> di <strong>{{ $reqMut->project_to->name }}, {{ $reqMut->project_to->companny }}</strong>
										  </p><br>
					   <p>Kedua			: Pelaksanaan tugas berpedoman kepada Job Description dan peraturan yang berlaku di PT Metropolitan Land Tbk dan bertanggung jawab kepada "Head_new_Div" {{ $reqMut->project_to->companny }}.</p><br>
					   <p>Ketiga		: Bahwa jabatan yang dibebankan hendaknya dilaksanakan dengan penuh rasa tanggung jawab.</p><br>
					   <p>Kedua			: Apabila di kemudian hari ternyata terdapat kekurangan/kekeliruan dalam Surat Keputusan ini, maka akan diadakan perubahan atau perbaikan seperlunya.</p><br>
					   
					<br><br>
					<p>Ditetapkan di :	Bekasi</p>
					<p>Kepada ybs :				Pada tanggal 	:	{!! date('d-m-Y', strtotime($reqMut->hrd_approved_at)) !!}</p>
					<p>{{-- $dataProject->Nama_PT --}}</p><br>
					<p>{{-- $dataProject->Nama_HRD/GM/Dirut --}}</p><br>
					<p>{{-- $dataProject->Jabatan_HRD/GM/Dirut --}}</p>
					<br>
					<p>Tembusan :
							1.	Direksi
							2.	Arsip
							<br></p>
                </div>
        </div>
        <br><br>
        </div>
</body>
</html>