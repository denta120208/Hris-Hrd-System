<h4>Hi {{ $leaves->emp_firstname }},</h4>

<p>You have a leave notification request: </p>

<table>
    <tr>
        <td>Name</td>
        <td>{{ $emp_leave->emp_firstname." ".$emp_leave->emp_middle_name." ".$emp_leave->emp_lastname }}</td>
    </tr>
    <tr>
        <td>Total Leave</td>
        <td>{{ $emp_leave->length_days }}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $emp_leave->from_date.' - '.$emp_leave->end_date }}</td>
    </tr>
    <tr>
        <td>Reason</td>
        <td>{{ $emp_leave->comments }}</td>
    </tr>
    <tr>
        <td>Leave Type</td>
        <td>{{ $emp_leave->name }}</td>
    </tr>
    <tr>
        <td>Person In Charge</td>
        <td>{{ $empIncharge->emp_firstname." ".$empIncharge->emp_middle_name." ".$empIncharge->emp_lastname }}</td>
    </tr>
</table>

<p>Thank you.</p>

<p>This is an automated notification.</p>
