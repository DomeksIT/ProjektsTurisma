<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
   public function run(): void
   {
       User::updateOrCreate(
           ['email' => config('admin.email')],
           [
               'name' => 'Admin',
               'password' => Hash::make(config('admin.password')),
               'is_admin' => 1,
           ]
       );
   }
}