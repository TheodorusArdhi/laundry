<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
Use Illuminate\Support\Facades\Hash;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::insert([
            'nama' => 'Sinar',
            'email' => 'sinar@gmail.com',
            'no_telp' => '6282313071224',
            'password' => Hash::make('asd'),
            'remember_token' => Str::random(60),
            'level' => 'pemilik',
            'notifikasi' => null
        ]);
    }
}
