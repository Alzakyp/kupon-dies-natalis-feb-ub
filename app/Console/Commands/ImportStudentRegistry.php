<?php

namespace App\Console\Commands;

use App\Models\StudentRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportStudentRegistry extends Command
{
    protected $signature = 'students:import {path} {--type=active_student}';
    protected $description = 'Import student registry from a UTF-8 CSV export';

    public function handle(): int
    {
        $type = (string) $this->option('type');
        if (!in_array($type, ['active_student', 'alumni'], true)) return $this->abortImport('Type must be active_student or alumni.');
        $handle = @fopen((string) $this->argument('path'), 'r');
        if (!$handle) return $this->abortImport('CSV cannot be opened.');
        $headers = array_map(fn ($v) => trim((string) $v), fgetcsv($handle) ?: []);
        $aliases = ['Nama' => ['Nama','NAMA'], 'Program Studi' => ['Program Studi','PRODI']];
        foreach ($aliases as $target => $choices) foreach ($choices as $choice) if (in_array($choice, $headers, true)) { $headers[array_search($choice, $headers, true)] = $target; break; }
        $required = ['NIM', 'Nama', 'JENJANG', 'Program Studi'];
        foreach ($required as $header) if (!in_array($header, $headers, true)) return $this->abortImport("Missing header: {$header}");
        $rows = []; $skipped = 0;
        while (($values = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, array_pad($values, count($headers), null));
            $nim = StudentRegistry::normalizeNim(ltrim(trim((string) $row['NIM']), "'\"="));
            if ($nim === '') { $skipped++; continue; }
            $rows[] = ['nim' => $nim, 'name' => trim((string) $row['Nama']), 'education_level' => trim((string) $row['JENJANG']), 'study_program' => trim((string) $row['Program Studi']) ?: null, 'registration_type' => $type, 'created_at' => now(), 'updated_at' => now()];
            if (count($rows) === 500) { $this->upsert($rows); $rows = []; }
        }
        fclose($handle); $this->upsert($rows);
        $this->info('Import complete; skipped '.$skipped.'.');
        return self::SUCCESS;
    }

    private function upsert(array $rows): void
    {
        if ($rows) DB::table('student_registries')->upsert($rows, ['nim', 'registration_type'], ['name', 'education_level', 'study_program', 'updated_at']);
    }

    private function abortImport(string $message): int { $this->error($message); return self::FAILURE; }
}
