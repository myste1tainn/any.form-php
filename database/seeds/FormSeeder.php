<?php

use App\Questionaire;
use App\QuestionaireResult;
use App\Participant;
use App\ParticipantAnswer;
use App\AnswerAdditionalInput;
use App\Choice;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FormSeeder extends Seeder {
    
    public function run()
    {
        $this->command->info("สร้างแบบฟอร์ม");

        $path = database_path().'/seeds/db-structure.sql';
        DB::unprepared(file_get_contents($path));

        $this->command->info("สร้างแบบฟอร์มเสร็จสิ้น");
    }

}