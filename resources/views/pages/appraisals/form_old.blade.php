@extends('_main_layout')

@section('content')
<style type="text/css">
    .popover{
        max-width:600px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("[data-toggle=popover]").popover({
            container: 'body'
        });
        {{--$("#appraisal_cat").change(function(){--}}
        {{--    var e = document.getElementById("appraisal_cat");--}}
        {{--    var id = e.options[e.selectedIndex].value;--}}
        {{--    var typeId = '{{ $type->code->code_appraisal }}';--}}
        {{--    $.ajax({--}}
        {{--        url: '{{ route('getAppraisal') }}',--}}
        {{--        type: 'get',--}}
        {{--        data: { id:id, type_code:typeId },--}}
        {{--        dataType: 'html',--}}
        {{--        cache: false,--}}
        {{--        success:function(response){--}}
        {{--            $('#true-form').html(response);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    });
</script>
<div class="container">
    <input type="hidden" id="addClasses" value="active" />
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                @if($pic)
                    <img class="img-responsive img-thumbnail" src="data:image/jpeg;base64,{{ base64_encode( $pic->epic_picture ) }}"/>
                @else
              