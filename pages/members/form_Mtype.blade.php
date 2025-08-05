@extends('_main_layout')

@section('content')
<script type="text/javascript">
$(document).ready( function(){
    $('#member_type').on('change', function() {
        var mType = $('#member_type').val();
        var token = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{ action('MemberController@get_member_type') }}",
            data: {type_id : mType,'_token': token},
            dataType: 'html',
            cache: false,
            success: function (response) {
                $('#form_mtype').html(response);// Ga bisa show HTML
            },
            error: function() {
               alert('Error, Please contact Administrator!');
            }
        }); 
    });
});
</script>
<div class="col-lg-12">
    <h2>Member Type</h2>
    <input type="hidden" name="ip" id="ip" />
    <div>&nbsp;</div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="member_type">Member Type</label>
            <select name="member_type" id="member_type" class="form-control">
                <option value="">-=Pilih=-</option>
                @foreach($member_types as $member_type)
                <option value="{!! $member_type->id !!}">{!! $member_type->name !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="form_mtype">
        
    </div>
</div>
@endsection