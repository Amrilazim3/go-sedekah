<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('donation', function () {
    return true;
});