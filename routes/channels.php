<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId || (int) ($user->role ?? 0) === 2;
}, ['guards' => ['admin', 'web']]);