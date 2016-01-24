<div class="col-xs-12 std-pad">
	<table class="questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1">ชั้น</th>
			<th colspan="1">ห้อง</th>
			<th colspan="1">ความเสี่ยง</th>
			<th colspan="1">เฉลี่ยทั้งชั้นปี</th>
		</tr>
		<tbody ng-repeat="rr in displayedResults">
			<tr>
				<td class="text-center col-xs-1"
					style="font-size: 4em; font-weight: 900; color: #075083"
					rowspan="[[ rr.results.length+1 ]]">
					[[ rr.class ]]
				</td>
			</tr>
			<tr ng-repeat="r in rr.results">
				<td class="text-center col-xs-1">
					[[ r.room ]]
				</td>
				<td class="text-left col-xs-8">
					[[ r.risk ]] ([[ r.value ]])
				</td>
				<td class="text-center col-xs-2"
					style="font-size: 2em; font-weight: 900; color: #075083"
					ng-if="$index == 0"
					rowspan="[[ rr.results.length+1 ]]">
					[[ rr.avgRisk ]] ([[ rr.avgValue ]])
				</td>
			</tr>
		</tbody>
	</table>
</div>