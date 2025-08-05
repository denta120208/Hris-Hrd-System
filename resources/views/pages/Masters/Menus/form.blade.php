 @extends('_main_layout')

@section('content')
@if($menu->exists)
<script type="text/javascript">
$( document ).ready(function() {
    var parent = document.getElementById('parent').value;
    if(parent == 1){
        $('#is_parent').prop( "checked", true );
    }

    var manage = document.getElementById('manage').value;
    if(manage == 1){
        $('#manage_status').prop( "checked", true );
    }

    var show = document.getElementById('show').value;
    if(show == 1){
        $('#show_menu').prop( "checked", true );
    }
});
</script>
@endif
<div class="container">
    <div class="row">
        <h1>{!! $menu->exists ? 'Edit Menu' : 'Create Menu' !!}</h1>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    {!! Form::open([
        'method' => $menu->exists ? 'put' : 'post',
        'route' => $menu->exists ? ['menus.update', $menu->id] : ['menus.store'],
    ]) !!}
    @if($menu->exists)<input type="hidden" name="menus" id="menus" value="{{ $menu->permission }}" />@endif
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
            <label for="title">Menu Title</label>
            <input class="form-control" type="text" name="title" id="title" value="{{ $menu->title }}" />
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
            <label for="uri">URL</label>
            <input class="form-control" type="text" name="uri" id="uri" value="{{ $menu->uri }}" />
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="form-group">
            <input type="hidden" name="parent" id="parent" value="{{ $menu->is_parent }}">
            <label for="is_parent">Is Parent?</label>
            <input type="checkbox" name="is_parent" id="is_parent" value="1">
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="form-group">
            <input type="hidden" name="manage" id="manage" value="{{ $menu->manage_status }}">
            <label for="manage_status">Is Manage?</label>
            <input type="checkbox" name="manage_status" id="manage_status" value="1">
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="form-group">
            <input type="hidden" name="show" id="show" value="{{ $menu->show_menu }}">
            <label for="show_menu">Is Active?</label>
            <input type="checkbox" name="show_menu" id="show_menu" value="1">
        </div>
    </div>
    <?php $parents = \App\Models\Menus\Menu::where('is_parent', 1)->get();?>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
            <label for="is_parent">Parent</label>
            <select class="form-control" id="is_parented" name="is_parented">
                <option value="NULL">-=Pilih=-</option>
                @foreach($parents as $parent)
                <option value="{{ $parent->id }}"  @if($parent->id == $menu->parent_id) selected @endif>{{ $parent->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
            <button class="btn btn-primary">Save</button>
            <a class="btn btn-danger" href="{{ route('menus.index') }}">Back</a>
        </div>
    </div>
    {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection