<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'unit_id' => 'U001',
                'unit_name' => 'Kilogram',
                'unit_description' => 'Unit for measuring weight in kilograms',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U002',
                'unit_name' => 'Gram',
                'unit_description' => 'Unit for measuring weight in grams',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U003',
                'unit_name' => 'Liter',
                'unit_description' => 'Unit for measuring volume in liters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U004',
                'unit_name' => 'Milliliter',
                'unit_description' => 'Unit for measuring volume in milliliters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U005',
                'unit_name' => 'Piece',
                'unit_description' => 'Unit for counting individual items',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U006',
                'unit_name' => 'Box',
                'unit_description' => 'Unit for counting items in boxes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U007',
                'unit_name' => 'Pallet',
                'unit_description' => 'Unit for counting items on pallets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U008',
                'unit_name' => 'Meter',
                'unit_description' => 'Unit for measuring length in meters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U009',
                'unit_name' => 'Centimeter',
                'unit_description' => 'Unit for measuring length in centimeters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U010',
                'unit_name' => 'Inch',
                'unit_description' => 'Unit for measuring length in inches',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U011',
                'unit_name' => 'Dozen',
                'unit_description' => 'Unit for counting items in dozens',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U012',
                'unit_name' => 'Pack',
                'unit_description' => 'Unit for counting items in packs',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'unit_id' => 'U013',
                'unit_name' => 'Unit',
                'unit_description' => 'Unit for counting items in unit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}