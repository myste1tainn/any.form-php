<div class="row col-xs-11">
	<div class="col-xs-1 std-pad">
		<button ng-click="addQuestion()">+</button>
	</div>
	<div class="col-xs-1 std-pad">
		<b>คำถาม</b>
	</div>
	<div class="col-xs-10 std-pad">
		<button ng-repeat="question in form.questions"
				ng-click="showPage($index)"
				ng-class="{'danger' : ($index == currentPage) }">
			{{$index + 1}}
		</button>
	</div>
</div>
<div class="classified que col-xs-12 no-pad"
	 ng-repeat="question in form.questions"
	 ng-if="$index == currentPage">
	<div class="col col-xs-1 question"></div>
	<div class="col col-xs-11" style="padding: 0px">
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
					<form-choices></form-choices>
				</td>
			</tr>
		</table>
	</div>
</div>