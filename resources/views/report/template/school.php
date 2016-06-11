<school class="col-xs-12 std-pad">

	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control" 
				ng-model="nav.year"
				ng-change="nav.yearChange()"
				ng-options="y as y.value for y in nav.years">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ปีการศึกษา</div>

	<table class="form questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1">ความเสี่ยง</th>
			<th colspan="1">จำนวน (คน)</th>
			<th colspan="1">%</th>
			<th colspan="1">เฉลี่ยทั้งโรงเรียน</th>
		</tr>
		<tbody ng-repeat="school in displayedResults">
			<tr ng-repeat="criterion in school.criteria">
				<td class="text-left col-xs-2">
					[[ criterion.label ]]
				</td>
				<td class="text-center col-xs-1">
					[[ criterion.number || 0 ]]
				</td>
				<td class="text-center col-xs-1">
					[[ criterion.percent ]]
				</td>
				<td class="text-center theme-border col-xs-1 bgcolor-secondary color-accent1"
					style="font-size: 2em; font-weight: 900; color: #1237BD"
					rowspan="[[ school.criteria.length ]]"
					ng-if="$index == 0">
					[[ school.avgRisk ]] ([[ school.avgValue ]])
					<p style="font-size: 0.7" class="color-dominant">จากนักเรียนจำนวน [[ school.total ]] คน</p>
				</td>
			</tr>
		</tbody>
	</table>
</school>