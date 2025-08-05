@extends('_main_layout')

@section('content')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#attendance').addClass("active");
            $('#Charts').addClass("in active");
            $(document).on("click", ".open-appModal", function () {
                var id = $(this).data('id');
                $(".modal-body #leave_id").val( id);
                console.log(id);
                if(id > 0){
                    $.ajax({
                        url: '{{ route('getAttApv') }}',
                        type: 'get',
                        data: {id:id},
                        dataType: 'json',
                        success:function(data){
                            $('#start_date').val(data['start_date']);
                            $('#end_date').val(data['end_date']);
                            $('#reason').val(data['reason']);
                        }
                    });
                }
            });
            $('#attend').dataTable( {
                "ordering": false
            } );
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="data-table-list">
                    <div class="table-responsive">
                        <h2>Attendance Request</h2>
                        <table id="attend" class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($attends)
                                <?php $no = 1; ?>
                                @foreach($attends as $row)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $row->emp_firstname." ".$row->emp_middle_name." ".$row->emp_lastname }}</td>
                                        <td>{{ date('d-m-Y', strtotime($row->start_date)) }}</td>
                                        <td>{{ $row->keterangan }}</td>
                                        <td>{{ $row->reason }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>@if($row->request_status < 2)
                                                <a id="appAtt" href="#appModal" data-toggle="modal" class="open-appModal" data-id="{{ $row->id }}"><i class="fa fa-edit"></i></a>
                                            @else
                                                <i class="fa fa-edit"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                @endforeach
                            @else
                                <tr><td>No Entitlement</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="appModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="appModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                    <h4 class="modal-title" id="appModal">Confirmation</h4>
                </div>
                <form action="{{ route('setAttAppv') }}" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="leave_id" id="leave_id" />
                        <div class="form-group">
                            <label for="approve">Approval</label>
                            <select class="form-control" name="approval">
                                <option value="1">-=Pilih=-</option>
                                <option value="2">Approve</option>
                                <option value="0">Reject</option>
                            </select>
                        </div>
<!--                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input class="form-control" type="text" name="start_date" id="start_date" readonly="readonly" />
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input class="form-control" type="text" name="end_date" id="end_date" readonly="readonly" />
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" rows="5" name="reason" id="reason" disabled></textarea>
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection