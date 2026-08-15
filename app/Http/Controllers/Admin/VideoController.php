<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoListResource;
use App\Http\Resources\Video\VideoResource;
use App\Http\Resources\Video\VideoSummaryResource;
use App\Models\Video;
use App\Services\Video\VideoListingService;
use App\Services\Video\VideoService;
use App\Services\Video\VideoSummaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService,
        private VideoSummaryService $videoSummaryService,
        private VideoListingService $listingService,
    ) {}

    /**
     * List all videos with pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $videos = $this->listingService->paginate(
            filters: $request->only(['status', 'search']),
            perPage: (int) $request->query('per_page', 15)
        );

        return response()->json([
            'videos' => VideoListResource::collection($videos),
            'pagination' => [
                'current_page' => $videos->currentPage(),
                'last_page' => $videos->lastPage(),
                'per_page' => $videos->perPage(),
                'total' => $videos->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'original_path' => 'required|string',
            'name' => 'required|string',
            'duration' => 'nullable|numeric',
            'size' => 'required|integer',
        ]);

        $video = $this->videoService->createAndStartProcessing(
            $validated['original_path'],
            $validated['name'],
            $validated['duration'] ?? null,
            $validated['size']
        );

        return response()->json([
            'message' => 'Video processing started.',
            'video' => new VideoResource($video),
        ], 201);
    }

    public function show(Video $video): JsonResponse
    {
        return response()->json([
            'video' => new VideoSummaryResource($video),
        ]);
    }

    public function processedVideo(Video $video): JsonResponse
    {
        $url = app(\App\Services\Video\VideoResultService::class)->getProcessedVideoUrl($video);

        if ($url === null) {
            return response()->json(['message' => 'Processed video not available yet.'], 404);
        }

        return response()->json(['url' => $url]);
    }
}
