@extends('admin.layout.app')

@section('customcss')
<link rel="stylesheet" href="{{ asset('admin-assets/css/admin-chat.css') }}">
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Chats</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include('admin.message')

        <div class="card chat-admin-card">
            <div class="chat-admin-wrapper">

                <div class="chat-users-panel">
                    <div class="chat-users-header">
                        <h5>Customers</h5>

                        <form action="" method="get">
                            <div class="input-group input-group-sm">
                                <input type="text"
                                       value="{{ Request::get('keyword') }}"
                                       name="keyword"
                                       class="form-control"
                                       placeholder="Search user">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="chat-users-list">
                        @forelse ($chatUsers as $chatUser)
                            <button type="button"
                                    class="chat-user-item {{ $chatUser->unread_count > 0 ? 'unread' : '' }}"
                                    id="chat-user-{{ $chatUser->user->id }}"
                                    onclick="selectUser({{ $chatUser->user->id }}, '{{ addslashes($chatUser->user->name) }}')">

                                <div class="chat-user-avatar">
                                    {{ strtoupper(substr($chatUser->user->name ?? 'U', 0, 1)) }}
                                </div>

                                <div class="chat-user-info">
                                    <div class="chat-user-top">
                                        <strong>{{ $chatUser->user->name }}</strong>
                                        <small>{{ $chatUser->latest_time }}</small>
                                    </div>

                                    <div class="chat-user-email">
                                        {{ $chatUser->user->email }}
                                    </div>

                                    <div class="chat-user-latest">
                                        {{ \Illuminate\Support\Str::limit($chatUser->latest_message, 45) }}
                                    </div>

                                    @if ($chatUser->unread_count > 0)
                                        <span class="badge badge-warning" id="unread-badge-{{ $chatUser->user->id }}">
                                            {{ $chatUser->unread_count }} new
                                        </span>
                                    @endif
                                </div>
                            </button>
                        @empty
                            <div class="empty-users">
                                No customers found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="chat-main-panel">
                    <div class="chat-main-header">
                        <div>
                            <h5 id="selectedUserName">Select a customer</h5>
                            <small id="selectedUserStatus">Choose a user from the left side to view chat</small>
                        </div>
                    </div>

                    <div class="chat-content" id="chatContent">
                        <div class="empty-chat">
                            No chat selected.
                        </div>
                    </div>

                    <div class="chat-input-area">
                        <input id="receiver_id" type="hidden" value="">

                        <input type="text"
                               id="chatMessageInput"
                               class="form-control"
                               placeholder="Type a message..."
                               disabled>

                        <button id="sendMessageBtn"
                                class="btn btn-primary"
                                disabled>
                            Send
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')


<script>
    let activeReceiverId = null;
    let adminChatSubscribed = false;

    const adminId = {{ $adminId ?? Auth::guard('admin')->id() ?? Auth::id() ?? 0 }};

    function scrollAdminChatToBottom() {
        const chatContent = document.getElementById('chatContent');

        if (chatContent) {
            chatContent.scrollTop = chatContent.scrollHeight;
        }
    }

    function appendAdminMessage(message) {
        const chatContent = document.getElementById('chatContent');

        if (!chatContent) {
            return;
        }

        const emptyChat = chatContent.querySelector('.empty-chat');

        if (emptyChat) {
            emptyChat.remove();
        }

        const alreadyExists = document.getElementById(`admin-message-${message.id}`);

        if (alreadyExists) {
            return;
        }

        const isMine = String(message.sender_id) === String(adminId);

        const row = document.createElement('div');
        row.id = `admin-message-${message.id}`;
        row.className = isMine ? 'message-row mine' : 'message-row customer';

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';

        const messageText = document.createElement('div');
        messageText.textContent = message.message_content;

        const time = document.createElement('div');
        time.className = 'message-time';
        time.textContent = message.created_at || '';

        bubble.appendChild(messageText);
        bubble.appendChild(time);
        row.appendChild(bubble);

        chatContent.appendChild(row);
        scrollAdminChatToBottom();
    }

    function createUserItemIfNotExists(message) {
        const userId = message.sender_id;
        let userItem = document.getElementById(`chat-user-${userId}`);

        if (userItem) {
            return userItem;
        }

        const usersList = document.querySelector('.chat-users-list');

        if (!usersList) {
            return null;
        }

        const emptyUsers = usersList.querySelector('.empty-users');

        if (emptyUsers) {
            emptyUsers.remove();
        }

        const userName = message.sender_name || 'Customer';
        const userEmail = message.sender_email || '';
        const firstLetter = userName.charAt(0).toUpperCase();

        userItem = document.createElement('button');
        userItem.type = 'button';
        userItem.className = 'chat-user-item unread';
        userItem.id = `chat-user-${userId}`;

        userItem.onclick = function () {
            selectUser(userId, userName);
        };

        const avatar = document.createElement('div');
        avatar.className = 'chat-user-avatar';
        avatar.textContent = firstLetter;

        const info = document.createElement('div');
        info.className = 'chat-user-info';

        const top = document.createElement('div');
        top.className = 'chat-user-top';

        const strong = document.createElement('strong');
        strong.textContent = userName;

        const small = document.createElement('small');
        small.textContent = message.created_at || '';

        top.appendChild(strong);
        top.appendChild(small);

        const email = document.createElement('div');
        email.className = 'chat-user-email';
        email.textContent = userEmail;

        const latest = document.createElement('div');
        latest.className = 'chat-user-latest';
        latest.textContent = message.message_content;

        const badge = document.createElement('span');
        badge.className = 'badge badge-warning';
        badge.id = `unread-badge-${userId}`;
        badge.style.marginTop = '5px';
        badge.textContent = 'New';

        info.appendChild(top);
        info.appendChild(email);
        info.appendChild(latest);
        info.appendChild(badge);

        userItem.appendChild(avatar);
        userItem.appendChild(info);

        usersList.prepend(userItem);

        return userItem;
    }

    function updateUserLatestMessage(userId, messageText, message = null) {
        let userItem = document.getElementById(`chat-user-${userId}`);

        if (!userItem && message) {
            userItem = createUserItemIfNotExists(message);
        }

        if (!userItem) {
            return;
        }

        const latestBox = userItem.querySelector('.chat-user-latest');

        if (latestBox) {
            latestBox.textContent = messageText;
        }

        const timeBox = userItem.querySelector('.chat-user-top small');

        if (timeBox && message && message.created_at) {
            timeBox.textContent = message.created_at;
        }

        const usersList = document.querySelector('.chat-users-list');

        if (usersList) {
            usersList.prepend(userItem);
        }
    }

    function markUserAsUnread(userId, message = null) {
        let userItem = document.getElementById(`chat-user-${userId}`);

        if (!userItem && message) {
            userItem = createUserItemIfNotExists(message);
        }

        if (!userItem) {
            return;
        }

        userItem.classList.add('unread');

        let badge = document.getElementById(`unread-badge-${userId}`);

        if (!badge) {
            badge = document.createElement('span');
            badge.id = `unread-badge-${userId}`;
            badge.className = 'badge badge-warning';
            badge.style.marginTop = '5px';
            badge.textContent = 'New';

            const userInfo = userItem.querySelector('.chat-user-info');

            if (userInfo) {
                userInfo.appendChild(badge);
            }
        }
    }

    function clearUserUnread(userId) {
        const userItem = document.getElementById(`chat-user-${userId}`);

        if (userItem) {
            userItem.classList.remove('unread');
        }

        const badge = document.getElementById(`unread-badge-${userId}`);

        if (badge) {
            badge.remove();
        }
    }

    function selectUser(userId, userName) {
        activeReceiverId = userId;

        document.getElementById('receiver_id').value = userId;
        document.getElementById('selectedUserName').textContent = userName;
        document.getElementById('selectedUserStatus').textContent = 'Active conversation';
        document.getElementById('chatMessageInput').disabled = false;
        document.getElementById('sendMessageBtn').disabled = false;

        document.querySelectorAll('.chat-user-item').forEach(function (item) {
            item.classList.remove('active');
        });

        const selectedUser = document.getElementById(`chat-user-${userId}`);

        if (selectedUser) {
            selectedUser.classList.add('active');
        }

        clearUserUnread(userId);
        fetchMessages(userId);

        $.ajax({
            url: `/admin/chat/mark-as-read/${userId}`,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            }
        });
    }

    function fetchMessages(userId) {
        $.ajax({
            url: "{{ route('chat.chatdisplaybox') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                receiver_id: userId,
            },
            success: function (response) {
                const chatContent = document.getElementById('chatContent');
                chatContent.innerHTML = '';

                if (!response.specificChat || response.specificChat.length === 0) {
                    chatContent.innerHTML = '<div class="empty-chat">No messages yet. Start the conversation.</div>';
                    return;
                }

                response.specificChat.forEach(function (message) {
                    appendAdminMessage(message);
                });

                scrollAdminChatToBottom();
            },
            error: function () {
                alert('Could not load chat messages.');
            }
        });
    }

    function subscribeAdminChat() {
        if (adminChatSubscribed) {
            return;
        }

        if (!window.Echo) {
            console.log('Echo is not ready yet. Waiting...');
            setTimeout(subscribeAdminChat, 500);
            return;
        }

        if (!adminId) {
            console.error('Admin ID not found.');
            return;
        }

        adminChatSubscribed = true;

        console.log('Admin subscribed to channel:', `chat.${adminId}`);

        window.Echo.private(`chat.${adminId}`)
            .listen('.message.sent', function (data) {
                console.log('New message received by admin:', data);

                const message = data.message;
                const customerId = message.sender_id;

                createUserItemIfNotExists(message);
                updateUserLatestMessage(customerId, message.message_content, message);

                if (String(activeReceiverId) === String(customerId)) {
                    appendAdminMessage(message);
                    clearUserUnread(customerId);

                    $.ajax({
                        url: `/admin/chat/mark-as-read/${customerId}`,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        }
                    });
                } else {
                    markUserAsUnread(customerId, message);
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        subscribeAdminChat();

        document.getElementById('sendMessageBtn').addEventListener('click', function (event) {
            event.preventDefault();

            const messageInput = document.getElementById('chatMessageInput');
            const receiverId = document.getElementById('receiver_id').value;
            const messageText = messageInput.value.trim();

            if (!receiverId) {
                alert('Please select a customer first.');
                return;
            }

            if (!messageText) {
                return;
            }

            $.ajax({
                url: "{{ route('chat.sentmessage') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    receiverId: receiverId,
                    message_content: messageText,
                },
                success: function (message) {
                    appendAdminMessage(message);
                    updateUserLatestMessage(receiverId, message.message_content, message);
                    messageInput.value = '';
                },
                error: function () {
                    alert('Message could not be sent.');
                }
            });
        });

        document.getElementById('chatMessageInput').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                document.getElementById('sendMessageBtn').click();
            }
        });
    });
</script>
@endsection