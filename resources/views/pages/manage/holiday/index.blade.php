@extends('_main_layout')

@section('content')
<?php

function date_formated($date) {
    $new_date = date('d-m-Y', strtotime(substr($date, 0, 11)));
    return $new_date;
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#holiday').DataTable({
//            scrollX: "100%",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'portrait',
                    pageSize: 'A4'
                },
                {
                    extend: 'print'
                }
            ]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".open-showModal", function () {
            var id = $(this).data('id');
            if (id > 0) {
                $.ajax({
                    url: '{{ route('hrd.getHoliday') }}',
                    type: 'get',
                    data: {id: id},
                    dataType: 'json',
                    success: function (data) {
                        $('#id').val(id);
                        $('#date').val(data['date']);
                        $('#description').val(data['description']);
                        $('#recurring').val(data['recurring']);
                        $('#holiday_type').val(data['holiday_type']);
                    }
                });
            }
            if (id == 0 || id == "" || id == null) {
                $('#id').val("");
                $('#date').val(null);
                $('#description').val(null);
                $('#recurring').val("");
                $('#holiday_type').val("");
            }
        });
        $('#date').datetimepicker({
            format: 'Y-m-d',
        });
        $('#confirm-delete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        $("#recurring option:first-child").attr("disabled", "disabled");
    });
</script>
<div class="container">
    <h2>Holiday</h2>
    <a class="btn btn-primary open-showModal" id="addHoliday" data-toggle="modal" href="#showModal">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Holiday
    </a>
    <div style="margin-bottom: 60px;"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form action="{{ route('hrd.holidayFilter') }}" method="post" class ="form-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="form-group">
                                <label for="year" class="sr-only">Year</label>
                                <select name="year" class="form-control" id="year">
                                    @for ($x = $year - 4; $x <= $year + 2; $x++)
                                    <option value="{{$x}}" @if($x == $year_search)selected @endif>{{$x}}</option>
                                    @endfor
                                </select>
                            </div>
                            <button class="btn btn-success">Filter</button>
                        </form>
                        <div style="margin-bottom: 20px;"></div>
                    </div>
                    <table id="holiday" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Holiday Type</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($holidays)
                            <?php $no = 1; ?>
                            @foreach($holidays as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ date_formated($row->date) }}</td>
                                <td>{{ $row->description }}</td>
                                <td>@if($row->recurring == '1') Recurring @else Not Recurring @endif</td>
                                <td>{{$row->holiday_type}}</td>
                                @if(date('Y', strtotime(substr($row->date, 0, 11))) >= $year )
                                <td>
                                    <a id="show" href="#showModal" data-toggle="modal" class="open-showModal" data-id="{{ $row->id }}"><i class="fa fa-edit" title="Edit"></i></a>
                                </td>
                                <td>
                                    <a id="show" data-href="{{ route('hrd.delHoliday', $row->id) }}" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash" title="Remove"></i></a>
                                </td>
                                @else
                                <td>
                                    -
                                </td>
                                <td>
                                    -
                                </td>
                                @endif
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No data</td>
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
                        <label for="date">Date <span style="color: red;">*</span></label>
                        <input class="form-control" type="text" name="date" id="date" />
                    </div>
                    <div class="form-group eventInsForm">
                        <label for="description">Description <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="recurring">Recurring <span style="color: red;">*</span></label>
                        <select class="form-control" name="recurring" id="recurring">
                            <option value="">--</option>
                            <option value="1">Recurring</option>
                            <option value="0">Not Recurring</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="holiday_type">Holiday Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="holiday_type" id="holiday_type">
                            <option value="">--</option>
                            <option value="1">Cuti Bersama</option>
                            <option value="2">Libur Nasional</option>
                            <option value="3">Cuti Pemerintah</option>
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirmation Delete Holiday
            </div>
            <div class="modal-body">
                <h1>Are you sure want to delete this Holiday?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection