<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Could be done with Faker, but I've always used
     * scientists as my default users
     *
     * @var array $scientists
     */
    private $scientists = [
        [
            'name' => 'Carl Sagan',
            'email' => 'sagan@cornell.edu',
            'password' => 'billions',
        ],[
            'name' => 'Albert Einstein',
            'email' => 'einstein@princeton.edu',
            'password' => 'emc2',
        ],[
            'name' => 'Marie Curie',
            'email' => 'curie@rad.org',
            'password' => 'radium',
        ],[
            'name' => 'Nikola Tesla',
            'email' => 'tesla@coil.com',
            'password' => 'pigeons',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Loop through scientists and create users
        foreach ($this->scientists as $scientist) {
            $scientist['password'] = Hash::make($scientist['password']);
            User::firstOrCreate($scientist);
        }
    }
}
