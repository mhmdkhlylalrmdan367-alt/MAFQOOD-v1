<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'phones-electronics', 'name_ar' => 'الهواتف والأجهزة الإلكترونية', 'name_en' => 'Phones & Electronics', 'icon' => 'fa-mobile-screen'],
            ['slug' => 'wallets', 'name_ar' => 'المحافظ', 'name_en' => 'Wallets', 'icon' => 'fa-wallet'],
            ['slug' => 'bags', 'name_ar' => 'الحقائب', 'name_en' => 'Bags', 'icon' => 'fa-bag-shopping'],
            ['slug' => 'keys', 'name_ar' => 'المفاتيح', 'name_en' => 'Keys', 'icon' => 'fa-key'],
            ['slug' => 'documents', 'name_ar' => 'الوثائق والمستندات', 'name_en' => 'Documents', 'icon' => 'fa-file-lines'],
            ['slug' => 'id-cards', 'name_ar' => 'البطاقات الشخصية', 'name_en' => 'ID Cards', 'icon' => 'fa-id-card'],
            ['slug' => 'clothes', 'name_ar' => 'الملابس', 'name_en' => 'Clothes', 'icon' => 'fa-shirt'],
            ['slug' => 'jewelry', 'name_ar' => 'المجوهرات', 'name_en' => 'Jewelry', 'icon' => 'fa-gem'],
            ['slug' => 'pets', 'name_ar' => 'الحيوانات الأليفة', 'name_en' => 'Pets', 'icon' => 'fa-paw'],
            ['slug' => 'watches', 'name_ar' => 'الساعات', 'name_en' => 'Watches', 'icon' => 'fa-clock'],
            ['slug' => 'glasses', 'name_ar' => 'النظارات', 'name_en' => 'Glasses', 'icon' => 'fa-glasses'],
            ['slug' => 'accessories', 'name_ar' => 'الإكسسوارات', 'name_en' => 'Accessories', 'icon' => 'fa-ring'],
            ['slug' => 'other', 'name_ar' => 'أشياء أخرى', 'name_en' => 'Other', 'icon' => 'fa-box'],
        ];

        foreach ($categories as $i => $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['is_active' => true, 'sort_order' => $i])
            );
        }
    }
}