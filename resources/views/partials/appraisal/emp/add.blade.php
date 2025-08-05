<style type="text/css">
    .popover{
        max-width:600px;
    }
</style>
<script type="text/javascript">
    $(function(){
        $("[data-toggle=popover]").popover({
            container: 'body'
        });
    });
</script>
<div id="true-form">
    @foreach($appraisals as $row)
    <?php $emp = \App\Models\Master\Employee::where('employee_id', Session::get('username'))->first(); ?>
    <div class="form-group">
        <label>{{ $row->factor }}</label>
        <div class="col-sm-2">
            <input type="hidden" name="appraisal_id[]" value="{{ $row->id }}" />
            @if($emp->job_title_code < '16')
            <input class="form-control" type="text" name="factor[]" id="factor" value="{{ $row->emp_value }}" style="text-align: center; width: 60px;" autocomplete="off" />
            @else
            <input class="form-control" type="text" name="factor[]" id="factor" value="{{ $row->sup_value }}" style="text-align: center; width: 60px;" autocomplete="off" />
            @endif
        </div>
        <a tabindex="0"
           role="button"
           data-html="true"
           data-toggle="popover"
           data-trigger="focus"
           title=""
           data-content="<div><p>KURANG : {{ $row->tips_kurang }}</p>
           <p>CUKUP : {{ $row->tips_cukup }}</p><p>CUKUP BAIK : {{ $row->tips_cb }}</p>
           <p>BAIK : {{ $row->tips_baik }}</p><p>SANGAT BAIK : {{ $row->tips_sb }}</p></div>"><i class="fa fa-info-circle"></i></a>
    </div>
    @endforeach
</div>