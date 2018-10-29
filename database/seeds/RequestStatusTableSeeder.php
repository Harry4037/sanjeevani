<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RequestStatusTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $typeArray = ["New", "Accepted", "Under Approval", "Completed"];
        foreach ($typeArray as $type) {
            DB::table('service_request_statuses')->insert([
                'request_status' => $type,
            ]);
        }
    }

}
