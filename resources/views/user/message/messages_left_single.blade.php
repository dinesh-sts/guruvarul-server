@foreach ($chats as $chat)
    @if ($chat->message != null)
        <div class="chat-coversation">
            <div class="media">
                <span class="avatar avatar-xs flex-shrink-0">
                    @php
                        $user = Auth::guard('user')->user();
                        $site_configs = DB::table('site_configs')->first();
                        $status = DB::table('expressinterests')->where('ei_sender',$user->matri_id)->where('ei_receiver',$data->matri_id)->first();
                    @endphp
                    @if ($chat->sender != null)
                        
                        @php $filePath = '/userImages/'.$chat->sender->photo1; @endphp

                        @if($chat->sender->photo1 != "" && $chat->sender->photo1_approve == "APPROVED" && (($chat->sender->photo_setting == '0') || ($chat->sender->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($chat->sender->photo_setting == '2' && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('storage/userImages/'. $chat->sender->photo1)}}" class="img-fluid rounded w-100">
                        @elseif($chat->sender->photo1 != ""  && $chat->sender->gender == "Female" && $chat->sender->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded w-100">
                        @elseif($chat->sender->photo1 != ""  && $chat->sender->gender == "Male" && $chat->sender->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded w-100">
                        @else
                            @if($chat->sender->gender == "Male")
                                <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                            @else
                                <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                            @endif
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
@endforeach
