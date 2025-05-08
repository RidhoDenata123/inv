<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_id' => 'C001',
                'category_name' => 'Electronics',
                'category_description' => 'Devices and gadgets such as phones, laptops, and tablets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C002',
                'category_name' => 'Furniture',
                'category_description' => 'Furniture items such as chairs, tables, and cabinets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C003',
                'category_name' => 'Clothing',
                'category_description' => 'Apparel items such as shirts, pants, and jackets.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C004',
                'category_name' => 'Food & Beverages',
                'category_description' => 'Edible items such as snacks, drinks, and groceries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C005',
                'category_name' => 'Stationery',
                'category_description' => 'Office supplies such as pens, notebooks, and paper.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C006',
                'category_name' => 'Automotive',
                'category_description' => 'Automotive parts and accessories such as tires and batteries.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C007',
                'category_name' => 'Health & Beauty',
                'category_description' => 'Products such as skincare, cosmetics, and health supplements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C008',
                'category_name' => 'Sports & Outdoors',
                'category_description' => 'Equipment and gear for sports and outdoor activities.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C009',
                'category_name' => 'Books',
                'category_description' => 'Books and printed materials such as novels and magazines.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 'C010',
                'category_name' => 'Toys',
                'category_description' => 'Toys and games for children and adults.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}