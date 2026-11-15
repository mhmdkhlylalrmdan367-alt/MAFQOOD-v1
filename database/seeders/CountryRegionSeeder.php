<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Seeder;

class CountryRegionSeeder extends Seeder
{
    public function run(): void
    {
        $syria = Country::updateOrCreate(
            ['code' => 'SYR'],
            ['name_ar' => 'سوريا', 'name_en' => 'Syria', 'phone_code' => '+963']
        );

        $regions = [
            ['name_ar' => 'دمشق', 'name_en' => 'Damascus'],
            ['name_ar' => 'ريف دمشق', 'name_en' => 'Rif Dimashq'],
            ['name_ar' => 'حلب', 'name_en' => 'Aleppo'],
            ['name_ar' => 'حمص', 'name_en' => 'Homs'],
            ['name_ar' => 'حماة', 'name_en' => 'Hama'],
            ['name_ar' => 'اللاذقية', 'name_en' => 'Latakia'],
            ['name_ar' => 'طرطوس', 'name_en' => 'Tartus'],
            ['name_ar' => 'إدلب', 'name_en' => 'Idlib'],
            ['name_ar' => 'دير الزور', 'name_en' => 'Deir ez-Zor'],
            ['name_ar' => 'الرقة', 'name_en' => 'Raqqa'],
            ['name_ar' => 'الحسكة', 'name_en' => 'Al-Hasakah'],
            ['name_ar' => 'درعا', 'name_en' => 'Daraa'],
            ['name_ar' => 'السويداء', 'name_en' => 'As-Suwayda'],
            ['name_ar' => 'القنيطرة', 'name_en' => 'Quneitra'],
        ];

        foreach ($regions as $r) {
            Region::updateOrCreate(
                ['country_id' => $syria->id, 'name_ar' => $r['name_ar']],
                ['name_en' => $r['name_en'], 'is_active' => true]
            );
        }
    }
}