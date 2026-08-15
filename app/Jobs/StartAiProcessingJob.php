<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\Video\VideoResultService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StartAiProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Video $video) {}

    public function handle(): void
    {
        try {
            $aiServiceUrl = config('services.ai.url', 'http://localhost:8000');

            $videoPath = app(VideoResultService::class)->getInternalPath($this->video->original_video_path);

            $response = Http::timeout(30)->post($aiServiceUrl . '/process-video', [
                'video_id' => $this->video->id,
                'video_path' => $videoPath,  // C:/shared_storage/originals/1/original.mp4
            ]);
            if (!$response->successful()) {
                throw new \Exception('AI service returned error: ' . $response->body());
            }

            Log::info('AI processing started for video ' . $this->video->id);
        } catch (\Throwable $e) {
            Log::error('Failed to start AI processing for video ' . $this->video->id . ': ' . $e->getMessage());

            $this->video->update(['status' => 'failed']);
            throw $e;
        }
    }
}
