<?php

namespace App\Services\Video;

use App\Models\Video;

class VideoResultService
{
    /**
     * for ai
     */
    public function getInternalPath(string $relativePath): string
    {
        $base = config('filesystems.disks.shared.root', 'C:/shared_storage');
        return rtrim($base, '/') . '/' . ltrim($relativePath, '/');
    }

    /**
     * for frontend
     */
    public function getProcessedVideoUrl(Video $video): ?string
    {
        if (empty($video->processed_video_path)) {
            return null;
        }

        $baseUrl = config('filesystems.disks.shared.url', 'http://localhost/media');
        return rtrim($baseUrl, '/') . '/' . ltrim($video->processed_video_path, '/');
    }

    /**
     * for frontend
     */
    public function getVehicleImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        $baseUrl = config('filesystems.disks.shared.url', 'http://localhost/media');
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}
