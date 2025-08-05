<h4>Hi {{$empSup->emp_firstname}},</h4>

<p>You have an attendance notification request:</p>

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
            Attendance Request Id
        </td>
        <td>
            : {{$attReq->id}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Date and Time
        </td>
        <td>
            : {{$formatDate}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Information
        </td>
        <td>
            : {{$attReq->keterangan}}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: text-top">
            Reason
        </td>
        <td>
            : {{$attReq->reason}}
        </td>
    </tr>
</table>

<p>Thank you.</p>

<p>This is an automated notification.</p>
