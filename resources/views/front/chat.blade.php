<div id="chat-box">
    <!-- Messages will be appended here -->
</div>

<input type="text" id="message-input" placeholder="Type a message...">
<button onclick="sendMessage()">Send</button>

<script>
function fetchMessages(receiverId) {
    $.ajax({
        url: `/fetch-messages/${receiverId}`,
        type: 'GET',
        success: function(messages) {
            $('#chat-box').html('');
            messages.forEach(function(message) {
                $('#chat-box').append(`<p>${message.message_content}</p>`);
            });
        }
    });
}



function sendMessage() {
    const messageContent = $('#message-input').val();
    const receiverId = 1; // Set this dynamically based on chat session
    event.preventDefault();
    $.ajax({
        url: "{{ route('send.message') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            receiver_id: receiverId,
            message_content: messageContent
        },
        success: function(message) {
            $('#chat-box').append(`<p>${message.message_content}</p>`);
            $('#message-input').val(''); // Clear input
        }
    });
}

// Set an interval to fetch messages periodically
setInterval(function() {
    fetchMessages(1); // Replace 1 with the receiver ID dynamically
}, 5000);
</script>
