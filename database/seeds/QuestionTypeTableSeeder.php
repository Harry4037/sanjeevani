<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $typeArray = ["question"];
        foreach ($typeArray as $type) {
            DB::table('question_types')->insert([
                'name' => $type,
            ]);
        }
    }

}
