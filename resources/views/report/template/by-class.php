<room class="col-xs-12 std-pad">

	<table class="form questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1" class="theme-border">ชั้นปี</th>
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
					{{ criterion.class }}
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