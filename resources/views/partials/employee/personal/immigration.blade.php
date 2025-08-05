<div class="table-responsive">
    <table id="data-table-basic" class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Document</th>
            <th>Number</th>
            <th>Issued By</th>
            <th>Issued Date</th>
            <th>Expiry Date</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @if(!empty($eds))
                <?php $no = 1;?>
                @foreach($eds as $row)
                    <td>{{ $no }}</td>
                    <td>{{ $row->ed_name }}</td>
                    <td>{{ $row->ed_relationship }}</td>
                    <td>{{ date($row->ed_date_of_birth, "YYYY-mm-dd") }}</td>
                    <?php $no++;?>
                @endforeach
            @else
                <td colspan="6">No Data</td>
            @endif
        </tr>
        </tbody>
    </table>
</div>