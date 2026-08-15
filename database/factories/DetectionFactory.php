<?php

namespace Database\Factories;

use App\Models\Detection;
use App\Models\Vehicle;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetectionFactory extends Factory
{
    protected $model = Detection::class;

    private const TYPES = ['سيدان', 'دفع رباعي', 'هاتشباك', 'شاحنة', 'كروس أوفر'];
    private const COLORS = ['أبيض', 'أسود', 'فضي', 'أحمر', 'أزرق', 'رمادي', 'أخضر', 'ذهبي'];

    public function definition(): array
    {
        $video = Video::inRandomOrder()->first() ?? Video::factory()->create();
        $isMatch = fake()->boolean(75);
        $vehicle = $isMatch ? Vehicle::inRandomOrder()->first() : null;

        // Generate AI values (may differ from DB for mismatch simulation)
        $aiColor = fake()->randomElement(self::COLORS);
        $aiType = fake()->randomElement(self::TYPES);
        $aiModel = fake()->randomElement([
            'تويوتا كامري',
            'هوندا أكورد',
            'نيسان ألتيما',
            'هيونداي سوناتا',
            'كيا سبورتاج',
            'مرسيدس C200',
            'بي إم دبليو X5',
            'لكزس ES'
        ]);

        // Calculate mismatches
        $colorMismatch = $vehicle ? (strtolower($aiColor) !== strtolower($vehicle->color)) : false;
        $typeMismatch = $vehicle ? (strtolower($aiType) !== strtolower($vehicle->type)) : false;
        $modelMismatch = $vehicle ? (strtolower($aiModel) !== strtolower($vehicle->model)) : false;

        // Calculate risk score
        $colorConf = fake()->randomFloat(2, 0.6, 0.98);
        $typeConf = fake()->randomFloat(2, 0.6, 0.98);
        $modelConf = fake()->randomFloat(2, 0.6, 0.98);

        $score = 0;
        if ($colorMismatch && $colorConf >= 0.50) $score += $colorConf * 1;
        if ($typeMismatch && $typeConf >= 0.50) $score += $typeConf * 3;
        if ($modelMismatch && $modelConf >= 0.50) $score += $modelConf * 4;

        $score = round($score, 2);

        // Determine severity
        $severity = null;
        $violationType = null;
        $message = null;

        if ($score >= 4) {
            $severity = 'عالي';
            $violationType = 'vehicle_mismatch';
        } elseif ($score >= 2) {
            $severity = 'متوسط';
            $violationType = 'vehicle_mismatch';
        } elseif ($score > 0) {
            $severity = 'منخفض';
            $violationType = 'vehicle_mismatch';
        }

        // Build message
        if ($violationType) {
            $parts = [];
            if ($colorMismatch) $parts[] = 'color';
            if ($typeMismatch) $parts[] = 'type';
            if ($modelMismatch) $parts[] = 'model';

            if (count($parts) === 1) {
                $message = 'Detected ' . $parts[0] . ' differs from the registered vehicle.';
            } elseif (count($parts) === 2) {
                $message = 'Detected ' . $parts[0] . ' and ' . $parts[1] . ' differ from the registered vehicle.';
            } elseif (count($parts) === 3) {
                $message = 'Detected ' . $parts[0] . ', ' . $parts[1] . ' and ' . $parts[2] . ' differ from the registered vehicle.';
            }
        }

        return [
            'video_id' => $video->id,
            'vehicle_id' => $vehicle?->id,
            'track_id' => fake()->numberBetween(1, 100),
            'detected_plate_number' => $vehicle?->plate_number ?? $this->generateRandomPlate(),
            'plate_confidence' => fake()->randomFloat(2, 0.70, 0.99),
            'detected_model' => $aiModel,
            'model_confidence' => $modelConf,
            'detected_type' => $aiType,
            'type_confidence' => $typeConf,
            'detected_color' => $aiColor,
            'color_confidence' => $colorConf,
            'vehicle_image_path' => "vehicles/{$video->id}/track_" . fake()->numberBetween(1, 50) . '.jpg',
            'plate_image_path' => "plates/{$video->id}/plate_" . fake()->numberBetween(1, 50) . '.jpg',
            'plate_match' => $vehicle !== null,
            'color_mismatch' => $colorMismatch,
            'type_mismatch' => $typeMismatch,
            'model_mismatch' => $modelMismatch,
            'plate_mismatch' => fake()->boolean(5), // 5% chance of blacklist match
            'risk_score' => $score,
            'severity' => $severity,
            'violation_type' => $violationType,
            'message' => $message,
            'detected_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    private function generateRandomPlate(): string
    {
        $letters = ['ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ر', 'ز', 'س', 'ش', 'ص', 'ط', 'ع', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
        $plateLetters = collect($letters)->random(3)->implode(' ');
        return "{$plateLetters} " . fake()->numberBetween(1, 9999);
    }
}
