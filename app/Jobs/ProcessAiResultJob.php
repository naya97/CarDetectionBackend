<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\Detection\DetectionProcessingService;
use App\Services\Video\VideoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessAiResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $videoId,
        public array $payload
    ) {}

    public function handle(
        DetectionProcessingService $detectionService,
        VideoService $videoService
    ): void {
        DB::beginTransaction();

        try {
            $video = Video::findOrFail($this->videoId);

            $video->update([
                'processed_video_path' => $this->payload['processed_video_path'] ?? null,
            ]);

            $totalVehicles = count($this->payload['vehicles'] ?? []);
            $violations = ['high' => 0, 'medium' => 0, 'low' => 0];

            $severityMap = [
                'عالي' => 'high',
                'متوسط' => 'medium',
                'منخفض' => 'low',
            ];

            foreach ($this->payload['vehicles'] ?? [] as $aiVehicle) {
                $detection = $detectionService->processVehicle($aiVehicle, $video);

                if ($detection->violation_type !== null && $detection->severity !== null) {
                    $mappedSeverity = $severityMap[$detection->severity] ?? null;

                    if ($mappedSeverity !== null && array_key_exists($mappedSeverity, $violations)) {
                        $violations[$mappedSeverity]++;
                    }
                }
            }

            $totalViolations = array_sum($violations);

            $videoService->updateCounters($video, [
                'total_vehicles' => $totalVehicles,
                'total_violations' => $totalViolations,
                'high_violations' => $violations['high'],
                'medium_violations' => $violations['medium'],
                'low_violations' => $violations['low'],
            ]);

            $videoService->updateStatus($video, 'completed');

            DB::commit();

            Log::info('AI result processed for video ' . $this->videoId);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Failed to process AI result for video ' . $this->videoId . ': ' . $e->getMessage());

            if (isset($video)) {
                $video->update(['status' => 'failed']);
            }

            throw $e;
        }
    }
}
