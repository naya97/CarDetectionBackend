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
                'type' => 'Sedan',
                'model' => 'Lamborghini Hrocan',
                'owner_name' => 'أحمد المحمد'
            ],
            [
                'plate_number' => 'N894JV',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'دفع رباعي',
                'model' => 'BMW 8 Series',
                'owner_name' => 'رامي سعيد'
            ],
            [
                'plate_number' => 'L656XH',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'سيدان',
                'model' => 'Mercedes_Benz Mercedies_AMG GT',
                'owner_name' => 'سارة العلي'
            ],
            [
                'plate_number' => 'H644LX',
                'country_code' => 'Britich',
                'color' => 'أخضر',
                'type' => 'شاحنة',
                'model' => 'Lamborghini Aventodor',
                'owner_name' => 'نايا صالحة'
            ],
            [
                'plate_number' => 'L605HZ',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Audi RS 6',
                'owner_name' => 'نور  شاهين'
            ],
            [
                'plate_number' => 'MW51VSU',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Toyota Previa',
                'owner_name' => 'عمر ساهر'
            ],
            [
                'plate_number' => 'GX150GJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'شاحنة',
                'model' => 'BMW 5 Series',
                'owner_name' => 'زين أحمد'
            ],
            [
                'plate_number' => 'KH05ZZK',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Opei Astra',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'AP05JEO',
                'country_code' => 'Britich',
                'color' => 'فضي',
                'type' => 'شاحنة',
                'model' => 'Vauxhal Astra',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'WR02FKD',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
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
                'type' => 'شاحنة',
                'model' => 'Nissan Qashqai',
                'owner_name' => 'سليمان يوسف'
            ],
            [
                'plate_number' => 'NA54KGJ',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Porche',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'BG65USJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'شاحنة',
                'model' => 'Ford Trnsit',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'C52HYJ',
                'country_code' => 'Britich',
                'color' => 'أبيض',
                'type' => 'شاحنة',
                'model' => 'Volvo V70',
                'owner_name' => 'سليمان يوسف'
            ],
            [
                'plate_number' => 'EF10DZT',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Ford Fiesta',
                'owner_name' => 'سليمان يوسف'
            ],

            [
                'plate_number' => 'AK64DMV',
                'country_code' => 'Britich',
                'color' => 'أسود',
                'type' => 'شاحنة',
                'model' => 'Volkswagen Tiguan',
                'owner_name' => 'سليمان يوسف'
            ],

        ];

        $insertedVehicles = collect();

        foreach ($realVehiclesData as $data) {
            $vehicle = Vehicle::create($data);
            $insertedVehicles->push($vehicle);
        }

        $statuses = ['مسروقة', 'مطلوبة أمنياً', 'مخالفة مرورية', 'حجز احتياطي'];
        $priorities = ['عالي', 'متوسط', 'منخفض'];
        $blacklistedVehicles = $insertedVehicles->random(2);

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
