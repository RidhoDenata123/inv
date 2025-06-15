<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_companies')->insert([
            [
                'company_id' => '1',
                'company_name' => 'E-Inventory-2.',
                'company_description' => 'A leading tech company specializing in software solutions.',
                'company_address' => '123 Tech Street, Silicon Valley, CA',
                'company_phone' => '123-456-7890',
                'company_fax' => '123-456-7891',
                'company_email' => 'info@techsolutions.com',
                'company_website' => 'https://www.techsolutions.com',
                'company_img' => null,
                'company_currency' => 'IDR',
                'company_bank_account' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}