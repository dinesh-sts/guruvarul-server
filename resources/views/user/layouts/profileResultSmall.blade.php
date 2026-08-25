@php
    use Carbon\Carbon;

    $user = Auth::guard('user')->user();
    $site_configs = DB::table('site_configs')->first();
    $status = DB::table('expressinterests')
        ->where('ei_sender', $user->matri_id)
        ->where('ei_receiver', $data->matri_id)
        ->first();

    // Check payment & expiry date
    $payment = DB::table('payments')
        ->where('pmatri_id', $user->matri_id)
        ->orderBy('id', 'desc') // or orderBy('exp_date', 'desc') if you want by date
        ->first();

    $hasValidPayment = true;
    if ($payment && !empty($payment->exp_date)) {
        
        try {
            // Parse d-m-y format (two-digit year)
            $expDate = Carbon::createFromFormat('d-m-y', $payment->exp_date);

            // Compare dates
            if (Carbon::now()->lte($expDate)) {
                $hasValidPayment = true;
            }
        } catch (\Exception $e) {
            $hasValidPayment = false; // Invalid date format
        }
    }
@endphp

<div class="col-xl-3 col-6 mb-3">
    <div class="card inProfileSM">
        @if($hasValidPayment)
            <a href="{{ route('user.memberProfile', $data->matri_id) }}">
        @else
            <a href="javascript:void(0);" onclick="$('#messagebox').toast('show');">
        @endif
            <div class="card-img-top">
                @if(isset($data))
                    @php $filePath = '/userImages/'.$data->photo1;  @endphp
                    
                    @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && (($data->photo_setting == '0') || ($data->photo_setting == '1' && $user->status == 'Paid') || ($data->photo_setting == '2' && $status && $status->receiver_response == "Accept")) && Storage::disk('public')->exists($filePath))
                        <img src="{{ asset('storage/userImages/'. $data->photo1) }}" class="img-fluid rounded w-100" style="width:200px; height:200px; object-fit:contain; background-color:#f8f9fa;">
                    @elseif($data->photo1 != "" && $data->gender == "Female" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{ asset('user/img/femalepending.jpg') }}" class="img-fluid rounded w-100" style="width:200px; height:200px; object-fit:contain; background-color:#f8f9fa;">
                    @elseif($data->photo1 != "" && $data->gender == "Male" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{ asset('user/img/malepending.jpg') }}" class="img-fluid rounded w-100" style="width:200px; height:200px; object-fit:contain; background-color:#f8f9fa;">
                    @else
                        @if($data->gender == "Male")
                            <img src="{{ asset('user/img/male.jpg') }}" class="img-fluid rounded w-100">
                        @else
                            <img src="{{ asset('user/img/female.jpg') }}" class="img-fluid rounded w-100">
                        @endif
                    @endif
                @endif
            </div>
            <div class="card-body text-center p-2">
                @if($siteconfig->username_setting == "full_username")
                    <h5>@if(isset($data->firstname)){{ $data->firstname }}@endif @if(isset($data->lastname)){{ $data->lastname }}({{ $data->matri_id }})@else {{ $data->matri_id }}@endif</h5>
                @elseif($siteconfig->username_setting == "first_surname")
                    <h5>@if(isset($data->firstname)){{ $data->firstname }}@endif @if(isset($data->lastname)){{ substr($data->lastname, 0, 1) }}({{ $data->matri_id }})@else {{ $data->matri_id }}@endif</h5>
                @else
                    <h5>@if(isset($data->matri_id)){{ $data->matri_id }}@endif</h5>
                @endif

                @php
                    if(isset($data->birthdate)) {
                        $from = Carbon::parse($data->birthdate);
                        $to = Carbon::now();
                        $age = $from->diff($to)->y;
                    }
                @endphp
                <p>
                    @if(isset($data->birthdate)){{ $age }} Yrs @else Not Available @endif,
                    @if(isset($data->profileby)){{ $data->profileby }}@else Not Available @endif,
                    @if(isset($data->religion)){{ $data->rel->religion_name }}@else Not Available @endif -
                    @if(isset($data->caste)){{ $data->cast->caste_name }}@else Not Available @endif,
                    @if(isset($data->country_id)){{ $data->country->country_name }}@else Not Available @endif.
                </p>
            </div>
        </a>

        @if($status == null)
            <div class="card-footer text-center" id="interestshow{{ $data->matri_id }}">
                <button type="button" class="btn btnPrimary" data-register-id="{{ $data->matri_id }}" 
                    @if($site_configs->interest_setting == "send_to_paid") 
                        @if($user->status == "Paid") 
                            onclick="sendintrest('{{ $data->matri_id }}')" 
                        @else 
                            onclick="$('#messagebox').toast('show');" 
                        @endif 
                    @else 
                        onclick="sendintrest('{{ $data->matri_id }}')" 
                    @endif
                >
                    <i class="fas fa-heart pe-2"></i>SEND INTEREST
                </button>
            </div>
        @else
            @if($status->receiver_response == "Pending")
                <div class="card-footer text-center">
                    <button class="btn btnPrimaryBordered">
                        <i class="fas fa-heart pe-2"></i>INTEREST SENT 
                    </button>
                </div>
            @elseif($status->receiver_response == "Accept")
                <div class="card-footer text-center">
                    <button class="btn btnPrimaryBordered">
                        <i class="fas fa-heart pe-2"></i>INTEREST ACCEPTED
                    </button>
                </div>
            @else
                <div class="card-footer text-center">
                    <button class="btn btnPrimaryBordered">
                        <i class="fas fa-heart pe-2"></i>INTEREST REJECTED
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>
