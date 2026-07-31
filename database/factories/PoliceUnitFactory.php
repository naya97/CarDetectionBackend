<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PoliceUnitFactory extends Factory
{
    private const LOCATIONS = [
        'طريق الملك فهد', 'طريق الملك عبدالله', 'الدائري الشرقي', 'الدائري الشمالي',
        'شارع التحلية', 'طريق الحرمين', 'مدخل المدينة الشمالي', 'بوابة الميناء',
        'تقاطع العليا', 'طريق المطار',
    ];

    public function definition(): array
    {
        return [
            'unit_code' => (string) fake()->unique()->numberBetween(1, 999),
            'location' => fake()->randomElement(self::LOCATIONS),
            'vehicle_number' => fake()->unique()->numberBetween(1, 50),
            'is_active' => fake()->boolean(60),
            'last_active_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
            'last_active_at' => fake()->dateTimeBetween('-2 hours', 'now'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
            'last_active_at' => fake()->dateTimeBetween('-30 days', '-2 days'),
        ]);
    }
}
