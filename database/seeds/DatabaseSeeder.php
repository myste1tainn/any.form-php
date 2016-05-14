<?php

use App\Questionaire;
use App\QuestionaireResult;
use App\Participant;
use App\ParticipantAnswer;
use App\AnswerAdditionalInput;
use App\Choice;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        try {
            // $this->call('FormSeeder');
            // $this->call('ParticipantSeeder');
            // $this->call('ResultSeeder');
            // $this->call('RiskSeeder');
            $this->call('MockSeeder');
        } catch (Exception $e) {
            $this->command->info($e);
        }
	}

}

class FormSeeder extends Seeder {
    
    public function run()
    {
        $this->command->info("สร้างแบบฟอร์ม");

        $path = database_path().'/seeds/forms.sql';
        DB::unprepared(file_get_contents($path));

        $path = database_path().'/seeds/questions_meta.sql';
        DB::unprepared(file_get_contents($path));

        $this->command->info("สร้างแบบฟอร์มเสร็จสิ้น");
    }

}

class MockSeeder extends Seeder {
    public function run()
    {
        $this->command->info("Supplying forms data");
        $this->command->info("Supplying mockups data");
        $path = database_path().'/seeds/structure-with-mock.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info("Done");
    }
}

class ParticipantSeeder extends Seeder {

    public function run()
    {
        $fname = ['Aaron','Abbott','Abel','Abell','Abernathy','Abney','Abraham','Abrams','Abreu','Acevedo','Acker','Ackerman','Acosta','Acuna','Adair','Adam','Babb','Babcock','Babin','Baca','Bach','Bachman','Back','Bacon','Bader','Badger','Baer','Baez','Baggett','BagleyCaballero','Cable','Cabral','Cabrera','Cade','Cady','Cagle','Cahill','Cain','Calabrese','Calderon','Caldwell','Calhoun','Calkins','Call','Callahan','Callaway','Callender','Dabney','Dahl','Daigle','Dailey','Daily','Dale','Daley','Dallas','Dalton','Daly','Damico','Damon','Damron','Dancy','Dang','Dangelo','Daniel','Daniels','Danielson','Saavedra','Sadler','Saenz','Sage','Sager','Salas','Salazar','Salcedo','Salcido','Saldana','Salerno','Sales','Salgado','Salinas','Salisbury','Sallee','Salley','Salmon','Salter','Sam','Taber','Tabor','Tackett','Taft','Taggart','Talbert','Talbot','Talbott','Talley','Tam','Tamayo','Tan','Tanaka','Tang','Tanner','Tapia','Tapp','Tarver','Tate','Tatum','Roderick','Rodgers','Rodrigue','Rodrigues','Rodriguez','Rodriquez','Roe','Rogers','Rohr','Rojas','Roland','Roldan','Roller','Rollins','Roman','Kline','Klinger','Knapp','Knight','Knoll','Knott','Knowles','Knowlton','Knox','Knudsen','Knudson','Knutson','Koch','Koehler','Koenig','Ibarra','Ingle','Ingram','Inman','Irby','Ireland','Irish','Irizarry','Irvin','Irvine','Irving','Irwin','Isaac','Isaacs','Isaacson','Isbell','Isom','Ison','Israel','Iverson','Ives','Ivey','Ivory','Ivy','Waddell','Wade','Wadsworth','Waggoner','Wagner','Wagoner','Wahl','Waite','Wakefield','Walden','Waldron','Waldrop','Walker','Wall','Wallace','Wallen','Waller','Walling','Wallis','Walls','Williford','Willingham','Willis','Willoughby','Wills','Willson','Wilmoth','Wilson','Wilt','Wimberly','Winchester','Windham','Winfield','Winfrey','Wing','Wingate','Wingfield','Winkler','Winn','Winslow','Winstead','Winston','Winter','Ma','Maas','Mabe','Mabry','Macdonald','Mace','Machado','Macias','Mack','Mackay','Mackenzie','Mackey','Mackie','Macklin','Maclean','Macon','Madden','Maddox','Madison','Madrid','Madrigal','Madsen','Maes','Maestas','Magana','Magee','Maguire','Mahaffey','Mahan','Maher','Mahon','Mahoney','Maier','Main','Major','Majors','Maki','Malcolm','Maldonado','Malley','Mallory','Malloy','Malone','Maloney','Mancini','Mancuso','Maness','Mangum','Manley','Mann','Manning','Manns','Mansfield','Manson','Manuel','Manzo','Maples','Marble','March','Marchand','Marcotte','Marcum','Marcus','Mares','Marin','Marino','Marion','Mark','Markham','Markley','Marks','Marlow','Marlowe','Marquez','Marquis','Marr','Marrero','Marroquin','Marsh','Marshall','Martel','Martell','Martens','Martin','Martindale','Martinez','Martino','Martins','Martz','Marvin','Marx','Mason','Massey','Massie','Mast','Masters','Masterson','Mata','Matheny','Matheson','Mathews','Mathias','Mathis','Matlock','Matney','Matos','Matson','Matteson','Matthew','Matthews','Mattingly','Mattison','Mattos','Mattox','Mattson','Mauldin','Maupin','Maurer','Mauro','Maxey','Maxwell','May','Mayberry','Mayer','Mayers','Mayes','Mayfield','Mayhew','Maynard','Mayo','Mays','Mcadams','Mcafee','Mcalister','Mcallister','Mcarthur','Mcbee','Mcbride','Mccabe','Mccaffrey','Mccain','Mccall','Mccallister','Mccallum','Mccann','Mccarter','Mccarthy','Mccartney','Mccarty','Mccaskill','Mccauley','Mcclain','Mcclanahan','Mcclellan','Mcclelland','Mcclendon','Mcclintock','Mccloskey','Mcclou','Mendoza','Menendez','Mercado','Mercer','Merchant','Mercier','Meredith','Merrick','Merrill','Merriman','Merritt','Mesa','Messenger','Messer','Messina','Metcalf','Metz','Metzger','Metzler','Meyer','Meyers','Meza','Michael','Michaels','Michaud','Michel','Middleton','Milam','Milburn','Miles','Jack','Jacks','Jackson','Jacob','Jacobs','Jacobsen','Jacobson','Jacoby','Jacques','Jaeger','James','Jameson','Jamison','Janes','Jansen','Janssen','Jaramillo','Jarrell','Jarrett','Jarvis','Jasper','Jay','Jaynes','Johnson','Johnston','Joiner','Jolley','Jolly','Jones','Jordan','Jordon','Jorgensen','Jorgenson','Jose','Joseph','Joy','Joyce','Joyner','Juarez','Judd','Jude','Judge','Julian'];
        $lname = ['Aaron','Abbott','Abel','Abell','Abernathy','Abney','Abraham','Abrams','Abreu','Acevedo','Acker','Ackerman','Acosta','Acuna','Adair','Adam','Babb','Babcock','Babin','Baca','Bach','Bachman','Back','Bacon','Bader','Badger','Baer','Baez','Baggett','BagleyCaballero','Cable','Cabral','Cabrera','Cade','Cady','Cagle','Cahill','Cain','Calabrese','Calderon','Caldwell','Calhoun','Calkins','Call','Callahan','Callaway','Callender','Dabney','Dahl','Daigle','Dailey','Daily','Dale','Daley','Dallas','Dalton','Daly','Damico','Damon','Damron','Dancy','Dang','Dangelo','Daniel','Daniels','Danielson','Saavedra','Sadler','Saenz','Sage','Sager','Salas','Salazar','Salcedo','Salcido','Saldana','Salerno','Sales','Salgado','Salinas','Salisbury','Sallee','Salley','Salmon','Salter','Sam','Taber','Tabor','Tackett','Taft','Taggart','Talbert','Talbot','Talbott','Talley','Tam','Tamayo','Tan','Tanaka','Tang','Tanner','Tapia','Tapp','Tarver','Tate','Tatum','Roderick','Rodgers','Rodrigue','Rodrigues','Rodriguez','Rodriquez','Roe','Rogers','Rohr','Rojas','Roland','Roldan','Roller','Rollins','Roman','Kline','Klinger','Knapp','Knight','Knoll','Knott','Knowles','Knowlton','Knox','Knudsen','Knudson','Knutson','Koch','Koehler','Koenig','Ibarra','Ingle','Ingram','Inman','Irby','Ireland','Irish','Irizarry','Irvin','Irvine','Irving','Irwin','Isaac','Isaacs','Isaacson','Isbell','Isom','Ison','Israel','Iverson','Ives','Ivey','Ivory','Ivy','Waddell','Wade','Wadsworth','Waggoner','Wagner','Wagoner','Wahl','Waite','Wakefield','Walden','Waldron','Waldrop','Walker','Wall','Wallace','Wallen','Waller','Walling','Wallis','Walls','Williford','Willingham','Willis','Willoughby','Wills','Willson','Wilmoth','Wilson','Wilt','Wimberly','Winchester','Windham','Winfield','Winfrey','Wing','Wingate','Wingfield','Winkler','Winn','Winslow','Winstead','Winston','Winter','Ma','Maas','Mabe','Mabry','Macdonald','Mace','Machado','Macias','Mack','Mackay','Mackenzie','Mackey','Mackie','Macklin','Maclean','Macon','Madden','Maddox','Madison','Madrid','Madrigal','Madsen','Maes','Maestas','Magana','Magee','Maguire','Mahaffey','Mahan','Maher','Mahon','Mahoney','Maier','Main','Major','Majors','Maki','Malcolm','Maldonado','Malley','Mallory','Malloy','Malone','Maloney','Mancini','Mancuso','Maness','Mangum','Manley','Mann','Manning','Manns','Mansfield','Manson','Manuel','Manzo','Maples','Marble','March','Marchand','Marcotte','Marcum','Marcus','Mares','Marin','Marino','Marion','Mark','Markham','Markley','Marks','Marlow','Marlowe','Marquez','Marquis','Marr','Marrero','Marroquin','Marsh','Marshall','Martel','Martell','Martens','Martin','Martindale','Martinez','Martino','Martins','Martz','Marvin','Marx','Mason','Massey','Massie','Mast','Masters','Masterson','Mata','Matheny','Matheson','Mathews','Mathias','Mathis','Matlock','Matney','Matos','Matson','Matteson','Matthew','Matthews','Mattingly','Mattison','Mattos','Mattox','Mattson','Mauldin','Maupin','Maurer','Mauro','Maxey','Maxwell','May','Mayberry','Mayer','Mayers','Mayes','Mayfield','Mayhew','Maynard','Mayo','Mays','Mcadams','Mcafee','Mcalister','Mcallister','Mcarthur','Mcbee','Mcbride','Mccabe','Mccaffrey','Mccain','Mccall','Mccallister','Mccallum','Mccann','Mccarter','Mccarthy','Mccartney','Mccarty','Mccaskill','Mccauley','Mcclain','Mcclanahan','Mcclellan','Mcclelland','Mcclendon','Mcclintock','Mccloskey','Mcclou','Mendoza','Menendez','Mercado','Mercer','Merchant','Mercier','Meredith','Merrick','Merrill','Merriman','Merritt','Mesa','Messenger','Messer','Messina','Metcalf','Metz','Metzger','Metzler','Meyer','Meyers','Meza','Michael','Michaels','Michaud','Michel','Middleton','Milam','Milburn','Miles','Jack','Jacks','Jackson','Jacob','Jacobs','Jacobsen','Jacobson','Jacoby','Jacques','Jaeger','James','Jameson','Jamison','Janes','Jansen','Janssen','Jaramillo','Jarrell','Jarrett','Jarvis','Jasper','Jay','Jaynes','Johnson','Johnston','Joiner','Jolley','Jolly','Jones','Jordan','Jordon','Jorgensen','Jorgenson','Jose','Joseph','Joy','Joyce','Joyner','Juarez','Judd','Jude','Judge','Julian'];
        
        for ($i=0; $i < 1000; $i++) { 
        	$frand = rand(0, count($fname) - 1);
        	$lrand = rand(0, count($lname) - 1);
        	$classrand = rand(1, 6);
        	$roomrand = rand(1, 12);

        	$participant = new Participant();
        	$participant->identifier = $this->pad(6, $i);
        	$participant->firstname = $fname[$frand];
        	$participant->lastname = $lname[$lrand];
        	$participant->class = $classrand;
        	$participant->room = $roomrand;
        	$participant->save();

        	$this->command->info("Participant ".($i+1)."/1000 created");
        }
    }

    public function pad($num, $string) {
    	while(strlen($string) < $num) {
    		$string = "0".$string;
    	}

    	return $string;
    }

}

class ResultSeeder extends Seeder {

    public function run()
    {
        $forms = [];

        $form1 = new stdClass();
        $form1->id = 32;
        $form1->max = 60;

        $form2 = new stdClass();
        $form2->id = 33;
        $form2->max = 60;

        $form3 = new stdClass();
        $form3->id = 34;
        $form3->max = 30;

        $forms[] = $form1;
        $forms[] = $form2;
        $forms[] = $form3;

        $participants = Participant::all();
        foreach ($forms as $f) {
            $i = 0;
            $c = count($participants);
        	foreach ($participants as $p) {
        		$randval = rand(0, $f->max);

        		$r = new QuestionaireResult();
	        	$r->questionaireID = $f->id;
	        	$r->participantID = $p->id;
	        	$r->value = $randval;
	        	$r->save();

	        	$this->command->info("results ".($i+1)."/".$c." created");
	        	$i++;
        	}
        }
    }

}

class RiskSeeder extends Seeder {

    public function run()
    {
        // Get the questionaire with all questions and availble choice to choose from
        $f = Questionaire::with('questions.choices.subchoices')
                         ->find(env('APP_RISK_ID'));

        $participants = Participant::all();
        $i = 0;
        $c = count($participants);
        foreach ($participants as $p) {
            $this->createAnswers($f, $p);

            // Points doesn't really matter alot in risk form
            $this->createResults($f, $p, 999); 

            $this->command->info("results ".($i+1)."/".$c." created");

            $i++;
        }
    }

    /// Create answers which comes randomly first
    private function createAnswers($f, $p) {

        // Simulate each qeustion answering
        foreach ($f->questions as $q) {
            if ($q->isAspect()) {
                // If the question is about each aspect, answer like..

                // Each aspects has 3 level: normal, high-risk, very-high-risk
                // random to choose between those
                $c = $this->getRandomChoice($q->choices, null, true);
                if ($c->value == 0) {
                    // Choose it and continue to next question
                    $this->chooseChoice($f, $q, $c, $p);

                    // next loop
                } else {
                    // Choose the choice
                    $this->chooseChoice($f, $q, $c, $p);
                    $this->chooseRandomSubchoices($f, $q, $c, $p);

                    // and random again
                    // Since high & very-high can be their simultaneously
                    $nc = $this->getRandomChoice($q->choices, null, true);

                    if ($nc->value > 0 && $nc->value != $c->value) {
                        // Not the 'normal' and not the same choice, choose it
                        $this->chooseChoice($f, $q, $nc, $p);
                        $this->chooseRandomSubchoices($f, $q, $nc, $p);
                    } else {
                        // next loop
                    }
                }
            } else if ($q->isAboutTalent()) {
                // If the question is about talent answer like...

                // Talent has only 2 choice, random between the two
                $c = $this->getRandomChoice($q->choices, null);
                $a = $this->chooseChoice($f, $q, $c, $p);
                $ci = $c->inputs()->first();
                if ($ci) {
                    $this->createRandomTalent($a, $ci, $p);
                }

                // next loop

            } else if ($q->isAboutDisability()) {
                // If the question is about disability answer like...

                // Non uniform random, low rate of having disability
                $probHaveDis = rand(0, 100);

                // Only 30% chance that a participant will have disability
                if ($probHaveDis > 70) {

                    $numDis = $this->randomNumberOfDisabilities();

                    $choosenChoices = [];
                    $numChoice = count($q->choices);
                    for ($i=0; $i < $numDis; $i++) { 
                        $c = $this->getRandomChoice($q->choices, $numChoice);
                        
                        if (Choice::choiceExistsInAnswers($c, $choosenChoices)) {
                            // Allow no duplicates disabilities
                            continue;
                        } else {
                            $a = $this->chooseChoice($f, $q, $c, $p);
                            $ci = $c->inputs()->first();
                            if ($ci) {
                                $this->createRandomDisability($a, $ci);
                            }
                        }

                        $choosenChoices[] = $a;
                    }
                }
            }
        }
    }

    private function getRandomChoice($cs, $max, $parentOnly = false) {
        if (!$max) $max = count($cs);
        if (!$max) exit;

        $index = rand(0, $max-1);

        if ($parentOnly) {
            while ($cs[$index]->parent) {
                $index = rand(0, $max-1);
            }
        }

        return $cs[$index];
    }

    private function chooseChoice($f, $q, $c, $p) {
        $a = new ParticipantAnswer();
        $a->participantID = $p->id;
        $a->questionaireID = $f->id;
        $a->questionID = $q->id;
        $a->choiceID = $c->id;
        $a->academicYear = 2559;
        $a->save();
        return $a;
    }

    // Randomly select subchoices for the random-ed number of choices
    private function chooseRandomSubchoices($f, $q, $c, $p) {
        $count = count($c->subchoices) - 1;
        $rcount = rand(0, $count);
        if ($count > 0) {
            $choosenChoices = [];
            for ($i=0; $i < $rcount+1; $i++) { 
                $rc = $this->getRandomChoice($c->subchoices, $count);

                if (Choice::choiceExistsInAnswers($rc, $choosenChoices)) {
                    continue;
                } else {
                    $choosenChoices[] = $this->chooseChoice($f, $q, $rc, $p);
                }
            }
        }

        return $choosenChoices;
    }

    private function createRandomTalent($a, $ci) {
        $ai = new AnswerAdditionalInput();
        $ai->value = $this->getRandomTalent();
        $ai->inputID = $ci->id;
        $ai->answerID = $a->id;
        $ai->save();
        return $ai;
    }

    private $talents = [
        'บาสเก็ตบอล',
        'แบดมินตัน',
        'ฟตุบอล',
        'ดนตรี กีตาร์',
        'ดนตรี กลอง',
        'ขับเสภา',
        'ว่ายน้ำ',
        'ดนตรีไทย ระนาด',
        'ดนตรีไทย ขุล่ย',
        'ภาษาอังกฤษ',
        'วิทยาศาสตร์',
        'คณิตศาสตร์',
        'ศิลปะวาดรูป',
    ];

    private function getRandomTalent() {
        $count = count($this->talents) - 1;
        $rand = rand(0, $count);
        return $this->talents[$rand];
    }

    private function createRandomDisability($a, $ci) {
        $ai = new AnswerAdditionalInput();
        $ai->value = $this->getRandomDisability();
        $ai->inputID = $ci->id;
        $ai->answerID = $a->id;
        $ai->save();
        return $ai;
    }

    private $disabilities = [
        'ติดอ่าง',
        'เหม่อลอยไม่มีสมาธิ',
        'ตาบอดข้างซ้าย',
        'ตาบอดข้างขวา',
        'เป็นต้อตา',
        'แขนไม่สมบูรณ์',
        'ขาไม่สมบูรณ์',
        'มีเนื้องอกบริเวณหลัง',
    ];

    private function getRandomDisability() {
        $count = count($this->disabilities) - 1;
        $rand = rand(0, $count);
        return $this->disabilities[$rand];
    }

    private function randomNumberOfDisabilities() {
        // Random number of disabilities
        $numDis = 1;
        $probNumDis = rand(0, 100);
        if ($probNumDis > -1 && $probNumDis < 59) {
            // 61% chances for having 1 dis
            $numDis = 1;
        } else if ($probNumDis > 59 && $probNumDis < 79) {
            // 30% chances for having 2 dis
            $numDis = 2;
        } else if ($probNumDis > 79 && $probNumDis < 94) {
            // 15% chances for having 3 dis
            $numDis = 3;
        } else if ($probNumDis > 94 && $probNumDis < 99) {
            // 5% chances for having 4 dis
            $numDis = 4;
        } else if ($probNumDis > 99) {
            // 1% chances for having 5 dis
            $numDis = 5;
        }
        return $numDis;
    }

    /// Then create results from the random answers
    private function createResults($f, $p, $points) {
        $r = new QuestionaireResult();
        $r->questionaireID = $f->id;
        $r->participantID = $p->id;
        $r->value = $points;
        $r->academicYear = 2559;
        $r->save();
        return $r;
    }

}
