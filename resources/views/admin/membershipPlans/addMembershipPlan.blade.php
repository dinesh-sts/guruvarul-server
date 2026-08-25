<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Add / Edit Membership Plan @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row mb-3 inMemberTopPanel">
        <div class="col-xl-9">
            <h3 class="colorSecondary inATitle1">
                @if(isset($membershipPlan))
                    Edit Membership Plan
                @else
                    Add Membership Plan
                @endif
            </h3>
        </div>
        <div class="col-xl-3 text-end">
            <a href="{{ route('admin.membershipPlan.all') }}" class="btn btnPrimary">
                <i class="fas fa-chevron-left pe-1"></i>Back
            </a>   
        </div>
    </div>
    <div class="row">    
        <div class="col-xl-8 m-auto mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-body pt-5">
                    <form method="POST" action="{{ isset($membershipPlan) ? route('admin.membershipPlan.update', $membershipPlan->id) : route('admin.membershipPlan.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan Name</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <input type="text" value="@if(isset($membershipPlan->plan_name)){{ $membershipPlan->plan_name }}@else{{ old('plan_name')}}@endif" name="plan_name" class="form-control" placeholder="Plan Name" required>
                                        @error('plan_name')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan Currency</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <select name="currency" class="form-select" id="floatingSelect" required>
                                            <option value="" selected>Select</option>
                                            @foreach($currencies as $currency)
                                            <option value="{{ $currency->currency }}" @if(isset($membershipPlan->currency)) {{ $membershipPlan->currency == $currency->currency ? "selected" : '' }}  @else @selected(old('currency') == $currency->currency) @endif>{{ $currency->currency }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan Price</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="input-group">
                                            <input type="text" value="@if(isset($membershipPlan->plan_amount)){{ $membershipPlan->plan_amount }}@else{{ old('plan_amount') }}@endif" name="plan_amount" class="form-control" placeholder="Plan Amount" required>
                                            @error('plan_amount')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan Duration</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">Days</span>
                                            <input type="text" value="@if(isset($membershipPlan->plan_duration)){{ $membershipPlan->plan_duration }}@else{{ old('plan_duration') }}@endif" name="plan_duration" class="form-control" placeholder="Plan Duration" required>
                                            @error('plan_duration')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Contact View</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <input type="text" value="@if(isset($membershipPlan->plan_contacts)) {{ $membershipPlan->plan_contacts }}@else{{ old('plan_contacts') }}@endif" name="plan_contacts" class="form-control" placeholder="Plan Contacts" required>
                                            @error('plan_contacts')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan Type</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <select name="plan_type" class="form-select" id="floatingSelect" required>
                                            <option value="" selected>Select</option>
                                            <option value="FREE" @if(isset($membershipPlan->plan_type)) {{ $membershipPlan->plan_type == "FREE" ? "selected" : '' }}  @else @selected(old('plan_type') == "FREE") @endif>Free</option>
                                            <option value="PAID" @if(isset($membershipPlan->plan_type)) {{ $membershipPlan->plan_type == "PAID" ? "selected" : '' }} @else @selected(old('plan_type') == "PAID") @endif >Paid</option>
                                        </select>
                                        @error('plan_type')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Plan for</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <select name="only_for" class="form-select" id="floatingSelect">
                                            <option value="" selected>All</option>
                                            <option value="Male" 
                                                @if(isset($membershipPlan->only_for)) 
                                                    @if(old('only_for',$membershipPlan->only_for) == "Male") 
                                                        Selected 
                                                    @endif 
                                                @endif>Male</option>
                                                <option value="Female" 
                                                @if(isset($membershipPlan->only_for)) 
                                                    @if(old('only_for',$membershipPlan->only_for) == "Female") 
                                                        Selected 
                                                    @endif 
                                                @endif>Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-1">Live Chat</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="form-check form-check-inline pe-3">
                                            <input class="form-check-input" type="radio" value="Yes" @if(isset($membershipPlan->chat)) {{$membershipPlan->chat == "Yes" ? 'checked' : '' }} @else @checked(old('chat') == 'Yes') @endif  name="chat" id="flexRadioDefault1" required>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="No" @if(isset($membershipPlan->chat)) {{ $membershipPlan->chat == "No" ? 'checked' : '' }} @else @checked(old('chat') == 'No') @endif name="chat" id="flexRadioDefault2" required>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('chat')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" value="SUBMIT" class="btn btnPrimary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection

<!-- Additional page js add here -->
@section('pageJS') @endsection