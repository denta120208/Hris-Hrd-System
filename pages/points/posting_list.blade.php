@extends('_main_layout')

@section('content')
<script type="text/javascript">  
function delRow(r, id){
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("post_tbl").deleteRow(i);
    
    document.getElementById(id).remove();
}
function getTableColumnValues(col){
    var columnValues=[];
    $('#post').each(function() {
        $('tr>td:nth-child('+col+')',$(this)).each(function() {
          columnValues.push($(this).text());
        });
    });
    return columnValues;
}
function creTBL(){
    var rcpt = parseInt($("#rcpt").val());
    var tenant = $("#tenant").val();
    var tr = $('<tr />');
    tr.append($("<td />", { text: $('#tenant option:selected').text() }))
    tr.append($("<td />", { text: $("#rcpt").val() }))
    tr.append($("<td />", { text: $("#rcpt_date").val() }))
    tr.append($("<td />", { text: $("#rcpt_time").val() }))
    tr.append($("<td />", { text: $("#amount").val() }))
    tr.append("<td><i class='fa fa-trash' title='delete' onclick='delRow(this, "+rcpt+")'></i></td>")
    tr.appendTo('#post');
    
    
    var tx = $('<div />', { id: rcpt });
    tx.append($("<input />", { type: 'hidden', name: 'tenant[]', id: 'tenant', value: $("#tenant").val(), class: 'form-control' }))
    tx.append($("<input />", { type: 'hidden', name: 'bank[]', id: 'bank', value: $("#bank").val(), class: 'form-control' }))
    tx.append($("<input />", { type: 'hidden', name: 'rpct[]', id: 'rpct', value: $("#rcpt").val(), class: 'form-control' }))
    tx.append($("<input />", { type: 'hidden', name: 'rcpt_date[]', id: 'rcpt_date', value: $("#rcpt_date").val(), class: 'form-control' }))
    tx.append($("<input />", { type: 'hidden', name: 'rcpt_time[]', id: 'rcpt_time', value: $("#rcpt_time").val(), class: 'form-control' }))
    tx.append($("<input />", { type: 'hidden', name: 'amount[]', id: 'amount', value: $("#amount").val(), class: 'form-control' }))
    tx.appendTo('#test-form');  
}
$(function () {
    $('#btn_post').hide();
    $('#search').on('click', function(){
        $("#srcForm").submit();
    });
    $("#add").on('click', function () {
        var l=0;
        var rcpt = $("#rcpt").val();
        var tbl_rcpt = getTableColumnValues(2);
        if(tbl_rcpt.length == 0){
            creTBL();
            $('#btn_post').show();
        }else{
            while(l<tbl_rcpt.length){
                if(rcpt == tbl_rcpt[l]){
                    alert('Receipt Number Sudah di Input');
                    break;
                }else{
                    creTBL();
                    break;
                }
                l++;
            }
        }
    });
    $('#rcpt_date').datetimepicker({
        useCurrent: true,
        format: 'YYYY-MM-DD',
    });
    $('#rcpt_time').datetimepicker({
        useCurrent: true,
        format: 'HH:mm',
    });
});
</script>
<div class="col-lg-12">
    <h1>Posting Point</h1>
    <div class="row">
        <div class="col-lg-6">
            {!! Form::open([
                'method' => 'post',
                'route' => 'point_post.index',
                'id' => 'srcForm',
                'class' => 'form-inline'
            ]) !!}
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Metland Card Number" name="card_no" value="{!! $member->card_no !!}">
                <span class="input-group-addon btn"><i class="fa fa-search" id="search"></i></span>
            </div>
            <div class="input-group">
                <label for="member_name" class="sr-only">Name</label>
                <input type="text" class="form-control" disabled="disabled" name="member_name" value="{!! $member->first_name.' '.$member->last_name !!}" id="member_name" />
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col-lg-5">
            <div class="col-md-12" id="addForm">
                <?php
                    $tenant = App\Tenant::where('project_code', Session::get('project'))->lists('name', 'id')->prepend('All', '0');
                ?>
                <div class="form-group">
                    {!! Form::label('tenant', 'Tenant') !!}
                    {!! Form::select('tenant', $tenant, null, ['class' => 'form-control', 'id' => 'tenant']) !!}
                </div>
                <?php
                    $bank = App\Models\Bank::where('project_code', Session::get('project'))->lists('name', 'id')->prepend('Cash', '0');
                ?>
                <div class="form-group">
                    {!! Form::label('bank', 'Bank') !!}
                    {!! Form::select('bank', $bank, null, ['class' => 'form-control', 'id' => 'bank']) !!}
                </div>
                <div class="form-group">
                    <label for="rcpt">Receipt</label>
                    <input type="text" name="rcpt" id="rcpt" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="rcpt_date">Receipt Datetime</label>
                    <div class="input-group">
                        <input type="text" name="rcpt_date" id="rcpt_date" class="form-control" />
                        <span class="input-group-addon"><i>-</i></span>
                        <input type="text" name="rcpt_time" id="rcpt_time" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i>Rp</i></span>
                        <input type="text" name="amount" id="amount" class="form-control" />
                    </div>
                </div>
                <button class="btn btn-success pull-right" id="add">Add</button>
            </div>
            <div class="col-md-12">
                <table class="table table-striped table-responsive" id="post_tbl">
                    <thead>
                        <tr>
                            <th>Tenant</th>
                            <th>Receipt</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="post">
                    </tbody>
                </table>
            </div>
            {!! Form::open([
                'method' => 'post',
                'route' => 'point_post.create',
                'id' => 'testFrom'
            ]) !!}
            <input type="hidden" name="card_no" value="{!! $member->card_no !!}" />
            <input type="hidden" name="ip" id="ip" value=""/>
            <div id='test-form'>
            </div>
            <input type="submit" class="btn btn-success pull-right" id="btn_post" value="Post" />
            {!! Form::close() !!}
        </div>
        <div class="col-lg-7">
            <h3>Point History</h3>
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Posting Date</th>
                        <th>Posting Amount</th>
                        <th>Posting Point</th>
                    </tr>
                </thead>
                <tbody><?php $no = 1;?>
                    @foreach($posting as $post)
                    <tr>
                        <td>{!! $no !!}</td>
                        <td>{!! $post->post_date !!}</td>
                        <td>Rp. {!! number_format($post->post_amount,2) !!}</td>
                        <td>{!! $post->point_redeem !!}</td>
                    </tr>
                    <?php $no++;?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection