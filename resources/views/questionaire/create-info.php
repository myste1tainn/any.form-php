<div class="std-pad col-xs-12">
	<div class="col-xs-1">
		ชื่อ
	</div>
	<div class="col-xs-11">
		<input class="col-xs-8" name="name" ng-model="questionaire.name" type="text" />
		<input class="col-xs-2 col-xs-offset-1" type="number" ng-model="questionaire.level" value="0" />
	</div>
</div>
<div class="std-pad col-xs-12">
	<div class="col col-xs-11 col-xs-offset-1" style="vertical-align: top;">
		มีหัวตาราง
		<input type="checkbox" header-toggler />
		<button ng-click="addHeaderRow()">+</button>
	</div>
	<div class="col col-xs-11 col-xs-offset-1">
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
	</div>
</div>