@extends('admin.layout.app')
@section('content') 
@endsection
@section('customjs') 
<script>
    window.onload = function () {
    console.log(window.Echo.connector.socket);  // Check if Echo is initialized

    // Make sure Echo and connector are properly initialized before accessing socket
    if (window.Echo && window.Echo.connector && window.Echo.connector.socket) {
        window.Echo.connector.socket.on('connect', () => {
            console.log("Connected to WebSocket.");
        });

        window.Echo.connector.socket.on('disconnect', (reason) => {
            console.log("Disconnected from WebSocket:", reason);
            // Attempt reconnect
            setTimeout(() => {
                console.log("Reconnecting...");
                window.Echo.connector.socket.connect();
            }, 3000);  // Try reconnecting every 3 seconds
        });

        window.Echo.connector.socket.on('connect_error', (error) => {
            console.error("Connection error:", error);
        });

        // Subscribe to the channel and listen for events
        window.Echo.channel("trades")
            .listen("NewTrade", (data) => {
                console.log("Trade received:", data);
            })
            .error((error) => {
                console.log("Error:", error);
            });
    } else {
        console.log("Echo or connector.socket is undefined. Ensure Echo is properly initialized.");
    }
};


</script>
@endsection