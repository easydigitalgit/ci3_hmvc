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

    public function sendChat($message = '', $chatId = '5031465184')
    {
        //$this->load->helper('telegram');
        $apiToken = '6315336303:AAFzlHry1JRRVlfsgdo-bNAuL1Xg_lWiado';
        $bot = new \TelegramBot\Api\BotApi($apiToken);

        if ($message) {
            $bot->sendMessage($chatId, $message);
        } else {
            echo json_encode(array('status' => '404', 'message' => 'no msg found'));
        }
    }
}
