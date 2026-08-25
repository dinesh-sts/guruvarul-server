<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DownloadProfileImages extends Command
{
    protected $signature = 'images:download';
    protected $description = 'Download and assign profile images per user based on profileId.';

    public function handle()
    {
        $folder = 'public/userImages/';
        if (!Storage::exists($folder)) {
            Storage::makeDirectory($folder);
        }

        $client = new Client(['verify' => false]);
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6', 'photo7', 'photo8'];

        // Get all distinct profile IDs
        $userIds = DB::table('profile_images')->select('profileId')->distinct()->pluck('profileId');

        foreach ($userIds as $userId) {
            $registerId = $userId;
            $images = DB::table('profile_images')->where('profileId', $userId)->get();

            $photoSlotIndex = 0;
            $updateData = ['updated_at' => now()];
            $usedPhotos = [];

            foreach ($images as $image) {
                $uri = $image->uri;
                $type = $image->type;

                $decodedPath = urldecode(parse_url($uri, PHP_URL_PATH));
                $originalFilename = basename($decodedPath);
                $finalFilename = $this->generateUniqueFilename($folder, $originalFilename);
                $storagePath = $folder . $finalFilename;

                try {
                    $fileContent = $this->fetchFileContent($client, $uri);
                    if ($fileContent === false) {
                        $this->error("❌ Failed to download: {$uri}");
                        continue;
                    }

                    Storage::put($storagePath, $fileContent);
                    $this->info("✅ Downloaded: {$finalFilename}");

                    if ($type === 'profile') {
                        if ($photoSlotIndex < count($photoFields)) {
                            $field = $photoFields[$photoSlotIndex];
                            $updateData[$field] = $finalFilename;
                            $usedPhotos[] = $field;
                            $photoSlotIndex++;
                        } else {
                            $this->warn("⚠️ All 8 photo slots used for register ID {$registerId}. Skipping extra image.");
                        }
                    } elseif ($type === 'horoscope') {
                        $updateData['hor_photo'] = $finalFilename;
                    } else {
                        $this->warn("⚠️ Unknown image type '{$type}' for profile ID {$userId}");
                    }
                } catch (\Exception $e) {
                    $this->error("❌ Error for profile ID {$userId}: " . $e->getMessage());
                }
            }

            // Set remaining photo fields to null
            foreach ($photoFields as $field) {
                if (!in_array($field, $usedPhotos)) {
                    $updateData[$field] = null;
                }
            }

            // Apply update
            DB::table('registers')->where('id', $registerId)->update($updateData);
            $this->info("📝 Updated register ID {$registerId} with images.");
        }

        $this->info("🎉 All users processed successfully.");
    }

    /**
     * Download file from remote URL.
     */
    private function fetchFileContent(Client $client, string $url)
    {
        try {
            $response = $client->get($url, ['stream' => true]);
            return $response->getStatusCode() === 200 ? $response->getBody()->getContents() : false;
        } catch (RequestException $e) {
            return false;
        }
    }

    /**
     * Ensure filename is unique in storage.
     */
    private function generateUniqueFilename(string $folder, string $filename)
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $counter = 1;

        $uniqueFilename = $filename;
        while (Storage::exists($folder . $uniqueFilename)) {
            $uniqueFilename = $name . '_' . $counter . '.' . $ext;
            $counter++;
        }

        return $uniqueFilename;
    }
}
