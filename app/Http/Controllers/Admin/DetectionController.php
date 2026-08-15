<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Detection\DetectionDetailResource;
use App\Http\Resources\Video\VideoDetectionResource;
use App\Models\Detection;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class DetectionController extends Controller
{
    public function index(Video $video): JsonResponse
    {
        $detections = $video->detections()->with('vehicle')->get();

        return response()->json([
            'detections' => VideoDetectionResource::collection($detections),
        ]);
    }

    public function show(Detection $detection): JsonResponse
    {
        $detection->load(['video', 'vehicle']);

        return response()->json([
            'detection' => new DetectionDetailResource($detection),
        ]);
    }
}
