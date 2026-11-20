<?php

namespace App\Services;

use App\Jobs\SendCampaignEmail;
use App\Models\CampaignRecipient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CampaignDelivery
{
    public const LIMIT = 1800;

    public function dispatchBatch(): void
    {
        DB::transaction(function () {
            $control = DB::table('campaign_controls')->where('id',1)->lockForUpdate()->first();
            if (!$control->running) return;
            $used = DB::table('campaign_attempts')->where('attempted_at','>',now()->subDay())->count();
            $queued = CampaignRecipient::whereIn('status',['queued','sending'])->count();
            $slots = min(50, max(0, self::LIMIT - $used - $queued), max(0, 50 - $queued));
            if (!$slots) return;
            $recipients = CampaignRecipient::where(fn($q)=>$q->where('status','draft')->orWhere(fn($q)=>$q->where('status','failed')->where('attempts','<',3)->where('retry_at','<=',now())))->orderBy('id')->limit($slots)->lockForUpdate()->get();
            foreach ($recipients as $i=>$recipient) {
                $recipient->update(['status'=>'queued','queued_at'=>now()]);
                SendCampaignEmail::dispatch($recipient->id)->onConnection('database')->onQueue('campaign')->delay(now()->addSeconds($i*3))->afterCommit();
            }
            if ($recipients->isNotEmpty()) DB::table('campaign_controls')->where('id',1)->update(['last_batch_at'=>now()]);
        });
    }

    public function send(int $id): void
    {
        $attemptId = DB::transaction(function () use ($id) {
            $control = DB::table('campaign_controls')->where('id',1)->lockForUpdate()->first();
            $recipient = CampaignRecipient::lockForUpdate()->findOrFail($id);
            if ($recipient->status !== 'queued') return null;
            if (!$control->running || DB::table('campaign_attempts')->where('attempted_at','>',now()->subDay())->count() >= self::LIMIT) {
                $recipient->update(['status'=>'draft']);
                return null;
            }
            $recipient->update(['status'=>'sending','attempts'=>$recipient->attempts+1,'attempted_at'=>now()]);
            return DB::table('campaign_attempts')->insertGetId(['campaign_recipient_id'=>$id,'status'=>'sending','attempted_at'=>now()]);
        });
        if (!$attemptId) return;
        $recipient = CampaignRecipient::findOrFail($id);
        try {
            Mail::send('campaign.email',[],fn($m)=>$m->to($recipient->email)->subject('FEB UB Grand Fiesta — Fun Walk & FEB Unity Concert'));
        } catch (\Throwable $e) {
            $recipient->update(['status'=>'failed','retry_at'=>now()->addMinutes(5 ** $recipient->attempts),'last_error'=>class_basename($e).': SMTP send failed; inspect server log.']);
            DB::table('campaign_attempts')->where('id',$attemptId)->update(['status'=>'failed']);
            report($e);
            return;
        }
        // Do not automatically retry an interrupted send: SMTP acceptance may already have occurred.
        $recipient->update(['status'=>'sent','sent_at'=>now(),'last_error'=>null,'retry_at'=>null]);
        DB::table('campaign_attempts')->where('id',$attemptId)->update(['status'=>'sent']);
    }
}
