<?php

use Illuminate\Database\Seeder;

class RoomTypesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $roomTypeArray = ["Tent", "Cottage", "Delux Room"];
        foreach ($roomTypeArray as $roomType) {
            DB::table('room_types')->insert([
                'name' => $roomType,
//                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }

}
