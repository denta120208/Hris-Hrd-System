<div>
<div class="table-responsive">
    <h4>Reward</h4>
    <table id="data-table-basic" class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Reward Type</th>
            <th>Year</th>
        </tr>
        </thead>
        <tbody>
            @if(!empty($eRewards))
                <?php $no = 1;?>
                @foreach($eRewards as $row)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $row->reward_name->name }}</td>
                    <td>{{ $row->year_reward }}</td>
                    <?php $no++;?>
                </tr>
                @endforeach
            @else
                <tr><td colspan="3">No Data</td></tr>
            @endif
        </tbody>
    </table>
</div>
</div>

<div>
    <div class="table-responsive">
        <h4>Promotions</h4>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Employee Name</th>
                <th>NIK</th>
                <th>Promotion Date</th>
                <th>From</th>
                <th>To</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($ePromots))
                <?php $no = 1;?>
                @foreach($ePromots as $row)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $row->name->emp_firstname.' '.$row->name->emp_middle_name.' '.$row->name->emp_lastname }}</td>
                    <td>{{ $row->name->employee_id }}</td>
                    <td>{{ $row->promotion_date }}</td>
                    <td>{{ $row->promotion_from }}</td>
                    <td>{{ $row->promotion_to }}</td>
                    <?php $no++;?>
                </tr>
                @endforeach
            @else
            <tr><td colspan="6">No Data</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div>
    <div class="table-responsive">
        <h4>Punishment</h4>
        <table id="data-table-basic" class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Punishment Type</th>
                <th>Year</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($pReqs))
                <?php $no = 1;?>
                @foreach($pReqs as $pReq)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $pReq->punishment_type->name }}</td>
                        <td>{{ date('Y', strtotime($pReq->created_at)) }}</td>
                        <?php $no++;?>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="3">No Data</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</div>