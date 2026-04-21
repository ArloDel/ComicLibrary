<?php

namespace App\Jobs;

use App\Models\Comic;
use App\Models\Volume;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DownloadCoverImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public string $url;

    public function __construct(Comic|Volume $model, string $url)
    {
        $this->model = $model;
        $this->url = $url;
    }

    public function handle(): void
    {
        $uploadDir = 'uploads/covers';

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; RoninCollect/1.0)',
                'Accept'     => 'image/webp,image/apng,image/*,*/*;q=0.8',
            ])->timeout(30)->get($this->url);

            if ($response->successful()) {
                $ext = $this->extensionFromContentType($response->header('Content-Type'));
                $prefix = $this->model instanceof Comic ? 'comic' : 'vol';
                $filename = time() . "_api_{$prefix}_" . uniqid() . '.' . $ext;
                
                $dir = public_path($uploadDir);
                if (! file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                file_put_contents($dir . '/' . $filename, $response->body());

                $this->model->cover_image = $uploadDir . '/' . $filename;
                $this->model->save();
            } else {
                Log::warning("DownloadCoverImage failed for URL: {$this->url} with status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("DownloadCoverImage Exception for URL {$this->url}: " . $e->getMessage());
        }
    }

    private function extensionFromContentType(?string $contentType): string
    {
        if (!$contentType) return 'jpg';
        return match (true) {
            str_contains($contentType, 'png')  => 'png',
            str_contains($contentType, 'webp') => 'webp',
            str_contains($contentType, 'gif')  => 'gif',
            default                            => 'jpg',
        };
    }
}
