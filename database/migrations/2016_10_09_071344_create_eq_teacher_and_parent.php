<?php

use App\Questionaire;
use App\Question;
use App\QuestionMeta;
use App\QuestionGroup;
use App\Choice;
use App\AdditionalInput;
use App\Criteria;
use App\Definition;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;


class CreateEqTeacherAndParent extends Migration {

	protected static $originalQuestionaireID = 38;
	protected static $console;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Copying all required data from EQ Student into EQ Teacher
		$questionaire = $this->copyQuestionaire(' อาจารย์ประเมิน');
		$this->copyQuestionsAndChoices($questionaire, 'ฉัน', 'นักเรียน');
		$def = Definition::where('name', 'EQReports')->first();
		if ($def) {
			$def->values .= '|'.$questionaire->id;
			$def->save();
		}

		// Reset static memory
		static::$copiedGroupInfos = [];
		static::$copiedParentGroupInfos = [];

		// Copying all required data from EQ Student into EQ Parent
		$questionaire = $this->copyQuestionaire(' ผู้ปกครองประเมิน');
		$this->copyQuestionsAndChoices($questionaire, 'ฉัน', 'เด็ก');
		$def = Definition::where('name', 'EQReports')->first();
		if ($def) {
			$def->values .= '|'.$questionaire->id;
			$def->save();
		}

		DB::table('choices')->where('parentID', 0)->update(['parentID' => NULL]);
		DB::table('question_groups')->where('parentID', 0)->update(['parentID' => NULL]);
		DB::table('criteria')->where('groupID', 0)->update(['groupID' => NULL]);
	}

	private function w($text) {
		echo $text.'\r';
	}
	private function wl($text) {
		echo $text.PHP_EOL;
	}

	private function copyQuestionaire($appendName) {
		$originalQuestionaire = Questionaire::with('criteria')->find(static::$originalQuestionaireID);
		$copiedQuestionaire = $originalQuestionaire->replicate();
		$copiedQuestionaire->name = $copiedQuestionaire->name.$appendName;
		$copiedQuestionaire->save();

		$this->wl('Questionaire ::: '.$copiedQuestionaire->name.' created');

		return $copiedQuestionaire;
	}

	private function copyCriteria($originalGroup, $copiedGroup) {
		$originalGroup->criteria = $originalGroup->criteria()->get();
		foreach ($originalGroup->criteria as $criterion) {
			$copiedCriterion = $criterion->replicate();
			$copiedCriterion->questionaireID = $copiedGroup->questionaireID;
			$copiedCriterion->groupID = $copiedGroup->id;
			$copiedCriterion->save();

			$this->wl('Criteria ::: '.$copiedCriterion->label.' created');
		}
	}

	private function copyQuestionsAndChoices($targetQuestionaire, $oldWording, $newWording) {
		$query = Question::with('choices', 'group.parent');
		$query->where('questionaireID', static::$originalQuestionaireID);
		$questions = $query->get();
		$this->copyQuestions($targetQuestionaire, $questions, $oldWording, $newWording);
	}

	// Copy questions
	private function copyQuestions($targetQuestionaire, $questions, $oldWording, $newWording) {
		foreach ($questions as $question) {
			$copiedQuestion = $question->replicate();
			$copiedQuestion->questionaireID = $targetQuestionaire->id;
			$copiedQuestion->name = str_replace($oldWording, $newWording, $copiedQuestion->name);
			$copiedQuestion->groupID = $this->copyGroupIDForQuestion($copiedQuestion);
			$copiedQuestion->save();

			$this->wl('Question ::: '.$copiedQuestion->name.' created');

			$this->copyChoices($question, $copiedQuestion);
		}
	}

	// Copy choice from question to new question
	private function copyChoices($question, $copiedQuestion) {
		foreach ($question->choices as $choice) {
			$copiedChoice = $choice->replicate();
			$copiedChoice->questionID = $copiedQuestion->id;

			$this->wl('Choice on questionID ::: '.$copiedQuestion->id.' created');

			$copiedChoice->save();
		}
	}

	// Copy group of the question
	private static $copiedGroupInfos = [];
	private function copyGroupIDForQuestion($question) {
		$targetGroupID = null;

		// If the group was already copied once, return that id
		foreach (static::$copiedGroupInfos as $copiedGroupInfo) {
			if ($question->group->id == $copiedGroupInfo->originalID) {
				$targetGroupID = $copiedGroupInfo->copiedID;
			}
		}

		// Otherwise replicate it and return the new id
		if ($targetGroupID == null) {
			if ($question->group) {
				$copiedGroup = $question->group->replicate();
				$copiedGroup->questionaireID = $question->questionaireID;
				$copiedGroup->parentID = $this->copyParentGroupIDForGroup($copiedGroup);
				$copiedGroup->save();
				$targetGroupID = $copiedGroup->id;

				$this->wl('Group ::: '.$copiedGroup->name.' created');

				// Remember the already replicated group
				$info = new \stdClass();
				$info->originalID = $question->group->id;
				$info->copiedID = $targetGroupID;
				static::$copiedGroupInfos[] = $info;

				$this->copyCriteria($question->group, $copiedGroup);
			}
		}

		return $targetGroupID;
	}

	private static $copiedParentGroupInfos = [];
	private function copyParentGroupIDForGroup($group) {
		$targetGroupID = null;

		// If the group was already copied once, return that id
		foreach (static::$copiedParentGroupInfos as $copiedGroupInfo) {
			if ($group->parent->id == $copiedGroupInfo->originalID) {
				$targetGroupID = $copiedGroupInfo->copiedID;
			}
		}

		// Otherwise replicate it and return the new id
		if ($targetGroupID == null) {
			if ($group->parent) {
				$copiedGroup = $group->parent->replicate();
				$copiedGroup->questionaireID = $group->questionaireID;
				$copiedGroup->save();
				$targetGroupID = $copiedGroup->id;

				$this->wl('ParentGroup ::: '.$copiedGroup->name.' created');

				// Remember the already replicated group
				$info = new \stdClass();
				$info->originalID = $group->parent->id;
				$info->copiedID = $targetGroupID;
				static::$copiedParentGroupInfos[] = $info;

				$this->copyCriteria($group->parent, $copiedGroup);
			}
		}

		return $targetGroupID;
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
