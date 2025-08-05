@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#mtTable').DataTable({});
        $(document).on("click", ".open-apvModal", function () {
            $(".modal-body #mt_id").val($(this).data('id'));
        });
    });
</script>
<div class="container">
    <h2>Mutation</h2>
    <div class="row">
        {{--        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
        {{--            <a href="{{ route('mutation.add') }}" class="btn btn-primary">New Request</a>--}}
        {{--        </div>--}}
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="mtTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Emp Number</th>
                                <th>Emp Name</th>
                                <th>Unit From</th>
                                <th>Unit To</th>
                                <th>Mutation Type</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($requests)
                            @foreach($requests as $row)
                            <tr>
                                <td>{{ $row->emp_sub->employee_id }}</td>
                                <td>{{ $row->emp_sub->emp_firstname." ".$row->emp_sub->emp_middle_name." ".$row->emp_sub->emp_lastname }}</td>
                                <td>{{ $row->project_from->name }}</td>
                                <td>{{ $row->project_to->name }}</td>
                                <td>{{ $row->mutation_type->type }}</td>
                                <td>{{ $row->mutation_status->name }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->approved_by }}</td>
                                <td>{{ $row->approved_at }}</td>
                                @if($row->mt_status >= '1' && $row->mt_status < '3')
                                <td><a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="{{ $row->id }}" id="apv"><i class="fa fa-check-circle" title="Approve"></i></a></td>
                                @elseif($row->mt_status == '3')
                                <td><a href="{{ route('hrd.printMutation', $row->id) }}"><i class="fa fa-print" title="Print"></i></a></td>
                                @else
                                <td><i class="fa fa-check-circle" title="Approve"></i></td>
                                @endif
                            </tr>
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
<div id="apvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="apvModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="apvModal">Mutation Approval</h4>
            </div>
            <form action="{{ route('hrd.setMutation') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="mt_id" value="" />
                    <p>Approving mutation request?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection