<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
  
    public function run(): void
    {
        $users = User::factory(1000)->create();

        $roles = ['User', 'Admin', 'Product Manager', 'Super Admin'];

        $users->each(function ($user) use ($roles) {
            $user->assignRole($roles[array_rand($roles)]);
   });
}
}