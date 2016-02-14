<room class="col-xs-12 std-pad">

	<div class="col-xs-6"></div>
	<div class="col-xs-1 text-right" style="margin-top: 6px">ชั้น</div>
	<div class="col-xs-2" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="class"
				ng-change="classChange()"
				ng-options="c as c.value for c in classes">
		</select>
	</div>
	<div class="col-xs-1 text-right" style="margin-top: 6px">ห้อง</div>
	<div class="col-xs-2" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="room"
				ng-change="roomChange()"
				ng-options="r as r.value for r in rooms">
		</select>
	</div>

	<table class="form questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1">ห้อง</th>
			<th colspan="1">ความเสี่ยง</th>
			<th colspan="1">จำนวน (คน)</th>
			<th colspan="1">%</th>
			<th colspan="1">เฉลี่ยทั้งห้อง</th>
		</tr>
		<tbody ng-repeat="room in displayedResults">
			<tr ng-repeat="criterion in room.criteria">
				<td class="text-center col-xs-1"
					style="font-size: 4em; font-weight: 900; color: #075083"
					rowspan="[[ room.criteria.length ]]"
					ng-if="$index == 0">
					[[ criterion.room ]]
					<p style="font-size: 0.7">ชั้นปีที่ [[ criterion.class ]]</p>
				</td>
				<td class="text-left col-xs-2">
					[[ criterion.label ]]
				</td>
				<td class="text-center col-xs-1">
					[[ criterion.number || 0 ]]
				</td>
				<td class="text-center col-xs-1">
					[[ criterion.percent ]]
				</td>
				<td class="text-center col-xs-1"
					style="font-size: 2em; font-weight: 900; color: #075083"
					rowspan="[[ room.criteria.length ]]"
					ng-if="$index == 0">
					[[ room.avgRisk ]] ([[ room.avgValue ]])
					<p style="font-size: 0.7">จากนักเรียนจำนวน [[ room.total ]] คน</p>
				</td>
			</tr>
		</tbody>
	</table>
</room>