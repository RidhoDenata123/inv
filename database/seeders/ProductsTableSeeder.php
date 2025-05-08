<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'product_id' => 'PROD001',
                'product_name' => 'Laptop Pro 15',
                'product_category' => 'C001', // Electronics
                'product_description' => 'High-performance laptop for professionals.',
                'product_qty' => 50,
                'purchase_price' => 1200.00,
                'selling_price' => 1500.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'laptop_pro_15.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD002',
                'product_name' => 'Smartphone X',
                'product_category' => 'C001', // Electronics
                'product_description' => 'Latest smartphone with advanced features.',
                'product_qty' => 100,
                'purchase_price' => 800.00,
                'selling_price' => 1000.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'smartphone_x.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD003',
                'product_name' => 'Office Chair Deluxe',
                'product_category' => 'C002', // Furniture
                'product_description' => 'Ergonomic office chair with lumbar support.',
                'product_qty' => 30,
                'purchase_price' => 150.00,
                'selling_price' => 200.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'office_chair_deluxe.jpg',
                'supplier_id' => 'SUP004',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD004',
                'product_name' => 'Gaming Mouse',
                'product_category' => 'C001', // Electronics
                'product_description' => 'High-precision gaming mouse with RGB lighting.',
                'product_qty' => 200,
                'purchase_price' => 40.00,
                'selling_price' => 60.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'gaming_mouse.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD005',
                'product_name' => 'Notebook A5',
                'product_category' => 'C005', // Stationery
                'product_description' => 'Compact notebook for daily notes.',
                'product_qty' => 500,
                'purchase_price' => 2.00,
                'selling_price' => 3.50,
                'product_unit' => 'U005', // Piece
                'product_img' => 'notebook_a5.jpg',
                'supplier_id' => 'SUP005',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD006',
                'product_name' => 'Ballpoint Pen',
                'product_category' => 'C005', // Stationery
                'product_description' => 'Smooth writing ballpoint pen.',
                'product_qty' => 1000,
                'purchase_price' => 0.50,
                'selling_price' => 1.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'ballpoint_pen.jpg',
                'supplier_id' => 'SUP005',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD007',
                'product_name' => 'Water Bottle 1L',
                'product_category' => 'C004', // Food & Beverages
                'product_description' => 'Reusable water bottle with 1L capacity.',
                'product_qty' => 300,
                'purchase_price' => 5.00,
                'selling_price' => 8.00,
                'product_unit' => 'U003', // Liter
                'product_img' => 'water_bottle_1l.jpg',
                'supplier_id' => 'SUP003',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD008',
                'product_name' => 'Organic Coffee Beans',
                'product_category' => 'C004', // Food & Beverages
                'product_description' => 'Premium organic coffee beans.',
                'product_qty' => 100,
                'purchase_price' => 15.00,
                'selling_price' => 20.00,
                'product_unit' => 'U001', // Kilogram
                'product_img' => 'organic_coffee_beans.jpg',
                'supplier_id' => 'SUP003',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD009',
                'product_name' => 'Tennis Racket',
                'product_category' => 'C008', // Sports & Outdoors
                'product_description' => 'Lightweight tennis racket for professionals.',
                'product_qty' => 50,
                'purchase_price' => 80.00,
                'selling_price' => 120.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'tennis_racket.jpg',
                'supplier_id' => 'SUP008',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD010',
                'product_name' => 'Yoga Mat',
                'product_category' => 'C008', // Sports & Outdoors
                'product_description' => 'Non-slip yoga mat for all fitness levels.',
                'product_qty' => 100,
                'purchase_price' => 20.00,
                'selling_price' => 30.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'yoga_mat.jpg',
                'supplier_id' => 'SUP008',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD011',
                'product_name' => 'LED Desk Lamp',
                'product_category' => 'C001', // Electronics
                'product_description' => 'Energy-efficient LED desk lamp.',
                'product_qty' => 150,
                'purchase_price' => 25.00,
                'selling_price' => 40.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'led_desk_lamp.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD012',
                'product_name' => 'Wireless Keyboard',
                'product_category' => 'C001', // Electronics
                'product_description' => 'Compact wireless keyboard with Bluetooth.',
                'product_qty' => 120,
                'purchase_price' => 30.00,
                'selling_price' => 50.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'wireless_keyboard.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD013',
                'product_name' => 'Running Shoes',
                'product_category' => 'C008', // Sports & Outdoors
                'product_description' => 'Lightweight running shoes for athletes.',
                'product_qty' => 80,
                'purchase_price' => 60.00,
                'selling_price' => 90.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'running_shoes.jpg',
                'supplier_id' => 'SUP008',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD014',
                'product_name' => 'Bluetooth Speaker',
                'product_category' => 'C001', // Electronics
                'product_description' => 'Portable Bluetooth speaker with high-quality sound.',
                'product_qty' => 70,
                'purchase_price' => 50.00,
                'selling_price' => 80.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'bluetooth_speaker.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'PROD015',
                'product_name' => 'Electric Kettle',
                'product_category' => 'C001', // Electronics
                'product_description' => 'Fast-boiling electric kettle with auto shut-off.',
                'product_qty' => 60,
                'purchase_price' => 35.00,
                'selling_price' => 55.00,
                'product_unit' => 'U005', // Piece
                'product_img' => 'electric_kettle.jpg',
                'supplier_id' => 'SUP002',
                'product_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}