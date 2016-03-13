<?php

use App\Participant;
use App\QuestionaireResult;

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

        // $this->call('FormSeeder');
		$this->call('ParticipantSeeder');
		$this->call('ResultSeeder');
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
