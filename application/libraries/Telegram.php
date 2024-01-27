<?php

use Telegram\Bot\TelegramClient;
use Telegram\BotApi;

class Telegram
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function sendChat($message = '', $chatId = '')
    {
        //$this->load->helper('telegram');
        $apiToken = $_ENV['TELEGRAM_TOKEN'];
        $bot = new \TelegramBot\Api\BotApi($apiToken);

        if ($message) {
            $bot->sendMessage($chatId, $message);
        } else {
            echo json_encode(array('status' => '404', 'message' => 'no msg found'));
        }
    }
}
