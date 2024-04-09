<?php

return [
    'page_id' => env('FACEBOOK_PAGE_ID'),
    // Query page_access_token from the cache Cache::get('page_access_token')
    'user_access_token' => env('FACEBOOK_USER_ACCESS_TOKEN'),
];
