<?php
namespace App\Telegram\Core;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    private ?string $api;
    private ?string $token;

    public function __construct(
        public Http $http
    ) {
        $this->api = config('telegram.api');
        $this->token = config('telegram.token');
    }

    public function send(string $method, array $data)
    {
        return $this->http::post($this->api.$this->token."/". $method, $data);
    }


    public function sendMessage(int $chatId, string $text)
    {
        return $this->send('sendMessage', [
            'chat_id'    => $chatId,
            'text'       => $text,
            'parse_mode' => 'HTML'
        ]);
    }

    public function editMessage(array $content)
    {
        return $this->send('editMessageText', $content);
    }


    public function answerCallbackQuery(array $data)
    {
        $url = $this->api.$this->token."/answerCallbackQuery";

        $callbackData = [
            'callback_query_id'	=> $this->CallbackID($data),
            'show_alert'	=> false,
            'text'          => ''
        ];

        return $this->sendAPIRequest($url, $callbackData);
    }

    private function sendAPIRequest(string $url, array $content, bool $post = true, bool $sslVerify = false): string
    {
        // Append query parameters to the URL if they exist
        if (isset($content['chat_id'])) {
            $url .= '?' . http_build_query(['chat_id' => $content['chat_id']]);
            unset($content['chat_id']);
        }

        $ch = curl_init();

        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => $sslVerify
        ]);

        // Set POST options if necessary
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }

        // Execute cURL request and handle errors
        $result = curl_exec($ch);
        if ($result === false) {
            $result = json_encode([
                'ok' => false,
                'curl_error_code' => curl_errno($ch),
                'curl_error' => curl_error($ch)
            ]);
        }

        curl_close($ch);

        return $result;
    }


    public function emoji(string $emoji)
    {
        $array = [
            'phone' => json_decode('"\ud83d\udcf1"'),
            'ok'    => json_decode('"\uD83C\uDD97"'),
            'icon_error' => json_decode('"\u26a0"'),
            'back'  => json_decode('"\u2b05"'),
            'done'  => json_decode('"\u2705"'),
            'no'    => json_decode('"\u26d4\ufe0f"'),
        ];
        return $array[$emoji];
    }

    public function sendDocument(int $chatId, object $file, int|null $replyId = null)
    {
        return $this->http::attach('document', Storage::get('/public/'.$file), 'document.jpg')
            ->post($this->api . $this->token . '/sendDocument', [
                'chat_id' => $chatId,
            ]);
    }


    public function sendButtons(int $chatId, string $text, array $button)
    {
        return $this->send('sendMessage', [
            'chat_id'      => $chatId,
            'text'         => $text,
            'parse_mode'   => 'HTML',
            'reply_markup' => $button,
        ]);
    }

    public function editButton(int $chatId, string $text, array $button, int $messageId)
    {
        return $this->send('sendMessageText', [
            'chat_id'      => $chatId,
            'text'         => $text,
            'reply_markup' => $button,
            'parse_mode'   => 'HTML',
            'message_id'   => $messageId
        ]);
    }


    public function sendSharePhoneBtn(int $chatId, string $firstName)
    {
        $text = "Assalomu alaykum <b>$firstName</b> botga hush kelibsiz.\nIltimos telefon raqamingizni kiriting!\nMisol uchun: +998990885544";

        $reply_markup = array(
            'keyboard' => [[[ 'text' => $this->emoji('phone').' Telefon raqamni jo\'natish', 'request_contact' => true ]]],
            'one_time_keyboard' => false,
            'resize_keyboard' => true,
            'selective' => false
        );

        $this->send('sendMessage', [
            'chat_id'   => $chatId,
            'text'      => $text,
            'parse_mode'=> 'HTML',
            'reply_markup' => json_encode($reply_markup, true),
        ]);
    }


    public function removeSharePhoneBtn(int $chatId, string $firstName)
    {
        $text = $firstName . " siz <b>Hikvision</b> hodimisiz,\nsizga ish vazifalaringiz eslatib turiladi.";
        $reply_markup = json_encode(['remove_keyboard' => true]);

        return $this->send('sendMessage', [
            'chat_id'      => $chatId,
            'text'         =>  $text,
            'parse_mode'   => 'HTML',
            'reply_markup' => $reply_markup,
        ]);
    }


    // send_task_end_inline_keyboard btn
    public function send_task_end_inline_keyboard_btn(object $task, int $this_day)
    {
        $text_yes = $this->emoji('done') . " Bajarildi";
        $text_no = $this->emoji('no') . " Bajarilmadi";


        $reply_markup = array(
            'inline_keyboard' =>
                [
                    [
                        ['text' => $text_yes, 'callback_data' => "$task->task_id:1"],
                        ['text' => $text_no, 'callback_data' => "$task->task_id:-1"]
                    ]
                ]
        );


        if (($this_day != $task->day_off1 && $this_day != $task->day_off2) && $task->rule != 'ADMIN')
            $this->send('sendMessage', [
                'chat_id'   => $task->chat_id,
                'text'      => $task->name,
                'parse_mode'=> 'HTML',
                'reply_markup' => json_encode($reply_markup, true),
            ]);

    }


    public function CallbackID(array $data) {
        if (isset($data["callback_query"]["id"]))
            return $data["callback_query"]["id"];
        return 0;
    }

    public function CallbackData(array $data): ?array
    {
        return $data['callback_query']['data'] ?? null;
    }

    public function getCallbackMessage(array $data): ?string
    {
        return $data['callback_query']['message'] ?? null;
    }

    public function CallbackMessageID(array $data): ?int
    {
        return $data["callback_query"]["message"]['message_id'] ?? null;
    }

    public function CallbackMessageDate(array $data): ?string
    {
        return $data['callback_query']['message']['date'] ?? null;
    }

    public function CallbackChatID(array $data): ?int
    {
        return $data["callback_query"]["message"]["chat"]["id"]?? null;
    }

}
