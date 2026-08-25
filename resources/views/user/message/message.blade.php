@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<div class="container pb-5">
    <div class="row no-gutters">
        <div class="col-lg-4 mt-5">
            <div class="chat-user-list-wrap card">
                
                <div class="chat-user-list-header card-header">
                    <span class="">Members</span>
                </div>
				
                <div class="chat-user-list border-right c-scrollbar-light card-body p-0 inChatUserList ">
                    @forelse ($chat_threads as $key => $single_chat_thread)
                        @php
                            $num_of_message = $single_chat_thread->chats->where('seen', 0)->count();
                            $current_user = Auth::guard('user')->user()->id;
                        @endphp
                       
                        @if ($single_chat_thread->receiver != null && $single_chat_thread->sender != null)
                            <a href="javascript:void(0)" class="chat-user-item" data-url="{{ route('user.chat_view', $single_chat_thread->id) }}" data-refresh="{{ route('user.chat_refresh', $single_chat_thread->id) }}" onclick="loadChats(this)">
                                @if($current_user == $single_chat_thread->sender->id)
                                    @php $user_to_show = 'receiver';  @endphp
                                @else
                                    @php $user_to_show = 'sender';  @endphp
                                @endif
                             
                                <div class="card border-0">
									<div class="card-body">
										<div class="row">
											<div class="col-3">
                                                <?php
                                                if($single_chat_thread->$user_to_show->online_time != null)
                                                {
                                                    $givenDate = \Carbon\Carbon::parse($single_chat_thread->$user_to_show->online_time);
                                                    $currentDate = \Carbon\Carbon::now('Asia/Kolkata');
                                                    $differenceInMinutes = $currentDate->diffInMinutes($givenDate);
                                                    if ($differenceInMinutes <= 1) {
                                                        $status = 'Yes';
                                                    } else {
                                                        $status = 'No';
                                                    }
                                                }else{
                                                    $status = 'No';
                                                }
                                                   
                                                ?>
												<?php  $filePath = '/userImages/'.$single_chat_thread->$user_to_show->photo1; ?>
												@if($single_chat_thread->$user_to_show->photo1 != "" && Storage::disk('public')->exists($filePath))
													<img src="{{asset('storage/userImages/'.$single_chat_thread->$user_to_show->photo1)}}" style="border:{{ $status == 'No' ? '2px solid red' : '2px solid rgb(0, 255, 81)' }};max-height:70px;" class="img-fluid rounded-circle">
												@else
													@if($single_chat_thread->$user_to_show->gender == "Male")
														<img src="{{asset('user/img/male.jpg')}}" style="border:{{ $status == 'No' ? '2px solid red' : '2px solid rgb(0, 255, 81)' }};max-height:70px;" class="img-fluid rounded-circle">
													@else
														<img src="{{asset('user/img/female.jpg')}}" style="border: {{ $status == 'No' ? '2px solid red' : '2px solid rgb(0, 255, 81)' }};max-height:70px;" class="img-fluid rounded-circle">
													@endif
												@endif                                              
											</div>
											<div class="col-9 inChatUserContent g-0">
												<div class="">
													<h6 class="mt-0 mb-1 fs-14 text-truncate">{{ $single_chat_thread->$user_to_show->firstname.' '.$single_chat_thread->$user_to_show->lastname}} ({{$single_chat_thread->$user_to_show->matri_id}})</h6>
													<div class="row g-0">
														<div class="col-10">
															@if ($single_chat_thread->chats->last() != null)
																@if ($single_chat_thread->chats->last()->message != null)
																	<div class="text-truncate inChatLastMsg">@if(isset($single_chat_thread->chats)){{ $single_chat_thread->chats->last()->message }}@endif</div>
																@else
																	<div class="text-truncate">{{ ('Attachments')}}</div>
																@endif
															@endif
														</div>
														<div class="col-2">
															<span class="badge bgPrimary badge-circle flex-shrink-0">{{ count($single_chat_thread->chats->where('sender_user_id', '!=', Auth::guard('user')->user()->id)->where('seen', 0)) }}</span>
														</div>
													</div>


												</div>
												<div class="ml-2 text-right">
													@if ($single_chat_thread->chats->last() != null)
														<div class="inChatLastTime fs-10 mb-1">{{ Carbon\Carbon::parse($single_chat_thread->chats->last()->created_at)->diffForHumans() }}</div>
													@endif
												</div>
											</div>
										</div>
									</div>
                                </div>
							</a>
                        @endif
					
                    	@empty
                        <div class=" text-center">
                            <i class="las la-frown la-4x mb-4 opacity-40"></i>
                            <h4>No Data Found</h4>
                        </div>
					
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-8 mt-5" id="single_chat">
            <div class="chat-box-wrap h-100 card">
                <div class="card-header">
                    <div class="media">
                        <span class="mb-0">Chat</span>
                    </div>
                </div>
                <div class="px-3 py-5 text-center card-body">
                    <h5 class="fs-6">Select a Member to view chats</h5>
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.message.package_update_alert_modal')

@endsection

@section('pageJS')
<script type="text/javascript">
    function loadChats(el){
        $('.selected-chat').each(function() {
            $(this).removeClass('bg-soft-primary');
            $(this).removeClass('selected-chat');
        });
        $(el).addClass('selected-chat');
        $(el).addClass('bg-soft-primary');
        $.get($(el).data('url'),{}, function(data){
            console.log(data);
            $('#single_chat').html(data);
            initializeLoadMore();
            $('#send-mesaage').on('submit',function(e){
                e.preventDefault();
                console.log("loadChats");
                send_reply();
            });
            
        });
    }

    function send_reply(){
        var chat_thread_id = $('#chat_thread_id').val();
        var message = $('#message').val();
        var attachment = $('#attachment').val();
        if(message.length > 0 || attachment.length > 0){
            $.post('{{ route('user.chat_reply') }}',{_token:'{{ csrf_token() }}', chat_thread_id:chat_thread_id, message:message, attachment:attachment}, function(data){
                $('#message').val('');
                $('#attachment').val('');
                $('#chat-messages').append(data);
            });
        }
    }

   
    $(document).ready(function () {
        var currentURL = window.location.href;
        if (currentURL.includes('{{ route("user.message") }}')) {
          
        } else{
            fetch('{{ route("delete.record") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                })
            })
            .then(response => {
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    
        setInterval(function () {
            refreshChats();
        }, 5000);
    });
    function refreshChats(){
        var el = $('.selected-chat');
        $.get($(el).data('refresh'),{}, function(data){
            if (data.count > 0) {
                console.log("refreshChats");
                $('#chat-messages').append(data.messages);
            }
        });
    }

    function initializeLoadMore(){
            var data = $('.load-more-btn').val();
                $.post('{{ route('get-old-messages') }}', {_token:'{{ csrf_token() }}', first_message_id:data}, function(data){
                    if (data.first_message_id > 0) {
                        $('#chat-messages').prepend(data.messages);
                        $('.load-more-btn').data('first', data.first_message_id);
                    }
                });
        }

    function package_update_alert(){
      $('.package_update_alert_modal').modal('show');
    }
    $(".scroll-to-btm").each(function (i, el) {
                el.scrollTop = el.scrollHeight;
            });

</script>
@endsection
