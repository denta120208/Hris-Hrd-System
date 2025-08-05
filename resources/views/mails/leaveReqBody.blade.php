<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Leave Request</title>
</head>
<body>
<h4>Hi {{ $emp->emp_firstname }},</h4>

<p>Your request leave on {{ $emp_leave->from_date.' - '.$emp_leave->end_date }} has been placed and notified to your Suppervisor</p>

<p>You were sent this mail, as you have subscribed to MetHRIS leave applications.</p>

<p>Thank you.</p>

<p>This is an automated notification. Do not reply this email</p>
</body>
</html>