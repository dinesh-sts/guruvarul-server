<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SplitSiblingsJson extends Command
{
    protected $signature = 'siblings:split';
    protected $description = 'Split JSON siblings data into separate columns';

    public function handle()
    {
        $records = DB::table('registers')->get();

        foreach ($records as $record) {
            // --- 1. Handle JSON splitting ---
            if (!empty($record->no_of_sisters) && is_string($record->no_of_sisters)) {
                $json = $record->no_of_sisters;
                $decoded = json_decode($json, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $noOfSisters = $decoded['noOfSisters'] ?? null;
                    $noOfBrothers = $decoded['noOfBrothers'] ?? null;

                    DB::table('registers')
                        ->where('id', $record->id)
                        ->update([
                            'no_of_sisters' => $noOfSisters,
                            'no_of_brothers' => $noOfBrothers,
                        ]);

                    $this->info("✅ Updated siblings for ID: {$record->id}");
                }
            }

            // --- 2. Handle name splitting ---
            if (!empty($record->firstname) && empty($record->lastname)) {
                $nameParts = explode(' ', trim($record->firstname), 2); // Limit to 2 parts

                $firstName = $nameParts[0] ?? null;
                $lastName = $nameParts[1] ?? null;

                DB::table('registers')
                    ->where('id', $record->id)
                    ->update([
                        'firstname' => $firstName,
                        'lastname' => $lastName,
                    ]);

                $this->info("👤 Updated name for ID: {$record->id} — $firstName $lastName");
            }
        }

        $this->info('🎉 All data updated successfully.');
    }
}
