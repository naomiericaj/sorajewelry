<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SyncDatabase extends Command
{
    protected $signature = 'sync:run {--dry-run}';
    protected $description = 'Bidirectional application-level sync between local and server';

    public function handle()
    {
        $peerUrl = rtrim(config('sync.peer_url'), '/');
        $token = config('sync.token');
        $tables = config('sync.tables');

        if (!$peerUrl || !$token) {
            $this->error('SYNC_PEER_URL or SYNC_TOKEN is missing.');
            return Command::FAILURE;
        }

        foreach ($tables as $table) {
            $this->info("Syncing {$table}...");

            $this->prepareUuids($table);

            $localRows = DB::table($table)->get();

            if ($this->option('dry-run')) {
                $this->line("Dry run: {$table} has {$localRows->count()} local rows.");
                continue;
            }

            $push = Http::withToken($token)
                ->timeout(30)
                ->post($peerUrl . '/sync/push', [
                    'table' => $table,
                    'rows' => $localRows,
                ]);

            if (!$push->successful()) {
                $this->error("Push failed for {$table}: " . $push->body());
                continue;
            }

            $pull = Http::withToken($token)
                ->timeout(30)
                ->post($peerUrl . '/sync/pull', [
                    'table' => $table,
                    'since' => null,
                ]);

            if (!$pull->successful()) {
                $this->error("Pull failed for {$table}: " . $pull->body());
                continue;
            }

            $rows = $pull->json('rows', []);

            foreach ($rows as $row) {
                $row = (array) $row;

                if (empty($row['uuid'])) {
                    continue;
                }

                unset($row['id']);

                DB::table($table)->updateOrInsert(
                    ['uuid' => $row['uuid']],
                    $row
                );
            }

            $this->info("Finished {$table}.");
        }

        return Command::SUCCESS;
    }

    private function prepareUuids(string $table): void
    {
        $rows = DB::table($table)
            ->whereNull('uuid')
            ->get();

        foreach ($rows as $row) {
            DB::table($table)
                ->where('id', $row->id)
                ->update([
                    'uuid' => (string) Str::uuid(),
                    'sync_updated_at' => now(),
                    'sync_origin' => config('sync.role'),
                ]);
        }
    }
}