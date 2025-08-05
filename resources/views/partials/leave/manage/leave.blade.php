<script type="text/javascript">
$(document).ready(function() {
    $('#leaveTable').DataTable({});
});
</script>
<table id="leaveTable" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>NIK</th>
            <th>Full Name</th>
            <th>Leave Type</th>
            <th>Balance</th>
            <th>Valid From</th>
            <th>Valid To</th>
        </tr>
    </thead>
    <tbody>
    @if($leave)
        @foreach($leave as $row)
    <tr>
        <td>{{ $row->employee_id }}</td>
        <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->balance }}</td>
        <td>{{ $row->from_date }}</td>
        <td>{{ $row->to_date }}</td>
    </tr>
        @endforeach
    @else
    @endif
    </tbody>
</table>