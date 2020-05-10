<?php

namespace Gjae\TelegramLogChannel;

use Config;
use Monolog\Logger;
use GuzzleHttp\Client;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Gjae\TelegramLogChannel\Exceptions\ConfigException;
use Gjae\TelegramLogChannel\Exceptions\ChatIdException;

class TelegramChannel extends AbstractProcessingHandler implements HandlerInterface
{

    private $bot_token = "";

    private $chat_id = "";

    private $initialized = false;

    private $client;

    private $app_name;

    public function __construct( $level = Logger::ERROR, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        if( !class_exists(Config::class) )
            throw new ConfigException( "Telegram config not found" );


        $this->setConfig( Config::get('telegram_channel') );

    }

    /**
     * Settea la configuración del chat para log
     *
     * @param array $config
     * @return void
     */
    protected function setConfig(array $config): void
    {
        $this->bot_token = $config['access_token'];

        $this->chat_id   = $config['chat_id'];

        $this->use_emoji = $config['default_emoji'];

        $this->app_name  = config('app.name');

    }

    /**
     * Verifica la configuración de los ID de chat
     * si el ID es un array de chats donde el mensaje sera enviado
     * entonces procesa el array
     *
     * @param array $record
     * @return void
     */
    protected function write(array $record): void
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        if( is_array( $this->chat_id ) )
            array_walk($this->chat_id, function($chat_id, $index) use(&$record){
                $this->sendMessageToChatId($chat_id, $record['message'],  $record['level']);
            } );
        else
            $thi->sendMessageToChatId( $this->chat_id, $record['message'], $record['level'] );
        
    }

    /**
     * Envia el mensaje a un chat en especifico segun su ID
     *
     * @param string $chat_id
     * @param string $message
     * @param string $level
     * @return void
     */
    private  function sendMessageToChatId(string $chat_id, string $message, string $level = 'debug' ): void
    {

        if( is_null( $chat_id ) || empty($chat_id) )
            throw new ChatIdException( "The telegram CHATID not found, please add one" );

        

        $this->client->request('POST', sprintf('https://api.telegram.org/bot%s/sendMessage',$this->bot_token ), [
            'form_params'   => [
                'chat_id'   => $chat_id,
                'text'      => sprintf( $this->getEmojiByRecordLevel($level)." [%s]: %s " ,$this->app_name, $message )
            ]
        ]);
    }

    private function getEmojiByRecordLevel( string $level )
    {
        $levels = config('telegram_channel.level_log_emojis');

        if( array_key_exists( $level, $levels ) && !empty( $levels[$level] ) && !\is_null( $levels[ $level ] ) )
            return $levels[ $level ];

        return config('telegram_channel.default_emoji', '');
    }

    private function initialize()
    {

        $this->client = new Client();

        $this->initialized = true;
    }
}