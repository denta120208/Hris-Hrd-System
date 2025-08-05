@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#otTable').DataTable({
        });
        $('#date_filter').datetimepicker({
            format: 'Y-m-d',
        });
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
        });
        $('#confirm-approve').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
</script>
<div class="container">
    <h2>Over Time Request list</h2>
    <div class="row">
        <div style="margin-bottom: 20px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="otTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>NIK</th>
                                <th>Day</th>
                                <th>Ot Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Ot Hours</th>
                                <th>Ot Total Hours</th>
                                <th>Meal Number</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($otR)
                            <?php $no = 1; ?>
                            @foreach($otR as $row)
                            <?php
                                $ot_start_time = date('h:i:s', strtotime($row->ot_start_time));
                                $ot_end_time = date('h:i:s', strtotime($row->ot_end_time));
                                $day = date('l', strtotime($row->ot_date));
                            ?>
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->emp_lastname }}</td>
                                <td>{{ $row->employee_id }}</td>
                                <td>{{ $day }}</td>
                                <td>{{ $row->ot_date1 }}</td>
                                <td>{{ $ot_start_time }}</td>
                                <td>{{ $ot_end_time }}</td>
                                <td>{{ $row->ot_hours }}</td>
                                <td>{{ $row->ot_total_hours }}</td>
                                <td>{{ $row->ot_meal_num }}</td>
                                <td>{{ $row->ot_reason }}</td>
                                <td>{{ $row->status_name }}</td>
                                @if($row->status_id == '2')
                                <td>
                                    
                                </td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="showModal">Employee Leave</h4>
            </div>
            <form method="post" action="{{ route('hrd.setHoliday') }}">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input class="form-control" type="text" name="date" id="date" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="recurring">Recurring</label>
                        <select class="form-control" name="recurring" id="recurring">
                            <option value="">--</option>
                            <option value="1">Recurring</option>
                            <option value="0">Not Recurring</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation Approve Request
            </div>
            <div class="modal-body">
                <h1>Are you sure want to <strong>approve</strong> this Attendance Request??</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success btn-ok">Approve</a>
            </div>
        </div>
    </div>
</div>
@endsection