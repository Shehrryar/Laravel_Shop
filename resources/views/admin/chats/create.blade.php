@extends('admin.layout.app')
@section('content') 
<h1 id="message_add"></h1>
@endsection
@section('customjs') 
<script>
    window.onload = function () {
        // Track if the listener is already set up
        let isListenerInitialized = false;

        window.Echo.connector.pusher.connection.bind('state_change', (states) => {
            console.log('Connection state:', states.current);

            // Initialize listener ONLY once when connected
            if (states.current === 'connected' && !isListenerInitialized) {
                initializeTradeListener();
                isListenerInitialized = true;
            }
        });
    };

    function initializeTradeListener() {
        window.Echo.channel("trades")
            .listen(".newTrade", (data) => {
                console.log("Received trade:", data); // Debug
                const messagesDiv = document.getElementById('message_add');

                // Use DOM methods instead of innerHTML for stability
                if (messagesDiv && data.trade) {
                    const messageElement = document.createElement('div');
                    messageElement.textContent = data.trade;
                    messagesDiv.appendChild(messageElement);
                }
            })
            .error((error) => {
                console.error("Channel error:", error);
            });
    }


    



</script>
@endsection