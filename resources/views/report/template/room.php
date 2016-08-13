<room class="col-xs-12 std-pad">
	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control" 
				ng-model="nav.year"
				ng-change="nav.yearChange()"
				ng-options="y as y.value for y in nav.years">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ปีการศึกษา</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="nav.room"
				ng-change="nav.roomChange()"
				ng-options="c as c.value for c in nav.rooms">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ห้อง</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="nav.class"
				ng-change="nav.classChange()"
				ng-options="c as c.value for c in nav.classes">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ชั้น</div>

	<table class="form questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1" class="theme-border">ห้อง</th>
			<th colspan="1" class="theme-border">ความเสี่ยง</th>
			<th colspan="1" class="theme-border">จำนวน (คน)</th>
			<th colspan="1" class="theme-border">%</th>
			<th colspan="1" class="theme-border">เฉลี่ยทั้งห้อง</th>
		</tr>
		<tbody ng-repeat="room in displayedResults">
			<tr ng-repeat="criterion in room.criteria">
				<td class="text-center col-xs-1"
					style="font-size: 4em; font-weight: 900; color: #1237BD"
					rowspan="{{ room.criteria.length }}"
					ng-if="$index == 0">
					{{ criterion.room }}
					<p style="font-size: 0.7">ชั้นปีที่ {{ criterion.class }}</p>
				</td>
				<td class="text-left col-xs-2">
					{{ criterion.label }}
				</td>
				<td class="text-center col-xs-1">
					{{ criterion.number || 0 }}
				</td>
				<td class="text-center col-xs-1">
					{{ criterion.percent }}
				</td>
				<td class="text-center theme-border col-xs-1 bgcolor-secondary color-accent1"
					style="font-size: 2em; font-weight: 900; color: #1237BD"
					rowspan="{{ room.criteria.length }}"
					ng-if="$index == 0">
					{{ room.avgRisk }} ({{ room.avgValue }})
					<p style="font-size: 0.7" class="color-dominant">จากนักเรียนจำนวน {{ room.total }} คน</p>
				</td>
			</tr>
		</tbody>
	</table>
</room>