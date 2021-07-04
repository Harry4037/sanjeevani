<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'user_name' => "Admin",
            'first_name' => "Admin",
            'email_id' => "admin@mail.com",
            'password' => bcrypt("123456"),
            'gender' => "M",
            'user_type_id' => 1,
            'date_of_joining' => Carbon::now()->format('Y-m-d H:i:s'),
            'date_of_birth' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

}
