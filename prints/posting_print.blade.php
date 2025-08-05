<div style='width: 25%; margin-left: 35%'>
    <h1 style='text-align: center;'>Posting Point Receipt</h1>
    <hr>
    <p>Date : <?php echo '\t'; ?>{!! date('d/m/Y H:i:s') !!}</p>
    <p>Customer Name : <?php echo '\t'; ?>{!! $member->first_name.' '.$member->last_name !!}</p>
    <p>Customer ID : <?php echo '\t'; ?>{!! $member->card_no !!}</p>
    <hr>
    <p>Posting Amount : <?php echo '\t'; ?>{!! $amount !!}</p>
    <p>Posting Point : <?php echo '\t'; ?>{!! $point - $last_point !!}</p>
    <p>Pervious Point : <?php echo '\t'; ?>{!! $last_point !!}</p>
    <p>Current Point : <?php echo '\t'; ?>{!! $point !!}</p>
</div>