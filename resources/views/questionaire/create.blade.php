@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<questionaire-create class="container">
	<h3>สร้างแบบฟอร์ม</h3>
	<hr />
	<table>
		<tr>
			<td colspan="1">ชื่อ</td>
			<td colspan="6">
				<input name="name" ng-model="questionaire.name" type="text" />
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;">
				มีหัวตาราง
				<input type="checkbox" header-toggler />
				<button ng-click="addHeaderRow()">+</button>
			</td>
			<td colspan="6">
				<table ng-show="hasHeader()" ng-repeat="r in questionaire.header.rows">
					<tr>
						<td>แถวที่ [[ $index+1 ]]</td>
					</tr>
					<tr ng-repeat="c in r.cols">
						<td>
							คอลัมน์ที่ [[ $index+1 ]]
							<button ng-click="addHeaderCol(r)">+</button>
						</td>
						<td>
							หัว
							<input ng-model="c.label" />
						</td>
						<td>
							Column span
							<input ng-model="c.colspan" />
						</td>
						<td>
							Row span
							<input ng-model="c.rowspan" />
						</td>
					</tr>
				</table>
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
									<td colspan="1">
										<button ng-click="addChoice(question)">+</button>
										<button ng-click="toggleFold(question)">==</button>
									</td>
									<td colspan="6">
										<b>คำตอบ</b>
										<input question-header-toggler
											   ng-model="question.hasHeader"
											   ng-change="toggleQuestionHeader(question)"
											   type="checkbox" /> มีหัวตาราง
										<button ng-click="addQuestionHeaderRow(question)">+</button>
										<table ng-show="question.hasHeader" ng-repeat="r in question.meta.header.rows">
											<tr>
												<td>แถวที่ [[ $index+1 ]]</td>
											</tr>
											<tr ng-repeat="c in r.cols">
												<td>
													คอลัมน์ที่ [[ $index+1 ]]
													<button ng-click="addHeaderCol(r)">+</button>
												</td>
												<td>
													หัว
													<input ng-model="c.label" />
												</td>
												<td>
													Column span
													<input ng-model="c.colspan" />
												</td>
												<td>
													Row span
													<input ng-model="c.rowspan" />
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr ng-repeat="choice in question.choices" class="classified cho" ng-if="!question.folded">
									<td colspan="1" class="choice">
										<input choice-enabled-toggler
											   ng-model="choice.enabled"
											   ng-change="toggleEnabled(choice)"
											   ng-checked="choice.enabled == 1"
											   type="checkbox" /> enabled
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
	<button ng-click="submit()" style="float: right; padding: 5px; margin: 10px">Submit</button>
</questionaire-create>
@endsection