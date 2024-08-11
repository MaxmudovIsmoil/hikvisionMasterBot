<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSEController extends Controller
{
    public function installNotification()
    {
//        $notification = Notification::where([
//            'direction_id' => auth()->user()->just_created_visit->direction_id,
//            'type' => Notification::TYPE_ORDERFIELD,
//            'user_id' => auth()->user()->id,
//            'sent' => false
//        ])->first();
//        $this->sendData('notification', $notification);
//        if ($notification) {
//            $notification->sent = true;
//            $notification->save();
//        }
        $this->sendData('notification', 123);
    }

    public function serviceNotification()
    {
//        $notification = Notification::where([
//            'direction_id' => auth()->user()->just_created_visit->direction_id,
//            'type' => Notification::TYPE_ORDERFIELD,
//            'user_id' => auth()->user()->id,
//            'sent' => false
//        ])->first();
//        $this->sendData('notification', $notification);
//        if ($notification) {
//            $notification->sent = true;
//            $notification->save();
//        }
    }


    public function sendOrderFieldNotifications(): void
    {
        $notification = Notification::where([
            'direction_id' => auth()->user()->just_created_visit->direction_id,
            'type' => Notification::TYPE_ORDERFIELD,
            'user_id' => auth()->user()->id,
            'sent' => false
        ])->first();
        $this->sendData('notification', $notification);
        if ($notification) {
            $notification->sent = true;
            $notification->save();
        }
    }

    private function sendData($key, $value): void
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        if ($value) {
            $eventData = [
                $key => $value
            ];
            echo "data:" . json_encode($eventData) . "\n\n";
        }
        else {
            echo "\n\n";
        }
        ob_flush();
        flush();
    }

}
