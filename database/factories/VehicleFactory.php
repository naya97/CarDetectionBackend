<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    private const OWNER_NAMES = [
        'أحمد محمد علي', 'محمد خالد الدوسري', 'سارة إبراهيم الحربي', 'ناصر عبدالعزيز',
        'عبدالله سليمان', 'يوسف ماجد', 'فاطمة خالد', 'علي بن حسين', 'منى عبدالرحمن',
        'خالد سعود العتيبي', 'ريم فهد القحطاني', 'عمر ياسر النعيمي', 'هند سالم الكعبي',
        'طارق حمد المري', 'لينا عادل السويدي',
    ];

    private const TYPES = ['سيدان', 'دفع رباعي', 'هاتشباك', 'شاحنة', 'كروس أوفر'];

    private const COLORS = ['أبيض', 'أسود', 'فضي', 'أحمر', 'أزرق', 'رمادي', 'أخرى'];

    private const COUNTRY_CODES = ['KSA', 'UAE', 'KWT', 'QAT', 'BHR', 'OMN'];

    private const MODELS = [
        'تويوتا كامري', 'هوندا أكورد', 'نيسان ألتيما', 'هيونداي سوناتا', 'كيا سبورتاج',
        'فورد إكسبلورر', 'شيفروليه تاهو', 'لكزس ES', 'مرسيدس C200', 'بي إم دبليو X5',
    ];

    public function definition(): array
    {
        return [
            'plate_number' => $this->generatePlateNumber(),
            'country_code' => fake()->randomElement(self::COUNTRY_CODES),
            'color' => fake()->randomElement(self::COLORS),
            'type' => fake()->randomElement(self::TYPES),
            'model' => fake()->randomElement(self::MODELS),
            'owner_name' => fake()->randomElement(self::OWNER_NAMES),
        ];
    }

    private function generatePlateNumber(): string
    {
        $letters = ['ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ر', 'ز', 'س', 'ش', 'ص', 'ط', 'ع', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
        $plateLetters = collect($letters)->random(3)->implode(' ');

        // unique() guarantees no collisions with vehicles.plate_number's unique constraint,
        // regardless of letter repeats
        $plateNumber = fake()->unique()->numberBetween(1, 999999);

        return "{$plateLetters} {$plateNumber}";
    }
}
