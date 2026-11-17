<?php
namespace App\Console\Commands;
use App\Models\PendingRegistration;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class ResetTestRegistration extends Command {
 protected $signature='registration:reset-test {nim}';
 protected $description='Reset the fixed local test registration only';
 public function handle(): int {
  if (app()->environment('production') || $this->argument('nim') !== '2231730129') return $this->abortReset('Only local/devel test NIM is allowed.');
  $student=StudentRegistry::where('nim','2231730129')->first(); if(!$student) return $this->abortReset('Test student not found.');
  DB::transaction(function()use($student){ PendingRegistration::where('student_registry_id',$student->id)->delete(); Ticket::where('student_registry_id',$student->id)->whereHas('coupon',fn($q)=>$q->whereNull('redeemed_at'))->lockForUpdate()->get()->each(fn($ticket)=>$ticket->delete()); });
  $this->info('Test registration reset.'); return self::SUCCESS;
 }
 private function abortReset(string $message): int { $this->error($message); return self::FAILURE; }
}
