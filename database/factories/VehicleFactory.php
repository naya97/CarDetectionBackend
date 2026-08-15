<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    private const OWNER_NAMES = [
        'أحمد محمد علي',
        'محمد خالد الدوسري',
        'سارة إبراهيم الحربي',
        'ناصر عبدالعزيز',
        'عبدالله سليمان',
        'يوسف ماجد',
        'فاطمة خالد',
        'علي بن حسين',
        'منى عبدالرحمن',
        'خالد سعود العتيبي',
        'ريم فهد القحطاني',
        'عمر ياسر النعيمي',
        'هند سالم الكعبي',
        'طارق حمد المري',
        'لينا عادل السويدي',
        'سعد فهد العتيبي',
        'نورة عبدالله',
        'ماجد سالم',
        'هيثم يوسف',
        'ليلى أحمد',
    ];

    private const TYPES = ['سيدان', 'دفع رباعي', 'هاتشباك', 'شاحنة', 'كروس أوفر'];
    private const COLORS = ['أبيض', 'أسود', 'فضي', 'أحمر', 'أزرق', 'رمادي', 'أخضر', 'ذهبي'];
    private const COUNTRY_CODES = ['KSA', 'UAE', 'KWT', 'QAT', 'BHR', 'OMN'];
    private const MODELS = [
        'تويوتا كامري',
        'هوندا أكورد',
        'نيسان ألتيما',
        'هيونداي سوناتا',
        'كيا سبورتاج',
        'فورد إكسبلورر',
        'شيفروليه تاهو',
        'لكزس ES',
        'مرسيدس C200',
        'بي إم دبليو X5',
        'تويوتا لاند كروزر',
        'نيسان باترول',
        'هيونداي توسان',
        'كيا سورينتو',
        'مرسيدس G63',
        'أودي A6',
        'جيب رانجلر',
        'مازدا 6',
        'سوبارو فورستر',
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
        $plateNumber = fake()->unique()->numberBetween(1, 999999);
        return "{$plateLetters} {$plateNumber}";
    }
}
