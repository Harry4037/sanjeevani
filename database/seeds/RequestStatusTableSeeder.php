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
        $typeArray = ["New", "Accepted", "Under Approval", "Completed","Not Resolved", "Closed"];
        foreach ($typeArray as $type) {
            DB::table('service_request_statuses')->insert([
                'request_status' => $type,
            ]);
        }
    }

}
