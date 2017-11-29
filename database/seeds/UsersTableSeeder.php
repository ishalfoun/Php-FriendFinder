<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //clear table
        DB::statement('TRUNCATE users CASCADE');

        /* DB::table('users')->truncate();*/
        echo "Seeding database with users, please wait...".PHP_EOL;
        //make my test user
        DB::table('users')->insert([
            'name' => "Theo",
            'email' => 'theo@gmail.com',
            'program' => 'Comp Sci',
            'password' => bcrypt('dawson'),
        ]);

        //create 50 fake users

        $faker = Faker::create();
        foreach(range(1, 100) as $index)
        {
            DB::table('users')->insert([
                'name' => $faker->firstName." ".$faker->lastName,
                'email' =>  $faker->unique()->safeEmail,
                'program' => 'test',
                'password' => bcrypt("secret"),
            ]);
        }

        echo "100 users successfully seeded.".PHP_EOL;


    }




}
