@extends('_main_layout')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#pTable').DataTable({});
        $(document).on("click", ".open-apvModal", function () {
            $(".modal-body #pro_id").val($(this).data('id'));
        });
    });
</script>
<div class="container">
    <h2>Promotion Appr HR Process</h2>
    <div class="row">
        <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('hrd.promotion.add') }}" class="btn btn-primary">New Request</a>
        </div> -->
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="data-table-list">
                <div class="table-responsive">
                    <?php $no = 1; ?>
                    <table id="pTable" class="table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Emp Number</th>
                                <th>Emp Name</th>
                                <th>Status</th>
                                <th>Requested At</th>
                                <th>From Level</th>
                                <th>To Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($requests)
                            @foreach($requests as $row)
                            <tr>
                                <td>{{ $row->emp_sub->employee_id }}</td>
                                <td>{{ $row->emp_sub->emp_firstname." ".$row->emp_sub->emp_middle_name." ".$row->emp_sub->emp_lastname }}</td>
                                <td>{{ $row->promotion_status->name }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->level_from->job_title }}</td>
                                <td>{{ $row->level_to->job_title }}</td>
                                <td><a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="{{ $row->id }}" id="apv"><i class="fa fa-check-circle" title="Approve"></i></a></td>
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
                <h4 class="modal-title" id="apvModal">Promotion Approval</h4>
            </div>
            <form action="{{ route('hrd.setPromotionHRProcess') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="pro_id" value="" />
                    <div class="form-group">
                        <div class="nk-int-st">
                            <label for="mt_doc_no">Document Number</label>
                            <input type="text" class="form-control" name="mt_doc_no" id="mt_doc_no" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection