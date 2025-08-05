@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $('#search').on('click', function (){
        var form = document.getElementById("frmSearch");
        form.submit();
    });
</script>
<div class="col-lg-12">
    <h1>Redeem Point</h1>
    <div class="col-lg-4">
    {!! Form::open(['route' => 'redeem.create', 'method' => 'post', 'id' => 'frmSearch']) !!}
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Metland Card Number" name="card_no" id="card_no" <?php if($member): echo 'value="'.$card_no.'"'; endif; ?> />
        <span class="input-group-addon btn"><i class="fa fa-search" id="search"></i></span>
    </div>
    </div>
    {!! Form::close() !!}
    @if(!empty($member))
    <div class="col-lg-8">
        <div class="col-md-3">
            <div class="form-group">
                <label for="member_point">Member Point </label>
                <input class="form-control" id="member_point" name="member_point" value="{!! $member[0]->point !!}" readonly="readonly" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="member_point">Member Name </label>
                <input class="form-control" id="member_point" name="cust_name" value="{!! $customer->first_name.' '.$customer->last_name !!}" readonly="readonly" />
            </div>
        </div>
    </div>
    @if($redeems)
    <div class="col-lg-6">
        <h3>History Redeem</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($redeems as $redeem)
                <tr>
                    <td>{!! $redeem->created_at !!}</td>
                    <td>{!! $redeem->product->name !!}</td>
                    <td>{!! $redeem->pos_qty !!}</td>
                    <td>{!! $redeem->user->username !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <script type="text/javascript">
    $(function() {
        $( "#product" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('redeem.product') }}",
                    dataType: "json",
                    data: {
                      q: request.term,
                      _token: "{{ csrf_token() }}"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            var d = item.split(';');
                            return {
                                label: d[1] + ' - ' + d[2],
                                value: d[1],
                                id: d[0],
                                point: d[2]
                            }
                        }));
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                $('#prod_id').val(ui.item.id)
                $('#point').attr('value', ui.item.point)
//                console.log(ui.item.id);
            },
            open: function() {
              $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
              $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
function delRow(){
    var tbody = document.getElementById('redeem_tbl');
    tbody.deleteRow(1);
}
function getTableColumnValues(col){
    var columnValues=[];
    $('#redeem_tbl').each(function() {
        $('tr>td:nth-child('+col+')',$(this)).each(function() {
          columnValues.push($(this).text());
        });
    });
    return columnValues;
}
function creTBL(){
    var point = $("#point").val();
    var qty = $("#qty").val();
    var expense = (point * qty);
    var $tr = $('<tr />');
    $tr.append($("<td />", { text: $("#product").val() })) //0
    $tr.append($("<td />", { text: $("#prod_id").val(), style:'display:none;' })) //1
    $tr.append($("<td />", { text: expense, style:'display:none;' })) //2
    $tr.append($("<td />", { text: $("#point").val() })) //3
    $tr.append($("<td />", { text: $("#qty").val() })) //4
    $tr.append("<td><i class='fa fa-trash btn' title='delete' onclick='delRow()'></i></td>")
    $tr.appendTo('#redeem_tbl');
}
$(function () {
    $("#add").on('click', function () {
        var rcpt = $("#product").val();
        var tbl_rcpt = getTableColumnValues(2);
        if(tbl_rcpt.length == 0){
            creTBL();
        }else{
            for(l=0;l<tbl_rcpt.length;l++){
                if(rcpt == tbl_rcpt[l]){
                    alert('Receipt Number Sudah di Input');
                }else{
                    creTBL();
                }
            }
        }
    });
    $('#btn_redeem').on('click', function() {
        var tbl = $('table tbody#redeem_tbl tr').map(function() {
            return $(this).find('td').map(function() {
              return $(this).html();
            }).get();
        }).get();
        var card_no = $('#card_no').val();
        var ip = $('#ip').val();
        $.ajax({
            type: "POST",
            url: "{{ action('PointRedeemController@store') }}",
            data: {card_no:card_no, data_tbl:tbl, _token:"{{ csrf_token() }}", ip:ip},
            dataType: 'json',
            cache: false,
            success: function (response) {
                if(response['Success']){
                    alert(response['Success']);
//                    location.reload();
                    window.location.href = "{!! route('redeem.reciept', ['card_no' => $card_no]) !!}";
                }else{
                    alert(response['Error']);
                }
            },
            error: function() {
               alert('Error, Please contact Administrator!');
//               location.reload();
            }
        });
    });
});
    </script>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="product">Product </label>
                <input class="form-control" id="product" name="product" />
            </div>
    <input type="hidden" name="prod_id" id="prod_id"/>
            <div class="form-group">
                <label for="point">Point </label>
                <input class="form-control" id="point" name="point" readonly="readonly" />
            </div>
            <div class="form-group">
                {!! Form::label('qty', 'Quantity') !!}
                {!! Form::text('qty', null, ['class' => 'form-control', 'id' => 'qty']) !!}
            </div>
            <button class="btn btn-success pull-right" id="add">Add</button>
        </div>
        <div class="col-md-6">
            <table class="table table-striped" id='redeem_tbl'>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Point Needs</th>
                        <th>Quantity</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="redeem_tbl">
                     
                </tbody>
            </table>
            <button class="btn btn-success pull-right" id="btn_redeem">Redeem</button>
        </div>
    </div>
    <input type="hidden" name="ip" id="ip" value=""/>
    <input type="hidden" name="card_no" value="{!! $card_no !!}"/>
    
    @endif
        
</div>
@endsection