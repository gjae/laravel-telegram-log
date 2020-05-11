# Install and setup

#### Install dependency via composer

```php
composer require gjae/laravel-telegram-log
```

Now you that been installed this package, execute the follow command on laravel:

```php
php artisan vendor:publish --provider="Gjae\TelegramLogChannel\Providers\TelegramChannelProvider"
```

Now you has a file named ```config/telegram_channel.php``` with basic config, you need add a chat ID and bot api token on this file.

# Quickstarter with telegram bots

The bot father is the charge of create new bots.
Search __[@BotFather](https://t.me/BotFather)__ into telegram or click here: __[botfhater](https://t.me/BotFather)__.

Now type the command __/newbot__ into BotFather chat or select this option to the right of field (bot options symbol); your new bot should has "bot" suffix in her name, for example:__"laravel_log_bot", "LaravelBot"__, the BotFather will ask a name and any username (both should has the kword "bot" as suffix).

In the finish the __[@BotFather](https://t.me/BotFather)__ will deliver you a message like this: 

>> Done! Congratulations on your new bot. You will find it at __t.me/[YourUsernameBot]__. You can now add a description, about section and profile picture for your bot, see /help for a list of commands. By the way, when you've finished creating your cool bot, ping our Bot Support if you want a better username for it. Just make sure the bot is fully operational before you do this.
>> Use this token to access the HTTP API:
>> __[TOKEN]__
>> Keep your token secure and store it safely, it can be used by anyone to control your bot.
>> For a description of the Bot API, see this page: https://core.telegram.org/bots/api

GREAT; now you own your first __telegram bot__.

Now copy her token (with the format XXXX:YYYYYYYY) and save safely way.

# Usage

Open yor file .env and make the next keys: 
1.  __TELEGRAM_BOT_ACCESS_TOKEN=__ and paste here your __SECRET BOT API TOKEN__ ., 
2. __TELEGRAM_CHAT_ID=__ paste here your chat ID

Now: open your file __config/logging.php__ and find the channels; add the next content:

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

You can a request to url: __[https://api.telegram.org/bot[YourBotAccessToken]/getUpdates](https://api.telegram.org/bot[YourBotAccessToken]/getUpdates)__ (change [YourBotAccessToken] by your own bot token) you'll see now a json like this:

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

Take the ID from the field  ...chat.id; copy and paste on the key __TELEGRAM_CHAT_ID=__ paste here your chat ID 

>> NOTE: Sometimes this ID can has a "-" symbol on the string start; you need copy too this symbol and paste on your __TELEGRAM_CHAT_ID=__ key

>> NOTE 2: IF THE ID HAS SOME SYMBOL ON HER START, USE QUOTE SYMBOL AROUND OF THE ID, example: "-121412312"

# YOU'LL READY NOW!