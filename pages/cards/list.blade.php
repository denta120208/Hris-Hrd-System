@extends('_main_layout')

@section('content')
<script type="text/javascript">
$().click(function(){
    
});
</script>
<div class="col-lg-12">
    <h1>Card Type List</h1>
    <a class="btn btn-primary" href="{{ route('cards.create') }}">Add Card Type</a>
    <div class="col-md-12">&nbsp;</div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        @if(count($cards))
        <?php $no = 1; ?>
        @foreach($cards as $card)
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $card->name }}</td>
            @if($card->status == FALSE)
            <td>Deleted</td>
            <td  colspan="2"><a href="{{ route('cards.edit', $card->id) }}"><i class="fa fa-edit" title="Edit Card"></i></a></td>
            @else
            <td>Active</td>
            <td><a href="{{ route('cards.edit', $card->id) }}"><i class="fa fa-edit" title="Edit Card"></i></a></td>
            <td><a href="{{ route('cards.destroy', $card->id) }}"><i class="fa fa-trash" title="Delete Card"></i></a></td>
            @endif
        </tr>
        <?php $no++;?>
        @endforeach
        @endif
    </table>
</div>
@endsection