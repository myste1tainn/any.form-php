<div class="row col-xs-12">
	<div class="std-pad col-xs-1">
		<button ng-click="addCriterion()">+</button>
	</div>
	<div class="std-pad col-xs-1">
		<b>เกณฑ์</b>
	</div>
	<div class="col-xs-10 std-pad">
		<button ng-repeat="criterion in questionaire.criteria"
				ng-click="showCriterion($index)"
				ng-class="{'danger' : ($index == currentCriterion) }">
			[[$index + 1]]
		</button>
	</div>
</tr>
<div class="no-pad classified cri col-xs-12"
	 ng-repeat="criterion in questionaire.criteria"
	 ng-if="currentCriterion == $index">
	<div class="col col-xs-1 criterion"></div>
	<div class="col col-xs-11" colspan="6" style="padding: 0px">
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