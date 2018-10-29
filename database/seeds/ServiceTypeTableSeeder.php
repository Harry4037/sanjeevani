<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServiceTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $typeArray = ["Housekeeping", "Issue"];
        foreach ($typeArray as $type) {
            DB::table('service_types')->insert([
                'name' => $type,
            ]);
        }
    }

}
