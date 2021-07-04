<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserTypeTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ServiceTypeTableSeeder::class);
        $this->call(RequestStatusTableSeeder::class);
        $this->call(QuestionTypeTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
    }

}
