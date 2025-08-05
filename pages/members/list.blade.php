@extends('_main_layout')

@section('content')
<div class="col-lg-12">
    <h1>List Members</h1>
    <a class="pull-left btn btn-primary" href='{{ route('members.create') }}'>Add Member</a>
    
    <a class="pull-right btn btn-success" href='{{ route('members.type') }}'>Add Member Type</a>
    <div>&nbsp;</div><div>&nbsp;</div>
    <table class="table table-striped table-responsive">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Hp/Tlp</th>
            <th>Project</th>
            <th colspan="2">Action</th>
            <th>Print</th>
        </tr>
        @if(count($members))
        <?php $no = 1;?>
        @foreach ($members as $member)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $member->first_name." ".$member->last_name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->hp_tlp }}</td>
            <td>{{ $member->card_no }}</td>
            <td><a href="{{ route('members.edit', $member->id) }}"><i class="fa fa-edit" title="Edit Member"></i></a></td>
            <td><a href="{{ route('members.confirm', $member->id) }}"><i class="fa fa-trash" title="Delete Member"></i></a></td>
            <td><a href="javascript:void(0);" onclick="PrintElem('{!! route('members.print',$member->id) !!}')"><i class="fa fa-print" title="Print Member Card"></i></a></td>
        </tr>
        <?php $no++;?>
        @endforeach
        @else
        <tr>
            <td colspan="7"><strong>No Data Found</strong></td>
        </tr>
        @endif
        {!! $members->render() !!}
    </table>
</div>
<script type="text/javascript">
function PrintElem(elem){
//    var link = "{!! route('members.print'," + elem + ") !!}";
    $.ajax({
        type: 'get',
        url: elem,
//        data: {id:elem},
        dataType: "html",
        success: function(result) {
            var mywindow = window.open('', 'my div');
            mywindow.document.write(result);
            mywindow.print();
            mywindow.close();
            return true;
        }
    });
}
</script>
@endsection