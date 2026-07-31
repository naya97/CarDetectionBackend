<?php

namespace Database\Factories;

use App\Models\PoliceUnit;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class DetectionFactory extends Factory
{
    private const TYPES = ['سيدان', 'دفع رباعي', 'هاتشباك', 'شاحنة', 'كروس أوفر'];
    private const COLORS = ['أبيض', 'أسود', 'فضي', 'أحمر', 'أزرق', 'رمادي', 'أخرى'];
    private const LOCATIONS = [
        'طريق الملك فهد', 'طريق الملك عبدالله', 'الدائري الشرقي', 'الدائري الشمالي',
        'شارع التحلية', 'طريق الحرمين', 'مدخل المدينة الشمالي', 'بوابة الميناء',
    ];

    // Cached once per seeding run (avoids one query per row for 1000s of detections)
    private static ?Collection $vehicles = null;
    private static ?array $policeUnitIds = null;

    public function definition(): array
    {
        $isMatch = fake()->boolean(85);
        $vehicle = $isMatch ? $this->vehiclesPool()->random() : null;

        return [
            'vehicle_id' => $vehicle?->id,
            'police_unit_id' => fake()->randomElement($this->policeUnitIdsPool()),
            'location' => fake()->randomElement(self::LOCATIONS),
            'detected_model' => $vehicle?->model ?? fake()->randomElement(['غير معروف', 'طراز غير مسجل']),
            'detected_color' => $vehicle?->color ?? fake()->randomElement(self::COLORS),
            'detected_type' => $vehicle?->type ?? fake()->randomElement(self::TYPES),
            'detected_plate_number' => $vehicle?->plate_number ?? $this->generateRandomPlate(),
            'confidence' => $isMatch
                ? fake()->randomFloat(2, 0.85, 0.99)
                : fake()->randomFloat(2, 0.40, 0.84),
            'match_status' => $isMatch ? 'match' : 'no_match',
            'detected_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'vehicle_image_path' => 'detections/vehicles/' . fake()->uuid() . '.jpg',
            'plate_image_path' => 'detections/plates/' . fake()->uuid() . '.jpg',
        ];
    }

    private function vehiclesPool(): Collection
    {
        return self::$vehicles ??= Vehicle::select('id', 'plate_number', 'color', 'type', 'model')->get();
    }

    private function policeUnitIdsPool(): array
    {
        return self::$policeUnitIds ??= PoliceUnit::pluck('id')->all();
    }

    private function generateRandomPlate(): string
    {
        $letters = ['ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ر', 'ز', 'س', 'ش', 'ص', 'ط', 'ع', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
        $plateLetters = collect($letters)->random(3)->implode(' ');

        return "{$plateLetters} " . fake()->numberBetween(1, 9999);
    }
}
