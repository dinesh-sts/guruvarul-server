@if ($chat->message != null)
    <div class="chat-coversation right">
        <div class="media">
            <div class="media-body">
                <div class="text bg-soft-primary text-dark">{{ $chat->message }}</div>
                <span class="time">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</span>
            </div>
            <span class="avatar avatar-xs flex-shrink-0">
                @if ($chat->sender != null)
                    @if ($chat->sender->photo1 != null)
                    <?php  $filePath = '/userImages/'.$chat->sender->photo1; ?>
                        @if($chat->sender->photo1 != "" && $chat->sender->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('storage/userImages/'.$chat->sender->photo1)}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                        @elseif($chat->sender->photo1 != ""  && $chat->sender->gender == "Female" && $chat->sender->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                        @elseif($chat->sender->photo1 != ""  && $chat->sender->gender == "Male" && $chat->sender->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                        @endif
                    @else
                        @if($chat->sender->gender == "Male")
                            <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                        @else
                            <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded-circle img-thumbnail"  style="max-height:80px;">
                        @endif
                    @endif
                @endif
            </span>
        </div>
    </div>
@endif
