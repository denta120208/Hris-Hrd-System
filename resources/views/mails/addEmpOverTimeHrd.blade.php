<h4>Hi HRD {{$emp->location_name}},</h4>

<p>You have an over time notification request:</p>

<table style="width: 100%">
    <tr>
        <td style="width: 25%; vertical-align: text-top">
            Employee Id
        </td>
        <td style="width: 75%">
            <p>:  {{$emp->employee_id}} </p>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Name
        </td>
        <td>
            : {{$emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Location
        </td>
        <td>
            : {{$emp->location_name}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Ovetime Request Id
        </td>
        <td>
            : {{$otReq->id}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Date and Time
        </td>
        <td>
            : {{$otReq->ot_date_format}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Date and Time
        </td>
        <td>
            : {{$otReq->ot_start_time_format." - ".$otReq->ot_end_time_format}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Reason
        </td>
        <td>
            : {{$otReq->ot_reason}}
        </td>
    </tr>
</table>

<p>Thank you.</p>

<p>This is an automated notification.</p>
