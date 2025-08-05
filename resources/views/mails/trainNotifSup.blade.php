<h4>Hi {{ $emp_sup->emp_firstname }},</h4>

<p>You have a training notification request: </p>

<table>
    <tr>
        <td>Name</td>
        <td>{{ $emp_request->emp_firstname." ".$emp_request->emp_middle_name." ".$emp_request->emp_lastname }}</td>
    </tr>
    <tr>
        <?php $train_name = DB::table('trainning')->where('id', $emp_request->trainning_id)->first();?>
        <td>Training Name</td>
        <td>{{ $train_name->name }}</td>
    </tr>
    <tr>
        <?php $vendor_name = DB::table('trainning_vendor')->where('id', $emp_request->trainning_intitusion)->first();?>
        <td>Vendor Name</td>
        <td>{{ $vendor_name->vendor_name }}</td>
    </tr>
    <tr>
        <td>Date</td>
        <td>{{ $emp_request->trainning_start_date." - ".$emp_request->trainning_end_date }}</td>
    </tr>
    <tr>
        <td>Purpose</td>
        <td>{{ $emp_request->trainning_purpose }}</td>
    </tr>
</table>

<p>Thank you.</p>

<p>This is an automated notification.</p>
