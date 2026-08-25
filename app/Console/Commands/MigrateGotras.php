<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MigrateGotras extends Command
{
    protected $signature = 'gotras:migrate';
    protected $description = 'Migrate gotra names from registers to gotras table';

    public function handle()
    {
        $gotras = DB::table('registers')
            ->whereNotNull('gotra') // Ensure gotra field is not null
            ->select('gotra')
            ->distinct()
            ->pluck('gotra');

        foreach ($gotras as $gotraName) {
            // Skip empty values
            $gotraName = trim($gotraName);
            if ($gotraName === '') {
                continue;
            }

            $exists = DB::table('gotras')->where('gotra_name', $gotraName)->exists();

            if (!$exists) {
                DB::table('gotras')->insert([
                    'gotra_name' => $gotraName,
                    'status' => 'APPROVED',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                $this->info("✅ Inserted: $gotraName");
            } else {
                $this->warn("⚠️ Already exists: $gotraName");
            }
        }

        $this->info('🎉 Migration of gotras completed.');
    }
}
