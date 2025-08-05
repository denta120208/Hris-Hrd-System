@extends('_main_layout')

@section('content')
    <script type="text/javascript">
    </script>
    <div class="container">
        <div class="row">
            <div style="margin-bottom: 60px;"></div>
            <div class="alert alert-danger" role="alert">Gaji yang dapat dilihat hanya 1 Tahun kebelakang.</div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {!! Form::open(['method' => 'post', 'route' => 'salary.download']) !!}
                <input type="hidden" name="emp" id="emp" value="{{ $emp->employee_id }}" />
                <div class="form-group">
                    <label for="month">Month and Year Salary</label>
                    <select class="form-control" name="month" id="month">
                        <option value="0">-=Pilih=-</option>
                        <?php for($i=0;$i<=12;$i++){
                            $monthName = date('F-Y', strtotime(date('Y-m-d')."-".$i." Month"));
                            $monthNum = date('n-y', strtotime(date('Y-m-d')."-".$i." Month"));
                            if(!empty($date) && $monthNum == $date){
                                echo "<option value='".$monthNum."' selected='selected'>".$monthName."</option>";
                            }else{
                                echo "<option value='".$monthNum."'>".$monthName."</option>";
                            }
                        }?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <button class="btn btn-primary">Download</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection