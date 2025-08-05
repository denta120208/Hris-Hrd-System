<h4>Hi IT PUSAT,</h4>

<p>An Intern employee has been added</p>

<p>Here are some details about the newly added Intern employee:</p>

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
            Machine ID
        </td>
        <td>
            : {{$empAdms->badgenumber}}
        </td>
    </tr>
</table>

<p>Thank you.</p>

<p>This is an automated notification.</p>
