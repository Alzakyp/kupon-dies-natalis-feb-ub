<?php

namespace App\Console\Commands;

use App\Models\CampaignRecipient;
use Illuminate\Console\Command;

class ImportCampaignRecipients extends Command
{
    protected $signature = 'campaign:import-recipients {path}';
    protected $description = 'Import campaign recipient CSV. Does not send email.';

    public function handle(): int
    {
        $file = @fopen($this->argument('path'), 'r');
        if (!$file) { $this->error('CSV cannot be opened.'); return self::FAILURE; }
        $headers = array_map(fn ($v) => trim((string) $v), fgetcsv($file) ?: []);
        $required = ['NIM', 'NAMA', 'EMAIL', 'EMAIL UB'];
        foreach ($required as $field) if (!in_array($field, $headers, true)) { $this->error("Missing header: {$field}"); return self::FAILURE; }
        $index = array_flip($headers); $rows = 0; $valid = 0; $invalid = 0;
        while (($values = fgetcsv($file)) !== false) {
            $rows++; $row = array_pad($values, count($headers), '');
            $ub = trim((string) ($row[$index['EMAIL UB']] ?? ''));
            $other = trim((string) ($row[$index['EMAIL']] ?? ''));
            $email = filter_var($ub, FILTER_VALIDATE_EMAIL) ? $ub : (filter_var($other, FILTER_VALIDATE_EMAIL) ? $other : null);
            if (!$email) { $invalid++; continue; }
            CampaignRecipient::updateOrCreate(['email' => strtolower($email)], ['nim' => trim((string) ($row[$index['NIM']] ?? '')) ?: null, 'name' => trim((string) ($row[$index['NAMA']] ?? '')) ?: null, 'status' => 'draft']);
            $valid++;
        }
        fclose($file);
        $this->info("Rows: {$rows}; valid email rows: {$valid}; skipped invalid: {$invalid}; unique recipients: ".CampaignRecipient::count().'. No email was sent.');
        return self::SUCCESS;
    }
}
