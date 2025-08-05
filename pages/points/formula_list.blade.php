@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(function () {
        var id = $('#formula_id').val();
    $('#delete').on('click', function(){
        var url = "{{ URL::to('/') }}/point_formula/" + id;
        $('#delForm').attr('action', url);
    });
});
</script>
<div class="col-lg-12">
    <h1>List Point Formula</h1>
    <a class="pull-left btn btn-primary" href='{{ route('point_formula.create') }}'>Add Point Formula</a>
    <div>&nbsp;</div><div>&nbsp;</div>
    <table class="table table-striped table-responsive">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($formulas))
        <?php $no = 1;?>
        @foreach ($formulas as $formula)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $formula->point_desc }}</td>
            <td>{{ $formula->point_amount }}</td>
            <td>{{ $formula->point_frdate }}</td>
            <td>{{ $formula->point_todate }}</td>
            <td>{{ $formula->point_active ? 'Active' : 'Not Active' }}</td>
            <td><a href="{{ route('point_formula.edit', $formula->id) }}"><i class="fa fa-edit" title="Edit Point Formula"></i></a></td>
            <td><a href="javascript:void(0)" id="delete" data-toggle="modal" data-target="#delModal">
                    <input type="hidden" id="formula_id" value="{{ $formula->id }}" />
                    <i class="fa fa-trash" title="Delete Point Formula"></i>
                </a></td>
        </tr>
        <?php $no++;?>
        @endforeach
        @else
        <tr>
            <td colspan="7"><strong>No Data Found</strong></td>
        </tr>
        @endif
    </table>
    <!-- Modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Point Formula</h4>
                </div>
                <form method="POST" accept-charset="UTF-8" id="delForm">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <p><strong>Do you sure Delete this Point Formula??</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@endsection