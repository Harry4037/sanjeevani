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
        $typeArray = ["question 1", "question 2"];
        foreach ($typeArray as $type) {
            DB::table('question_types')->insert([
                'name' => $type,
                'question_type_id' => 1,
            ]);
        }
    }

}
