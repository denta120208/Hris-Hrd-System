@extends('_main_layout')

@section('content')
@if(!$member->exists)
<script type="text/javascript">
$(function () {
    $('#dob').datetimepicker({
        format: 'YYYY/MM/DD'
    });
});
</script>
@endif
<div class="col-lg-12">
    <h2>{!! $member->exists ? 'Edit Member' : 'Add Member' !!}</h2>
    {!! Form::model('member', [
        'method' => $member->exists ? 'put' : 'post',
        'route' => $member->exists ? ['members.update', $member->id] : ['members.store'],
    ]) !!}
    <input type="hidden" name="ip" id="ip" />
    @if(!$member->exists)
    <input type="hidden" name="status" value="1" />
    @endif
    <fieldset class="col-lg-6">
        <legend><strong>Personal Information</strong></legend>
        <div class='row'>
            <div class='col-sm-6'>
                <div class='form-group'>
                    {!! Form::label('first_name', 'First Name') !!}
                    {!! Form::text('first_name', $member->first_name, ['class' => 'form-control', 'placeholder' => 'John']) !!}
                </div>
            </div>
            <div class='col-sm-6'>
                <div class='form-group'>
                    {!! Form::label('last_name', 'Last Name') !!}
                    {!! Form::text('last_name', $member->last_name, ['class' => 'form-control', 'placeholder' => 'Doe']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-3'>
                <div class='form-group'>
                    {!! Form::label('gander', 'Gender') !!}
                    {!! Form::select('gander', array('' => '-=Pilih=-', 'L' => 'Male', 'P' => 'Female'), $member->gander, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class='col-sm-9'>
                <div class='form-group'>
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', $member->email, ['class' => 'form-control', 'placeholder' => 'john.doe@example.com']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class='form-group'>
                    {!! Form::label('hp_tlp', 'No Handphone') !!}
                    {!! Form::text('hp_tlp', $member->hp_tlp, ['class' => 'form-control', 'placeholder' => '012345678910']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class='form-group'>
                    {!! Form::label('dob', 'DOB') !!}
                    {!! Form::text('dob', $member->dob, ['class' => 'form-control', 'placeholder' => '2015/12/01']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class='form-group'>
                    {!! Form::label('ktp', 'No KTP') !!}
                    {!! Form::text('ktp', $member->ktp, ['class' => 'form-control', 'placeholder' => '12345678901234567890']) !!}
                </div>
            </div>
            <div class="col-lg-12">
                <div class='form-group'>
                    {!! Form::label('address', 'Address') !!}
                    {!! Form::textarea('address', $member->address, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset class="col-lg-6">
        <legend><strong>Membership Information</strong></legend>
        <div class='row'>
            <div class='col-sm-4'>    
                <div class='form-group'>
                    <?php
                    $member_type = App\Models\MemberType::lists('name', 'id')->prepend('-=Pilih=-', '');
                    ?>
                    {!! Form::label('member_type', 'Member Type') !!}
                    {!! Form::select('member_type', $member_type, $member->member_type, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class='col-sm-4'>
                <div class='form-group'>
                    <?php
                    $card = App\Models\CardType::lists('name', 'id')->prepend('-=Pilih=-', '');
                    ?>
                    {!! Form::label('card_type', 'Card Type') !!}
                    {!! Form::select('card_type', $card, $member->card_type, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class='col-sm-4'>
                <div class="checkbox form-group">
                    <label>
                        <input type="checkbox" name="booker" {!! $member->booker ? ' checked' : '' !!} data-val="true" and value="true" /> Member Hotel
                    </label>
                </div>
            </div>
            @if($member->exists)
            <div class='col-sm-12'>
                <div class='form-group'>
                    {!! Form::label('card_no', 'Metland Card No') !!}
                    {!! Form::text('card_no', $member->card_no, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                </div>
            </div>
            @endif
        </div>
    </fieldset>
    <br /><br />
    <fieldset class="col-lg-6">
        <legend><strong>Metland Residence Detail</strong></legend>
        <div class='row'>
            <div class='col-sm-5'>    
                <div class='form-group'>
                    <label for="unit_1">Unit 1</label>
                    <input class="form-control" id="unit_1" name="unit_1" type="text" placeholder="FP-01/02-020" value="{!! $member->unit_1 !!}" />
                </div>
            </div>
            <div class='col-sm-5'>    
                <div class='form-group'>
                    <label for="unit_2">Unit 2</label>
                    <input class="form-control" id="unit_2" name="unit_2" type="text" placeholder="UM-01/02-020" value="{!! $member->unit_2 !!}" />
                </div>
            </div>
            <div class='col-sm-5'>    
                <div class='form-group'>
                    <label for="unit_3">Unit 3</label>
                    <input class="form-control" id="unit_3" name="unit_3" type="text" placeholder="TC-01/02-020" value="{!! $member->unit_3 !!}" />
                </div>
            </div>
            <div class='col-sm-5'>    
                <div class='form-group'>
                    <label for="unit_4">Unit 4</label>
                    <input class="form-control" id="unit_4" name="unit_4" type="text" placeholder="PT-01/02-020" value="{!! $member->unit_4 !!}" />
                </div>
            </div>
            @if($member->exists)
            <div class='col-sm-12'>    
                <div class="form-group">
                    <label>Status Member</label> 
                    <div class="checkbox form-control">
                        <input type="checkbox" name="status" id='status' {!! $member->status ? ' checked' : '' !!} data-val="true" and value="true" />
                        <label for="status">Active</label>
                    </div>
                </div> 
                </div>
            </div>
            @endif
        </div>
    </fieldset>
    <div class="row">
        <div class="col-lg-12">
            <div class='col-sm-2 pull-right'>
                <input type="submit" value="Save" class="btn btn-primary" />
                <a class="btn btn-danger" href="{{ route('members.index') }}">Back</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection