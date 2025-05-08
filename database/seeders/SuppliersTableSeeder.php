<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'supplier_id' => 'SUP001',
                'supplier_name' => 'Global Supplies Co.',
                'supplier_email' => 'contact@globalsupplies.com',
                'supplier_phone' => '123-456-7890',
                'supplier_address' => '123 Main Street, New York, NY',
                'supplier_description' => 'Leading supplier of industrial goods.',
                'supplier_website' => 'https://www.globalsupplies.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP002',
                'supplier_name' => 'Tech Distributors Ltd.',
                'supplier_email' => 'info@techdistributors.com',
                'supplier_phone' => '987-654-3210',
                'supplier_address' => '456 Tech Avenue, San Francisco, CA',
                'supplier_description' => 'Supplier of electronic components and devices.',
                'supplier_website' => 'https://www.techdistributors.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP003',
                'supplier_name' => 'Food Supplies Inc.',
                'supplier_email' => 'support@foodsupplies.com',
                'supplier_phone' => '555-123-4567',
                'supplier_address' => '789 Food Street, Chicago, IL',
                'supplier_description' => 'Supplier of food and beverage products.',
                'supplier_website' => 'https://www.foodsupplies.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP004',
                'supplier_name' => 'Furniture World',
                'supplier_email' => 'sales@furnitureworld.com',
                'supplier_phone' => '444-555-6666',
                'supplier_address' => '321 Furniture Lane, Los Angeles, CA',
                'supplier_description' => 'Supplier of home and office furniture.',
                'supplier_website' => 'https://www.furnitureworld.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP005',
                'supplier_name' => 'Stationery Hub',
                'supplier_email' => 'hello@stationeryhub.com',
                'supplier_phone' => '222-333-4444',
                'supplier_address' => '654 Paper Road, Seattle, WA',
                'supplier_description' => 'Supplier of office and school stationery.',
                'supplier_website' => 'https://www.stationeryhub.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP006',
                'supplier_name' => 'Auto Parts Depot',
                'supplier_email' => 'support@autopartsdepot.com',
                'supplier_phone' => '111-222-3333',
                'supplier_address' => '987 Auto Lane, Detroit, MI',
                'supplier_description' => 'Supplier of automotive parts and accessories.',
                'supplier_website' => 'https://www.autopartsdepot.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP007',
                'supplier_name' => 'Health & Beauty Supplies',
                'supplier_email' => 'info@healthbeautysupplies.com',
                'supplier_phone' => '666-777-8888',
                'supplier_address' => '321 Wellness Blvd, Miami, FL',
                'supplier_description' => 'Supplier of health and beauty products.',
                'supplier_website' => 'https://www.healthbeautysupplies.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP008',
                'supplier_name' => 'Sports Gear Pro',
                'supplier_email' => 'sales@sportsgearpro.com',
                'supplier_phone' => '999-888-7777',
                'supplier_address' => '654 Sports Avenue, Denver, CO',
                'supplier_description' => 'Supplier of sports equipment and gear.',
                'supplier_website' => 'https://www.sportsgearpro.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP009',
                'supplier_name' => 'Books & More',
                'supplier_email' => 'contact@booksandmore.com',
                'supplier_phone' => '333-444-5555',
                'supplier_address' => '789 Book Street, Boston, MA',
                'supplier_description' => 'Supplier of books and educational materials.',
                'supplier_website' => 'https://www.booksandmore.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 'SUP010',
                'supplier_name' => 'Toys Unlimited',
                'supplier_email' => 'support@toysunlimited.com',
                'supplier_phone' => '555-666-7777',
                'supplier_address' => '123 Toy Lane, Orlando, FL',
                'supplier_description' => 'Supplier of toys and games for all ages.',
                'supplier_website' => 'https://www.toysunlimited.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}