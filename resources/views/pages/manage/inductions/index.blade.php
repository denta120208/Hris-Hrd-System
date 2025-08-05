@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#iTable').DataTable({ });
    $(document).on("click", ".open-delModal", function () {
        $(".modal-body #id").val( $(this).data('id') );
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{ route('hrd.induction.add') }}" class="btn btn-primary">New Induction</a>
        </div>
        <div style="margin-bottom: 60px;"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $no = 1;?>
            <table id="iTable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Link</th>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($inds)
                    <?php $no = 1;?>
                @foreach($inds as $row)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->url_gform }}</td>
                    <td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                    <td>{{ $row->created_by }}</td>
                    @if($row->status == '1')
                    <td><a href="#delModal" data-toggle="modal" class="open-delModal" data-id="{{ $row->id }}" id="apv"><i class="fa fa-trash" title="Cancel"></i></a></td>
                    @else
                    <td><i class="fa fa-trash" title="Cancel"></i></td>
                    @endif
                </tr>
                <?php $no++;?>
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
<div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;  </button>
                <h4 class="modal-title" id="delModal">demotion Approval</h4>
            </div>
            <form action="{{ route('delInduction') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" id="id" value="" />
                    <p>Sure want to Cancel this Demotion?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection