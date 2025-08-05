@extends('_main_layout')

@section('content')
<div class="col-lg-6 col-lg-offset-3">
    <h1 style="text-align: center;">Redeem Point Receipt</h1>
    <hr>
    <p>Date : {!! date('d/m/Y H:i:s') !!}</p>
    <p>Customer Name : {!! $member->first_name.' '.$member->last_name !!}</p>
    <p>Customer ID : {!! $member->card_no !!}</p>
    <p>Pervious Point : {!! $last_point !!}</p>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Product Point</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $amount = 0;
        for($i=0; $i < count($product); $i++){
            echo "<tr>";
            echo "<td>".$product[$i]."</td>";
            echo "<td>".$qty[$i]."</td>";
            echo "<td>".$point_item[$i]."</td>";
            echo "</tr>";
            $amount += ($qty[$i] * $point_item[$i]);
        }
        ?>
        </tbody>
    </table>
    <p>Point Spend : {!! $amount !!}</p>
    <p>Current Point : {!! $point !!}</p>
    
    <div>
        <a class="btn btn-danger" href="{{ route('redeem.index') }}">Back</a>
        <button onclick="PrintElem({{$member->card_no}})" class="btn">Print</button>
    </div>
</div>
<script type="text/javascript">
function PrintElem(elem){
    $.ajax({
        type: 'get',
        url: "{{action('PointRedeemController@print_reciept')}}",
        data: {card_no:elem},
        dataType: "html",
        success: function(result) {
            var mywindow = window.open('', 'my div');
            mywindow.document.write(result);
            mywindow.print();
            mywindow.close();
            return true;
        }
    });
}
</script>
@endsection