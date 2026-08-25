<div class="chat-box-wrap h-100 card">
    <div class="attached-top bg-white border-bottom chat-header d-flex justify-content-between align-items-center p-3 shadow-sm">
        <div class="media align-items-center d-flex flex-row">
            <span class="avatar avatar-sm mr-3 flex-shrink-0">
              @php
                    $current_user = Auth::guard('user')->user();
                    $payment = DB::table('payments')->where('pmatri_id',$current_user->matri_id)->OrderBy('created_at', 'desc')->first();
              @endphp
            
                {{-- @if($current_user == $chat_thread->receiver_user_id)
                  @php $user_to_show = 'receiver';  @endphp
                @else
                  @php $user_to_show = 'sender';  @endphp
                @endif --}}
                @php
                   if($current_user->id == $chat_thread->receiver_user_id)
                   {
                       $user = $data = DB::table('registers')->where('id',$chat_thread->sender_user_id)->first();
                   }else{
                        $user = $data = DB::table('registers')->where('id',$chat_thread->receiver_user_id)->first();
                   }
                @endphp
                @if ($user->photo1 != null)
                <?php  $filePath = '/userImages/'.$user->photo1; ?>
                    @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('storage/userImages/'.$user->photo1)}}" class="img-fluid rounded-circle" >
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
                <h6 class="ps-2 pe-2 mb-0">
                    {{ $user->firstname.' '.$user->lastname }} ({{ $user->matri_id }})
                    {{-- @if(Cache::has('user-is-online-' . $chat_thread->$user_to_show->id))
                        <span class="badge badge-dot badge-success badge-circle"></span>
                    @else
                        <span class="badge badge-dot badge-secondary badge-circle"></span>
                    @endif --}}
                </h6>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <button class="ii-mobile-toggler d-lg-none ii-all-chat-toggler mr-2" data-toggle="class-toggle" data-target=".chat-user-list-wrap">
                <span></span>
            </button>
            <button class="btn btn-icon btn-circle btn-soft-primary chat-info" data-toggle="class-toggle" data-target=".chat-info-wrap"><i class="las la-info-circle"></i></button>
        </div>
    </div>
    <div class="chat-list-wrap c-scrollbar-light scroll-to-btm" id="parentDiv">
        @if (count($chats) > 0)
            <div class="chat-coversation-load text-center">
                <button type="button" class="btn btn-link load-more-btn" value="{{ $chats->last()->id }}" data-first="{{ $chats->last()->id }}" type="button" onclick="initializeLoadMore('{{$chats->last()->id}}')">Load More...</button>
            </div>
        @endif
        <div class="chat-list px-4" id="chat-messages">
            @include('user.message.messages_part',['chats' => $chats])
        </div>
    </div>
    
    <div class="chat-footer border-top p-3 attached-bottom bg-white">
        <form id="send-mesaage">
            <div class="input-group">
                <input type="hidden" id="chat_thread_id" name="chat_thread_id" value="{{ $chat_thread->id }}">
                @if(isset($payment->chat))
                    @if($current_user->status == "Paid" && $payment->chat == "Yes")
                    <input type="text" class="form-control" name="message" id="message" placeholder="Your Message.." autocomplete="off">
                    @else
                        <input type="text" class="form-control" placeholder="Your Message.." value="Please Upgrade Your Membership Plan" autocomplete="off" disabled>
                    @endif
                @else
                    <input type="text" class="form-control" placeholder="Your Message.." value="Please Upgrade Your Membership Plan" autocomplete="off" disabled>
                @endif

                <input type="hidden" class="" name="attachment" id="attachment">
                <div class="input-group-append">
                    <button class="btn btnMessageSend" onclick="send_reply()" type="button">
                        <i class="fas fa-paper-plane fa-fw"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    
</div>
