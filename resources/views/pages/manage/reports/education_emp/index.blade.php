@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#eduTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ],
            "pageLength": 50,
        });
        $('#eduTable').on('click', 'tbody tr', function () {
            // alert( 'You clicked on 1' );
            var data = table.row($(this)).data();
            var id = $(data[0]).attr("data-id"); // get attribute data-id from TD
            console.log(id);
            // console.log(this.dataset.id, $(this).data().id, $(this).data('id'));
            window.location = "/hrd/rEducation/" + id + "/show";
        });
    });
</script>
<div class="container">
    <h2>Education Report</h2>
    <div style="margin-bottom: 60px;"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form action="{{ route('hrd.srEducation') }}" method="post" class ="form-inline">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
                <label for="emp_name" class="sr-only">Name</label>
                <input class="form-control" type="text" name="emp_name" id="emp_name" placeholder="Name" />
            </div>
            <div class="form-group">
                <label for="employee_id" class="sr-only">NIK</label>
                <input class="form-control" type="text" name="employee_id" id="employee_id" placeholder="NIK" />
            </div>
            <div class="form-group">
                <?php
                $emp_edu = \App\Models\Master\Education::lists('name', 'id')->prepend('Education', '0');
                ?>
                {!! Form::label('education_id', 'Education', ['class'=>'sr-only']) !!}
                {!! Form::select('education_id', $emp_edu, '', ['class' => 'form-control', 'style' => 'width: 185px;', 'id' => 'education_id']) !!}
            </div>
            <div class="form-group">
                <label for="institute" class="sr-only">Institute</label>
                <input class="form-control" type="text" name="institute" id="institute" placeholder="Univ. Trisakti" />
            </div>
            <div class="form-group">
                <label for="major" class="sr-only">Major</label>
                <input class="form-control" type="text" name="major" id="major" placeholder="Ekonomi" />
            </div>
            <button class="btn btn-success">Search</button>
        </form>
    </div>
    <div class="row">
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1;
                    $kt = $kr = $tkt = $tkr = 0; ?>
                    <table id="eduTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Proyek</th>
                                <th>SD</th>
                                <th>SMP - SLTP</th>
                                <th>SMA - SMU - SMK - STM - SLTA - SMEA</th>
                                <th>Diploma 1 (D1)</th>
                                <th>Diploma 3 (D3)</th>
                                <th>Diploma 4 (D4)</th>
                                <th>Strata 1 (S1)</th>
                                <th>Strata 2 (S2)</th>
                                <th>Strata 3 (S3)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td><span data-id='{{ $data->project_id }}'>{{ $no }}</span></td>
                                <td>{{ $data->project }}</td>
                                <td>{{ $data->sd }}</td>
                                <td>{{ $data->smp }}</td>
                                <td>{{ $data->sma }}</td>
                                <td>{{ $data->d1 }}</td>
                                <td>{{ $data->d3 }}</td>
                                <td>{{ $data->d4 }}</td>
                                <td>{{ $data->s1 }}</td>
                                <td>{{ $data->s2 }}</td>
                                <td>{{ $data->s3 }}</td>
                            </tr>
<?php $no++; ?>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection