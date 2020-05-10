<?php

return [

    'access_token'      => env('TELEGRAM_BOT_ACCESS_TOKEN', null),

    /**
     * Integer or string: represent a chat id to sent the
     * log message
     * 
     */
    'chat_id'           => env('TELEGRAM_CHAT_ID', null),


    'default_emoji'     => "💣",

    'level_log_emojis'  => [

        // EMERGENCY
        '600'     => "🚨",

        // ALERT
        '550'         => "⚠",

        // CRITICAL
        '500'      => "ℹ",

        // ERROR
        '400'         => "💣",

        // WARNING
        '300'       => "⚱",

        // INFO
        '200'          => "⚔",

        // DEBUG
        '100'         => "🐛"

    ]
];