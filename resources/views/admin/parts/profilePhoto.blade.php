@if($profile->photo1 != "" && $profile->photo1_approve == "APPROVED")
    <img src="{{ asset('storage/userImages/'.$profile->photo1) }}" class="card-img-top">
@elseif($profile->photo1 != "" && $profile->gender == "Female" && $profile->photo1_approve == "PENDING")
    <img src="{{ asset('admin/img/femalepending.jpg') }}" class="card-img-top">
@elseif($profile->photo1 != ""  && $profile->gender == "Male" && $profile->photo1_approve == "PENDING")
    <img src="{{ asset('admin/img/malepending.jpg') }}" class="card-img-top">
@else
    @if($profile->gender == "Male")
        <img src="{{ asset('admin/img/male.jpg') }}" class="card-img-top">
    @else
        <img src="{{ asset('admin/img/female.jpg') }}" class="card-img-top">
    @endif
@endif