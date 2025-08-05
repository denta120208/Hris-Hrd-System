@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $('#usrTable').DataTable({ });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>List Users</h1>
            <a class="btn btn-primary" href="{{ route('menus.create') }}">Add Menu</a>
            <div class="col-md-12">&nbsp;</div>
            <table id="usrTable" class="table table-responsive table-striped">
                <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>URL</th>
            <th>Is Parent</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
                </thead>
                <tbody>
        @if(count($menus))
            <?php $no = 1?>
        @foreach($menus as $menu)
            <tr style="font-weight: bold;">
                <th>{{ $no }}</th>
                <th colspan="6">{{ $menu->title }}</th>
            </tr>
            <?php
                $child = \App\Models\Menus\Menu::where('parent_id', $menu->id)->get();
                $noCH = 1;
            ?>
            @foreach($child as $row)
            <tr>
                <td></td>
                <td>{{ $noCH.' - '.$row->title }}</td>
                <td>{{ $row->uri }}</td>
                <td>@if($row->show_menu == 1) Active @else Not Active @endif</td>
                <td>@if($row->manage_status == 1) HRD Menu @else Non HRD Menu @endif</td>
                @if($row->show_menu == 1)
                <td><a href="{{ route('menus.edit', $row->id) }}"><i class="fa fa-edit" title="Edit"></i></a></td>
                <td><a href="{{ route('menus.destroy', $row->id) }}"><i class="fa fa-trash" title="Delete"></i></a></td>
                @else
                <td><a href="{{ route('menus.edit', $row->id) }}"><i class="fa fa-check"></i></a></td>
                <td><i class="fa fa-trash" title="Delete"></i></td>
                @endif
            </tr>
            <?php $noCH++;?>
            @endforeach
        <?php $no++;?>
        @endforeach
        @endif
                </tbody>
    </table>
        </div>
    </div>
</div>
@endsection