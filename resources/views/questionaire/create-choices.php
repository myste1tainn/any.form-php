<table>
	<tr>
		<td colspan="1" style="width:10%">
			<button ng-click="addChoice(question)">+</button>
			<button ng-click="toggleFold(question)">==</button>
		</td>
		<td colspan="6" style="width:90%">
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
	<tr ng-repeat="choice in question.choices" 
		class="classified cho" 
		ng-if="!question.folded">

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
					<td>ประเภท</td>
					<td>
						<input name="choice-type" ng-model="choice.type" type="text" />
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
					<td colspan="5">
						<input name="choice-description" ng-model="choice.description" type="text" />
					</td>
				</tr>
			</table>

			<questionaire-additional-inputs></questionaire-additional-inputs>
			<questionaire-subchoices></questionaire-subchoices>
		</td>

	</tr>
</table>