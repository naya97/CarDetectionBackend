<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Blacklist;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $realVehiclesData = [
            [
                'plate_number' => 'R183JF',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'sports',
                'model' => 'Lamborghini	Huracan',
                'owner_name' => 'أحمد المحمد'
            ],
            [
                'plate_number' => 'N894JV',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'sports ',
                'model' => 'BMW	8 Series',
                'owner_name' => 'رامي سعيد'
            ],
            [
                'plate_number' => 'L656XH',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'sports',
                'model' => 'Mercedes-Benz	Mercedes-AMG GT',
                'owner_name' => 'سارة العلي'
            ],
            [
                'plate_number' => 'H644LX',
                'country_code' => 'Britich',
                'color' => 'أخضر',
                'type' => 'sports',
                'model' => 'Lamborghini	Aventador',
                'owner_name' => 'نايا صالحة'
            ],
            [
                'plate_number' => 'L605HZ',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'hatchback',
                'model' => 'Audi	RS 6',
                'owner_name' => 'نور  شاهين'
            ],
            [
                'plate_number' => 'MW51VSU',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'MPV',
                'model' => 'Toyota Previa',
                'owner_name' => 'عمر ساهر'
            ],
            [
                'plate_number' => 'GX150GJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'sedan',
                'model' => 'BMW 5 Series',
                'owner_name' => 'زين أحمد'
            ],
            [
                'plate_number' => 'KH05ZZK',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'sedan',
                'model' => 'Opel Astra',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'AP05JEO',
                'country_code' => 'Britich',
                'color' => 'فضي',
                'type' => 'hatchback',
                'model' => 'Vauxhall Astra',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'WR02FKD',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'sedan',
                'model' => 'BMW 5 Series',
                'owner_name' => 'سارة صالحة'
            ],
            [
                'plate_number' => 'AV08HVF',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'شاحنة',
                'model' => 'Honda',
                'owner_name' => 'سليمان يوسف'
            ],
            [
                'plate_number' => 'EY61NBG',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'suv',
                'model' => 'Nissan Qashqai',
                'owner_name' => 'سليمان يوسف'
            ],
            [
                'plate_number' => 'NA54KGJ',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Smart Roadster',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'BG65USJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'minibus',
                'model' => 'Ford Transit',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'C52HYJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'seda',
                'model' => 'Volvo V70',
                'owner_name' => 'سليمان يوسف'
            ],
            [
                'plate_number' => 'EF10DZT',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'MPV',
                'model' => 'Ford Fiesta',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'AK64DMV',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'suv',
                'model' => 'Volkswagen Tiguan',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'K884RS',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'SUV',
                'model' => 'Volkswagen Tiguan',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'AF65JKV',
                'country_code' => 'Britich',
                'color' => 'أزرق',
                'type' => 'hatchback',
                'model' => 'Ford Fiesta',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'KH06KSU',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'MPV',
                'model' => 'Citroen C4',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'LN15ZZC',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'hatchback',
                'model' => 'Toyota	Auris',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'DA07CLX',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'hatchback',
                'model' => 'Mazda 6',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'WG65ZFX',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'sedan',
                'model' => 'Volvo V60',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'WG65ZFX',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'minibus',
                'model' => 'Ford Transit',
                'owner_name' => 'علاء الأمين '
            ],
            [
                'plate_number' => 'CE61WYL',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'MPV',
                'model' => 'Volkswagen Caddy',
                'owner_name' => 'علاء الأمين '
            ],

        ];

        $insertedVehicles = collect();

        foreach ($realVehiclesData as $data) {
            $vehicle = Vehicle::create($data);
            $insertedVehicles->push($vehicle);
        }

        $statuses = ['مسروقة', 'مطلوبة أمنياً', 'مخالفة مرورية', 'حجز احتياطي'];
        $priorities = ['عالي', 'متوسط', 'منخفض'];
        $thirdCount = (int) ceil($insertedVehicles->count() / 3);
        $blacklistedVehicles = $insertedVehicles->random($thirdCount);

        foreach ($blacklistedVehicles as $vehicle) {
            Blacklist::create([
                'vehicle_id' => $vehicle->id,
                'status' => fake()->randomElement($statuses),
                'priority' => fake()->randomElement($priorities),
                'wanted' => true,
            ]);
        }
    }
}
