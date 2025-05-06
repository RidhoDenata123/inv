<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Admin',
               'email'=>'admin@email.com',
               'phone'=>'08123456789',
               'type'=>1,
               'password'=> bcrypt('12345678'),
               'company_id'=>1,
               'user_img'=>'',
            ],
    
            [
               'name'=>'User',
               'email'=>'user@email.com',
               'phone'=>'08123456789',
               'type'=>0,
               'password'=> bcrypt('12345678'),
               'company_id'=>1,
               'user_img'=>'',
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
