<div class="modal fade modal-lg" id="staticBackdrop{{$member->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Approved To Paid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.approvedToPaidStore') }}" method="post">
                @csrf
    
                <div class="modal-body inMainResultCard inAdminPaidModal">
                    <div class="row">
                        <div class="col-xl-3">
                            @if(isset($member))
                            <?php  $filePath = '/userImages/'.$member->photo1; ?>
                            @if($member->photo1 != "" && $member->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('storage/userImages/'.$member->photo1)}}" class="img-fluid rounded w-100">
                            @elseif($member->photo1 != ""  && $member->gender == "Female" && $member->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('Admin/img/femalepending.jpg')}}" class="card-img-top">
                            @elseif($member->photo1 != ""  && $member->gender == "Male" && $member->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('Admin/img/malepending.jpg')}}" class="card-img-top">
                            @else
                                @if($member->gender == "Male")
                                    <img src="{{asset('Admin/img/male.jpg')}}" class="img-fluid rounded w-100">
                                @else
                                    <img src="{{asset('Admin/img/female.jpg')}}" class="img-fluid rounded w-100">
                                @endif
                            @endif
                            @endif
                        </div>
                        <div class="col-xl-9">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">@if(isset($member->firstname)){{$member->firstname}}@endif @if(isset($member->lastname)){{$member->lastname}}@endif</h5>
                                    <h6 class="mb-3">@if(isset($member->matri_id)){{$member->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($member->profileby)){{$member->profileby}}@endif</h6>
                                </div>
                                <div class="col-12 inAResultStatus mb-3">
                                    <div class="row">
                                        <div class="col-5">
                                            @if($member->status == "Paid")<i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>@elseif($member->status == "Active")<i class="fas fa-thumbs-up pe-2"></i><span class="">APPROVED</span>@elseif($member->status == "Inactive")<i class="fas fa-thumbs-down pe-2"></i><span class="">Unapproved</span>@elseif($member->status == "Suspended")<i class="fas fa-times pe-2"></i><span class="">Suspended</span> @endif
                                        </div>
                                        <div class="col">
                                            @if(isset($member->fstatus))<i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php   
                                $from = "";
                                if(isset($member->birthdate)){
                                    $from = Carbon\Carbon::parse($member->birthdate);
                                }
                                $to = Carbon\Carbon::now();
                                $age =$from->diff($to)->y;
                            ?>
                            <p class="card-text">@if(isset($age)){{$age}} Yrs, @endif @if(isset($member->gender)){{$member->gender}},@endif @if(isset($member->m_tongue)){{$member->mother_tongue->mtongue_name}}@endif </p>

                            <p class="card-text">@if(isset($member->caste)){{$member->cast->caste_name}},@endif @if(isset($member->religion )){{$member->rel->religion_name}}@endif</p>

                            <p class="card-text">
                                {{ $member->occ->ocp_name ?? '' }}
                                @if(!empty($member->occ->ocp_name)),@endif
                                {{ $member->state->state_name ?? '' }}
                                @if(!empty($member->state->state_name)),@endif
                                {{ $member->country->country_name ?? '' }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3 mb-3">
                            <h5 class="inAsignTitle">Assign Membership Plan</h5>
                        </div>
                        <div class="col-4">
                            <label class="label-1">Payment Mode</label>
                            <select name="paymode" class="form-select" required>
                                <option value="">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="DD">DD</option>
                                <option value="Money Order">Money Order</option>
                                <option value="Funds Transfer">Funds Transfer</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="label-1">Activation Date</label>
                            <?php  $date = Carbon\Carbon::today()->format("d-m-y"); ?>
                            <input type="text" name="pactive_dt" class="form-control" value="" placeholder="{{$date}}">
                        </div>
                        <div class="col-4">
                            <label class="label-1">Select Plan</label>
                            <select name="p_plan"class="form-select" required>
                                <option  value="">Select Plan</option>
                                @foreach ($membershipPlans as $membershipPlan)
                                    <option value="{{ $membershipPlan->plan_name }}">{{ $membershipPlan->plan_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <div class="col-12">
                        <button type="submit" class="btn btnPrimary pt-2 pb-2 d-inline" name="id" value="{{$member->id}}">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
