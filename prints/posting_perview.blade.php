@extends('_main_layout')

@section('content')
<div style="width: 25%; margin-left: 35%">
    <h1 style="text-align: center;">Posting Point Receipt</h1>
    <hr>
    <p>Date : <?php echo "\t"; ?>{!! date('d/m/Y H:i:s') !!}</p>
    <p>Customer Name : <?php echo "\t"; ?>{!! $member->first_name.' '.$member->last_name !!}</p>
    <p>Customer ID : <?php echo "\t"; ?>{!! $member->card_no !!}</p>
    <hr>
    <p>Posting Amount : <?php echo "\t"; ?>{!! $amount !!}</p>
    <p>Posting Point : <?php echo "\t"; ?>{!! $point - $last_point !!}</p>
    <p>Pervious Point : <?php echo "\t"; ?>{!! $last_point !!}</p>
    <p>Current Point : <?php echo "\t"; ?>{!! $point !!}</p>
    
    <div>
        <a class="btn btn-danger" href="{{ route('point_post.index', $member->card_no) }}">Back</a>
        <button onclick="PrintElem({{$member->card_no}})" class="btn">Print</button>
    </div>
</div>
<script type="text/javascript">
function PrintElem(elem){
    $.ajax({
        type: 'get',
        url: "{{action('PointPostController@print_reciept')}}",
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