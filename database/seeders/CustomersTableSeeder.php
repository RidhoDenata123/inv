<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'customer_id' => 'CUST001',
                'customer_name' => 'John Doe Enterprises',
                'customer_description' => 'A trusted partner in logistics and supply chain.',
                'customer_address' => '123 Logistics Lane, New York, NY',
                'customer_phone' => '123-456-7890',
                'customer_email' => 'contact@johndoeenterprises.com',
                'customer_website' => 'https://www.johndoeenterprises.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST002',
                'customer_name' => 'Tech Innovators Inc.',
                'customer_description' => 'Leading innovators in the tech industry.',
                'customer_address' => '456 Silicon Valley, San Francisco, CA',
                'customer_phone' => '987-654-3210',
                'customer_email' => 'info@techinnovators.com',
                'customer_website' => 'https://www.techinnovators.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST003',
                'customer_name' => 'Green Earth Supplies',
                'customer_description' => 'Eco-friendly supplier of sustainable products.',
                'customer_address' => '789 Green Street, Portland, OR',
                'customer_phone' => '555-123-4567',
                'customer_email' => 'support@greenearthsupplies.com',
                'customer_website' => 'https://www.greenearthsupplies.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST004',
                'customer_name' => 'Fashion Forward Ltd.',
                'customer_description' => 'Retailer of high-end fashion and accessories.',
                'customer_address' => '321 Fashion Avenue, Los Angeles, CA',
                'customer_phone' => '444-555-6666',
                'customer_email' => 'sales@fashionforward.com',
                'customer_website' => 'https://www.fashionforward.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST005',
                'customer_name' => 'Healthy Living Co.',
                'customer_description' => 'Distributor of health and wellness products.',
                'customer_address' => '654 Wellness Blvd, Miami, FL',
                'customer_phone' => '222-333-4444',
                'customer_email' => 'hello@healthyliving.com',
                'customer_website' => 'https://www.healthyliving.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST006',
                'customer_name' => 'Auto World',
                'customer_description' => 'Supplier of automotive parts and accessories.',
                'customer_address' => '987 Auto Lane, Detroit, MI',
                'customer_phone' => '111-222-3333',
                'customer_email' => 'support@autoworld.com',
                'customer_website' => 'https://www.autoworld.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST007',
                'customer_name' => 'Sports Unlimited',
                'customer_description' => 'Retailer of sports equipment and gear.',
                'customer_address' => '321 Sports Avenue, Denver, CO',
                'customer_phone' => '666-777-8888',
                'customer_email' => 'info@sportsunlimited.com',
                'customer_website' => 'https://www.sportsunlimited.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST008',
                'customer_name' => 'Books & Beyond',
                'customer_description' => 'Supplier of books and educational materials.',
                'customer_address' => '654 Book Street, Boston, MA',
                'customer_phone' => '999-888-7777',
                'customer_email' => 'contact@booksandbeyond.com',
                'customer_website' => 'https://www.booksandbeyond.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST009',
                'customer_name' => 'Toys Galore',
                'customer_description' => 'Retailer of toys and games for all ages.',
                'customer_address' => '789 Toy Lane, Orlando, FL',
                'customer_phone' => '333-444-5555',
                'customer_email' => 'support@toysgalore.com',
                'customer_website' => 'https://www.toysgalore.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 'CUST010',
                'customer_name' => 'Gourmet Foods',
                'customer_description' => 'Supplier of premium food and beverage products.',
                'customer_address' => '123 Gourmet Street, Chicago, IL',
                'customer_phone' => '555-666-7777',
                'customer_email' => 'sales@gourmetfoods.com',
                'customer_website' => 'https://www.gourmetfoods.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}