<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\src\Roles\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create([
            'name'=>'admin','identifier'=>'admin'
        ]);
        Role::create([
            'name'=>'applicant','identifier'=>'applicant'
        ]);
        $user=User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username'=>'pierre',
            'password'=>'12345678',
            'role_id'=>Role::whereIdentifier('admin')->first('id')->id
        ]);


    }
}
