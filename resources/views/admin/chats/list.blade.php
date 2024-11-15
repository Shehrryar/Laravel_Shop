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

            <div class="chat-container">
                <!-- User List Section -->
                <div class="user-list">
                    @foreach ($allchatstoadmin as $userId => $chats)
                        @if (isset($chats['user_detail']))
                            <h4>{{ $chats['user_detail']['name'] }}</h4> <!-- Display the User's Name -->
                        @endif
                    @endforeach
                </div>

                <!-- Chat Box Section -->
                <div class="chat-box">
                    @foreach ($allchatstoadmin as $userId => $chats)
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

                    <!-- Input for sending new messages (example placeholder) -->
                    <div class="chat-input">
                        <input type="text" placeholder="Type a message..." />
                        <button type="button">Send</button>
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
</script>
@endsection