<a href="{{ route('user.login') }}" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
    <div class="card shadow-sm">
        @if(isset($data))
        <?php  $filePath = '/userImages/'.$data->photo1; ?>
            @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
            <img src="{{asset('storage/userImages/'. $data->photo1)}}" class="card-img-top">
            @elseif($data->photo1 != ""  && $data->gender == "Female" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
            @elseif($data->photo1 != ""  && $data->gender == "Male" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
            @else
                @if($data->gender == "Male")
                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                @else
                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                @endif
            @endif
        @endif
        <div class="card-body text-center">
            @if($siteConfig->username_setting == "full_username")
                <h4 class="card-title">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{$data->lastname}}@endif</h4>
            @elseif($siteConfig->username_setting == "first_surname")
                <h4 class="card-title">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{substr($data->lastname, 0, 1)}}@endif</h4>
            @else
                <h4 class="card-title">@if(isset($data->matri_id)){{$data->matri_id}}@endif</h4>
            @endif
            <h5 class="">User Id: <span class="colorPrimary">@if(isset($data->matri_id)){{$data->matri_id}}@endif</span></h5>
            <p class="mb-0">@if(isset($data->religion)){{$data->rel->religion_name}}@else Not Available @endif,@if(isset($data->caste)){{$data->cast->caste_name}}@else Not Available @endif,@if(isset($data->country)){{$data->country->country_name}}@else Not Available @endif</p>
        </div>
    </div>
</a>