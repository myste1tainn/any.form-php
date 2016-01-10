@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<style>
	table {
		width: 100%;
	}
	td {
		padding: 5px;
	}
	input {
		width: 100%;
	}
	tr.classified {
		border-top: 2px solid #555;
		border-bottom: 2px solid #555;
	}
	tr.classified td {
		padding: 10px;
	}
	tr.classified.cri {
		/*border-color: #bbbbff;*/
	}
	tr.classified.que {
		/*border-color: #bbffbb;*/
	}
	tr.classified.cho {
		/*border-color: #ffbbbb;*/
	}
	.criterion {
		background: #bbbbff;
	}
	.question {
		background: #bbffbb;
	}
	.choice {
		background: #ffbbbb;
	}
</style>
<div class="container">
	<h3>สร้างแบบฟอร์ม</h3>
	<hr />
	<table>
		<tr>
			<td colspan="1">ชื่อ</td>
			<td colspan="6">
				<input name="name" ng-model="name" type="text" />
			</td>
		</tr>
		<tr>
			<td colspan="1">
				<button ng-click="addCriterion()">+</button>
			</td>
			<td colspan="6">
				<b>เกณฑ์</b>
			</td>
		</tr>
		<tr ng-repeat="criterion in questionaire.criteria" class="classified cri">
			<td colspan="1" class="criterion">
			</td>
			<td colspan="6" style="padding: 0px">
				<table>
					<tr>
						<td colspan="1">ชื่อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td colspan="1">
							<input name="criterion-label" ng-model="criterion.label" type="text" />
						</td>
						<td colspan="1">ค่าตั้งแต</td>
						<td colspan="1">
							<input name="criterion-from" ng-model="criterion.from" type="text" />
						</td>
						<td colspan="1">ถึง</td>
						<td colspan="1">
							<input name="criterion-to" ng-model="criterion.to" type="text" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="1">
				<button ng-click="addQuestion()">+</button>
			</td>
			<td colspan="6">
				<b>คำถาม</b>
			</td>
		</tr>
		<tr ng-repeat="question in questionaire.questions" class="classified que">
			<td colspan="1" class="question"></td>
			<td colspan="6" style="padding: 0px">
				<table>
					<tr>
						<td colspan="1">ลำดับ</td>
						<td colspan="1">
							<input name="question-order" ng-model="question.order" type="text" />
						</td>
						<td colspan="1">ชนิด</td>
						<td colspan="1">
							<input name="question-type" ng-model="question.type" type="text" />
						</td>
						<td colspan="1">ฉลาก</td>
						<td colspan="1">
							<input name="question-label" ng-model="question.label" type="text" />
						</td>
					</tr>
					<tr>
						<td>ชื่อ</td>
						<td colspan="5">
							<input name="question-name" ng-model="question.name" type="text" />
						</td>
					</tr>
					<tr>
						<td>คำบรรยาย</td>
						<td colspan="5">
							<input name="question-description" ng-model="question.description" type="text" />
						</td>
					</tr>
					<tr>
						<td colspan="7" style="padding: 0px">
							<table>
								<tr>
									<td colspan="1"><button ng-click="addChoice(question)">+</button></td>
									<td colspan="6">
										<b>คำตอบ</b>
									</td>
								</tr>
								<tr ng-repeat="choice in question.choices" class="classified cho">
									<td colspan="1" class="choice">
									</td>
									<td colspan="6">
										<table>
											<tr>
												<td>ฉลาก</td>
												<td>
													<input name="choice-label" ng-model="choice.label" type="text" />
												</td>
												<td>คะแนน</td>
												<td>
													<input name="choice-value" ng-model="choice.value" type="text" />
												</td>
												<td>หมายเหตุ</td>
												<td>
													<input name="choice-note" ng-model="choice.note" type="text" />
												</td>
											</tr>
											<tr>
												<td colspan="1">ชื่อ</td>
												<td colspan="1">
													<input name="choice-name" ng-model="choice.name" type="text" />
												</td>
												<td colspan="1">คำบรรยาย</td>
												<td colspan="3">
													<input name="choice-description" ng-model="choice.description" type="text" />
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
@endsection