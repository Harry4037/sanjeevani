<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $userTypeArray = ["Admin", "Staff", "User","Guest", "Operators"];
        foreach ($userTypeArray as $userType) {
            DB::table('user_type')->insert([
                'user_type_value' => $userType,
                'is_active' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }

}
