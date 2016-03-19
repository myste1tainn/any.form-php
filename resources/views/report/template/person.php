<table class="form questions" 
	   st-table="displayedResults" 
	   st-safe-src="results"
	   ui-view="report.type.form">
	<thead>
		<tr>
			<td colspan="5">
				<input st-search="" 
					   class="form-control" 
					   placeholder="ค้นหา" 
					   type="text"/>
			</td>
		</tr>
		<tr>
			<th st-sort="participant.firstname">ชื่อ</th>
			<th st-sort="participant.class">ชั้น</th>
			<th st-sort="participant.room">ห้อง</th>
			<th st-sort="value">ระดับความเสี่ยง</th>
		</tr>
	</thead>
	<tr ng-repeat="r in displayedResults">
		<td class="text-left">
			[[ r.participant.firstname ]] [[ r.participant.lastname ]]
		</td>
		<td class="text-center">[[ r.participant.class ]]</td>
		<td class="text-center">[[ r.participant.room ]]</td>
		<td>[[ r.risk ]] ([[ r.value ]])</td>
	</tr>
</table>