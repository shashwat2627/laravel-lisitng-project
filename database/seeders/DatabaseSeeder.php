<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        $user = User::factory()->create([

            'name'=>'anushk shukla',
            'email'=>'anushk@gmail.com'

        ]);
        

        Listing::factory(5)->create([

            'user_id'=>$user->id

        ]);

        // Listing::create([

        //     'title' => 'laravel senior developer',

        //     'tags'=>'laravel,javascript',

        //     'company'=>'intel coorp',

        //     'location'=>'boston,MA',

        //     'email'=>'email1@email.com',

        //     'website'=>'abc.com',

        //     'description'=>'first description'


        // ]);

        // Listing::create([

        //     'title' => 'full stack developer',

        //     'tags'=>'laravel,backend,api',

        //     'company'=>'samsung coorp',

        //     'location'=>'kanpur,UP',

        //     'email'=>'email2@email.com',

        //     'website'=>'def.com',

        //     'description'=>'second description'


        // ]);

    }
}
?>