<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessAiResultJob;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiResultController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // TODO: Add internal API authentication (signature/token)
        $validated = $request->validate([
            'video_id' => 'required|integer|exists:videos,id',
            'processed_video_path' => 'nullable|string',
            'vehicles' => 'required|array',
            'vehicles.*.track_id' => 'required|integer',
            'vehicles.*.plate_number' => 'nullable|string',
            'vehicles.*.plate_confidence' => 'nullable|numeric',
            'vehicles.*.color' => 'nullable|string',
            'vehicles.*.color_confidence' => 'nullable|numeric',
            'vehicles.*.type' => 'nullable|string',
            'vehicles.*.type_confidence' => 'nullable|numeric',
            'vehicles.*.model' => 'nullable|string',
            'vehicles.*.make_model_confidence' => 'nullable|numeric',
            'vehicles.*.vehicle_image_path' => 'nullable|string',
        ]);

        $video = Video::findOrFail($validated['video_id']);

        if ($video->status !== 'processing') {
            Log::warning('AI result received for non-processing video: ' . $video->id);
            return response()->json(['message' => 'Video is not in processing state.'], 422);
        }

        dispatch(new ProcessAiResultJob($validated['video_id'], $validated));

        return response()->json(['message' => 'AI result accepted and queued for processing.']);
    }
}
