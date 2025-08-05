@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on("click", ".open-apvModal", function () {
            $(".modal-body #pd_id").val($(this).data('id'));
        });
        $("#data-table-basic").dataTable();
    });
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <!--<br /><br />-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <h2>Approve Perjalanan Dinas</h2>
                    <table id="data-table-basic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Requested Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @if($pds)
                            @foreach($pds as $pd)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $pd->emp_firstname.' '.$pd->emp_middle_name.' '.$pd->emp_lastname }}</td>
                                <td>{{ $pd->pd_start_date }}</td>
                                <td>{{ $pd->pd_end_date }}</td>
                                <td>{{ $pd->created_at }}</td>
                                <?php $status = \App\Models\PerjanalanDinas\PDStatus::where('id', $pd->pd_status)->first(); ?>
                                <td>{{ $status->name }}</td>
                                @if($pd->pd_status == '1')
                                <td><a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="{{ $pd->id }}" id="apv"><i class="fa fa-check-circle" title="Approve"></i></a></td>
                                @else
                                <td><i class="fa fa-check-circle"></i></td>
                                @endif
                            </tr>
                            <?php $no++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7">No Requested Leave</td>
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
                <h4 class="modal-title" id="apvModal">Perjalanan Dinas Approval</h4>
            </div>
            <form action="{{ route('setPerjalanDinas') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="pd_id" value="" />
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="ot_status">Status Perjalanan Dinas</label>
                            <select class="form-control" name="pd_status" id="pd_status">
                                <option value="">-=Pilih=-</option>
                                <option value="2">Approve</option>
                                <option value="3">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="pd_reason">Comments</label>
                            <textarea class="form-control" rows="5" name="pd_reason"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection