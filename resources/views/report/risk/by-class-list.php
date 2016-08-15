<class class="col-xs-12 std-pad">

	<table class="form questions col-xs-12"
		   st-table="displayedResults"
		   st-safe-src="results">
		<tr >
			<th colspan="1">ชั้นปี</th>
			<th colspan="1">ความเสี่ยง</th>
			<th colspan="1">จำนวน (คน)</th>
			<th colspan="1">%</th>
			<th colspan="1">เฉลี่ยทั้งห้อง</th>
		</tr>
		<tbody ng-repeat="class in displayedResults">
			<tr ng-repeat="criterion in class.criteria">
				<td class="text-center col-xs-1"
					style="font-size: 4em; font-weight: 900; color: #1237BD"
					rowspan="{{ class.criteria.length }}"
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
					rowspan="{{ class.criteria.length }}"
					ng-if="$index == 0">
					{{ class.avgRisk }} ({{ class.avgValue }})
					<p style="font-size: 0.7" class="color-dominant">จากนักเรียนจำนวน {{ class.total }} คน</p>
				</td>
			</tr>
		</tbody>
	</table>
</class>