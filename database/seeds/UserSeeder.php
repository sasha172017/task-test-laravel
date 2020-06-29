<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'user@mail.com';
        $user->password = Hash::make('12345');
        $user->name = 'User';
        $user->token = Str::random(60);
        $user->save();
    }
}
