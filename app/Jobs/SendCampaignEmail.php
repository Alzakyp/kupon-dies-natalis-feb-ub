<?php

namespace App\Jobs;

use App\Services\CampaignDelivery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCampaignEmail implements ShouldQueue
{
    use Queueable;
    public int $tries = 1;
    public function __construct(public int $recipientId) {}
    public function handle(CampaignDelivery $delivery): void { $delivery->send($this->recipientId); }
}
