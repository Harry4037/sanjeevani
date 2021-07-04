<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $typeArray = ["Lorem Ipsum is simply dummy text", "Lorem Ipsum is simply dummy text"];
        foreach ($typeArray as $type) {
            DB::table('questions')->insert([
                'name' => $type,
                'question_type_id' => 1
            ]);
        }
    }

}
