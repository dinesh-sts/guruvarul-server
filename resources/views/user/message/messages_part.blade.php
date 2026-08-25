
@foreach ($chats->reverse() as $chat)
    @if ($chat->sender_user_id == Auth::guard('user')->user()->id)
            
        @if ($chat->message != null)
            <div class="chat-coversation right">
                <div class="media">
                
                    <div class="media-body">
                       {{-- authuser message --}}
                        <div class="text bg-soft-primary text-dark">{{ $chat->message }}</div>
                        <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
                    </div>
                    <span class="avatar avatar-xs flex-shrink-0">
                        <?php 
                            $auth  = Auth::guard('user')->user();
                        ?>
                        @if ($auth->photo1 != null)
                        <?php  $filePath = '/userImages/'.$auth->photo1; ?>
                            @if($auth->photo1 != "" && $auth->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('/storage/userImages/'.$auth->photo1)}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @elseif($auth->photo1 != ""  && $auth->gender == "Female" && $auth->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @elseif($auth->photo1 != ""  && $auth->gender == "Male" && $auth->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @endif
                        @else
                            @if($auth->gender == "Male")
                                <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @else
                                <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @endif
                        @endif
                    </span>
                </div>
            </div>
        @endif
    @else
    {{-- user message --}}
        @if ($chat->message != null)
            <div class="chat-coversation">
                <div class="media">
                    <span class="avatar avatar-xs flex-shrink-0">
                        <?php 
                            $user  = DB::table('registers')->where('id',$chat->sender_user_id)->first();
                        ?>
                        @if ($user->photo1 != null)
                        <?php  $filePath = '/userImages/'.$user->photo1; ?>
                            @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('/storage/userImages/'.$user->photo1)}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @elseif($user->photo1 != ""  && $user->gender == "Female" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('User/img/femalepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @elseif($user->photo1 != ""  && $user->gender == "Male" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('User/img/malepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @endif
                        @else
                            @if($user->gender == "Male")
                                <img src="{{asset('User/img/male.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                            @else
                                <img src="{{asset('User/img/female.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
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
