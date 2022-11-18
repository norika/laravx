<?php

use Illuminate\Support\Facades\Request;

function activeMenu($uri)
{
    $active = null;
    if (Request::is($uri . "*")) {
        $active = 'active';
    }
    return $active;
}
