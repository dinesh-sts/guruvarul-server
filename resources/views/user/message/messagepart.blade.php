@foreach ($chats->reverse() as $chat)
    @if ($chat->sender_user_id == Auth::guard('user')->user()->id)
        @if ($chat->message != null)
            <div class="chat-coversation right">
                <div class="media">
                    <div class="media-body">
                        <div class="text bg-soft-primary text-dark">{{ $chat->message }}</div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                    <span class="avatar avatar-xs flex-shrink-0">
                        @php
                            $current_user = Auth::guard('user')->user();
                        @endphp
                        @php
                            $user = $data = DB::table('registers')->where('id',$chat->sender_user_id)->first();
                        @endphp
                         @if ($user->photo1 != null)
                         <?php  $filePath = '/userImages/'.$user->photo1; ?>
                             @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                 <img src="{{asset('/storage/userImages/'.$user->photo1)}}" class="img-fluid rounded-circle" >
                             @elseif($user->photo1 != ""  && $user->gender == "Female" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                 <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded-circle" >
                             @elseif($user->photo1 != ""  && $user->gender == "Male" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                 <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded-circle" >
                             @endif
                         @else
                             @if($user->gender == "Male")
                                 <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded-circle">
                             @else
                                 <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded-circle">
                             @endif
                         @endif
                         
                    </span>
                </div>
            </div>
        @endif
    @else
        @if ($chat->message != null)
            <div class="chat-coversation">
                <div class="media">
                    <span class="avatar avatar-xs flex-shrink-0">
                        @php
                        $user = $data = DB::table('registers')->where('id',$chat->sender_user_id)->first();
                       
                    @endphp
                     @if ($user->photo1 != null)
                     <?php  $filePath = '/userImages/'.$user->photo1; ?>
                         @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                             <img src="{{asset('/storage/userImages/'.$user->photo1)}}" class="img-fluid rounded-circle" >
                         @elseif($user->photo1 != ""  && $user->gender == "Female" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                             <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded-circle">
                         @elseif($user->photo1 != ""  && $user->gender == "Male" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                             <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded-circle">
                         @endif
                     @else
                         @if($user->gender == "Male")
                             <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded-circle">
                         @else
                             <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded-circle">
                         @endif
                     @endif
                    </span>
                    <div class="media-body">
                        <div class="text">{{ $chat->message }}</div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endforeach
