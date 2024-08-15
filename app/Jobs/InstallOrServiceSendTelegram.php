<?php

namespace App\Jobs;

use App\Telegram\Helpers\InstallOrServiceTelegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InstallOrServiceSendTelegram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $id;
    protected $groupId;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $id, $groupId, $data)
    {
        $this->type = $type;
        $this->id = $id;
        $this->groupId = $groupId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $text = InstallOrServiceTelegram::getSendText(1, $data);
//        InstallOrServiceTelegram::send(1, $installId, $groupId, $text);

        $text = InstallOrServiceTelegram::getSendText($this->type, $this->data);
        InstallOrServiceTelegram::send($this->type, $this->id, $this->groupId, $text);
    }

}
