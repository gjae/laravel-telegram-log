# Installation and setup

#### Installing dependency via composer

```php
composer require gjae/laravel-telegram-log
```

Once you have installed this package, execute the following command at laravel command prompt:

```php
php artisan vendor:publish --provider="Gjae\TelegramLogChannel\Providers\TelegramChannelProvider"
```

It will create a file named ```config/telegram_channel.php```. It has the basic config. Now you will need to add a "chat ID" and a "bot api token" in this file.

# Quickstarter with telegram bots

Creation of new bots is managed by the BotFather.

Search __[@BotFather](https://t.me/BotFather)__ on telegram or click here: __[botfhater](https://t.me/BotFather)__.

Now, create a new bot by typing the command __/newbot__ into the BotFather chat box or choose it by clicking on the square button at the rigth corner of the chat box. Then, select "/newbot".  The name of your new bot must have the suffix "Bot", for example:__"laravel_log_bot", "LaravelBot"__. The BotFather will ask you a name and a username for your new bot (both of them must have the suffix "Bot").

finally, the __[@BotFather](https://t.me/BotFather)__ will send you a message like this: 

>> Done! Congratulations on your new bot. You will find it at __t.me/[YourUsernameBot]__. You can now add a description, about section and profile picture for your bot, see /help for a list of commands. By the way, when you've finished creating your cool bot, ping our Bot Support if you want a better username for it. Just make sure the bot is fully operational before you do this.
>> Use this token to access the HTTP API:
>> __[TOKEN]__
>> Keep your token secure and store it safely, it can be used by anyone to control your bot.
>> For a description of the Bot API, see this page: https://core.telegram.org/bots/api

GREAT, you have already created your first __telegram bot__.

Next, copy the token (the one that has the format XXXX:YYYYYYYY) and save it in a safe place.

# Usage

Open your ".env file" and search for the following lines and paste the Token and Telegram Id (the ones you had copied before) as values for the following variables: 

1.  __TELEGRAM_BOT_ACCESS_TOKEN=__ paste here your __SECRET BOT API TOKEN__ ., 
2. __TELEGRAM_CHAT_ID=__ paste here your chat ID


>> NOTE 1: Sometimes the ID value may have a "-" mark at the beginning; you should copy this symbol too.

>> NOTE 2: IF THE ID VALUE HAS ANY SYMBOL AT THE BEGINING, PUT THE ID VALUE INSIDE QUOTATION MARKS. Example: "-121412312"

next open the __config/logging.php__ file, search for the "channels" array and overwrite it like this:

```php
[
    ...
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['telegram', 'daily'],
        ],

        'telegram'  =>[
            'driver'  => 'monolog',
            'handler' => \Gjae\TelegramLogChannel\TelegramChannel::class,
            'level'   => 'error'
        ],

        ...
    ]
]

```

# How to get the chat_id value

You can make a request to the url: __[https://api.telegram.org/bot[YourBotAccessToken]/getUpdates](https://api.telegram.org/bot[YourBotAccessToken]/getUpdates)__ (change [YourBotAccessToken] by the "bot token" you have just gotten). Now you'll get a json like this:

```json
{
    "ok": true,
    "result": [
        {
            "update_id": 193532624,
            "message": {
                "message_id": 2,
                "from": {
                    "id": 259222478,
                    "is_bot": false,
                    "first_name": ....,
                    "last_name": ...,
                    "username": ...,
                    "language_code": ...
                },
                "chat": {
                    "id": 259222478,
                    "first_name": ....,
                    "last_name": ...,
                    "username": ...,
                    "type": "private"
                },
                "date": 1589138780,
                "text": "@channelusername",
                "entities": [
                    {
                        "offset": 0,
                        "length": 16,
                        "type": "mention"
                    }
                ]
            }
        },
    ]
}
```

# YOU'RE DONE!