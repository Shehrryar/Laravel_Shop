@extends('admin.layout.app')
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Chats</h1>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" value='{{Request::get("keyword")}}' name="keyword"
                                class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div style="display: flex;" class="chat_container">
                <div style="padding:40px;" class="chat-container">

                    @foreach ($allchatstoadmin as $userId => $chats)
                                        @if (isset($chats['user_detail']))
                                            <a href="#" onclick='openChat({{$userId}})'>{{ $chats['user_detail']['name'] }}</a>
                                            <!-- Display the User's Name -->
                                        @endif
                                        @php
                                            // Get the latest chat message
                                            $latestChat = collect($chats)
                                                ->filter(function ($chat, $key) {
                                                    return $key !== 'user_detail'; // Ignore user_detail key
                                                })
                                                ->sortByDesc('created_at')
                                                ->first();
                                          @endphp
                                        @if ($latestChat)
                                            <div class="chat-message {{ $latestChat->sender_id === $userId ? 'sent' : '' }}">
                                                <p><strong>Message:</strong> {{ htmlspecialchars($latestChat->message_content) }}</p>
                                                <p><small><strong>Sent At:</strong> {{ $latestChat->created_at }}</small></p>
                                            </div>
                                        @endif
                    @endforeach
                </div>
                <div style="width:100%;" id="chatBox" class="chat-box">
                    <div class="chat-header"
                        style="background-color: #f1f1f1; padding: 10px; border-bottom: 1px solid #ccc;">
                        <span>Chat</span>
                    </div>
                    <div class="chat-content" id="chatContent"
                        style="height: calc(100% - 100px); overflow-y: auto; padding: 10px; background-color: #ffffff;">
                    </div>

                    <div style="display: flex; width:90%; " class="chat-input"
                        style="padding: 10px; border-top: 1px solid #ccc; background-color: #f9f9f9;">
                        <input type="textarea" id="chatMessageInput" placeholder="Type a message..."
                            style="width: calc(100% - 60px); padding: 5px; " />
                            <input id="receiver_id" type="hidden" value= "">
                        <button id="sendMessageBtn"
                            style="padding: 5px 10px; margin-left: 5px; font-size:13px; ">Send</button>
                    </div>
                </div>

            </div>
            <div class="card-footer clearfix">
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('customjs') 
<script>
    function deleuser(user_id) {
        var delurl = '{{route("users.delete", "ID")}}'.replace("ID", user_id);
        if (confirm("Are you sure you want to delete " + user_id)) {
            $.ajax({
                url: delurl,
                type: 'delete',
                data: {}, // Use correct form ID
                dataType: 'json', // 'datatype' should be 'dataType'
                success: function (response) {
                    if (response['status']) {
                        window.location.href = "{{route('users.index')}}";
                    }
                }
            });
        }
    }

    function openChat(user_id) {
        $.ajax({
            url: '{{route('chat.chatdisplaybox')}}',
            type: 'post',
            data: { user_id: user_id,
                _token: "{{ csrf_token() }}",
             }, // Use correct form ID
            dataType: 'json', // 'datatype' should be 'dataType'
            success: function (response) {
                if (response['status'] === true) {
                    const chatContent = document.getElementById('chatContent'); // Make sure this element exists
                    chatContent.innerHTML = ''; // Clear existing messages if needed
                    for (let i = 0; i < response.specificChat.length; i++) {
                        const message = response.specificChat[i]; // Move this line outside of the conditional block
                        let newMessage = document.createElement('p');
                        let receiver_id = document.getElementById('receiver_id');
                        newMessage.style.wordBreak = 'break-all';
                        newMessage.style.borderRadius = '60px';
                        newMessage.style.padding = '10px';
                        newMessage.style.width = '60%';
                        newMessage.style.color = 'white';
                        receiver_id.value = user_id;
                        // Check if the message sender matches
                        if (user_id == message.receiver_id) {
                            newMessage.style.backgroundColor = 'blue';
                            newMessage.textContent = message.message_content;
                        } else {
                            newMessage.style.backgroundColor = 'grey';
                            newMessage.style.marginLeft = '40%';
                            newMessage.textContent = message.message_content;
                        }
                        // Append the new message to the chat content container
                        chatContent.appendChild(newMessage);
                    }
                }
            }
        });
    }
    setInterval(openChat, 50);



    document.getElementById('sendMessageBtn').addEventListener('click', function () {
        event.preventDefault();
        const messageInput = document.getElementById('chatMessageInput');
        const chatContent = document.getElementById('chatContent');
        const receiverId = document.getElementById('receiver_id');

        $.ajax({
            url: "{{ route('chat.sentmessage') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                message_content: messageInput.value,
                receiverId:receiverId.value
            },
            success: function (message) {

                const newMessage = document.createElement('p');
                newMessage.textContent = message.message_content;
                newMessage.style.backgroundColor = 'blue';
                newMessage.style.color = 'white';
                newMessage.style.padding = '10px';
                newMessage.style.borderRadius = '60px';
                newMessage.style.wordBreak = 'break-all';
                newMessage.style.width = '60%';
                chatContent.appendChild(newMessage);
                messageInput.value = ''; // Clear input field
                chatContent.scrollTop = chatContent.scrollHeight; // Scroll to bottom
            }
        });
    });
</script>
@endsection