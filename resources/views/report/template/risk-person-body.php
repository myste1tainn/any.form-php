<table class="risk-body">
	<tr>
		<th rowspan="2" style="width: 12%">รหัสประจำตัว</th>
		<th rowspan="2" style="width: 20%">ชื่อ</th>
		<th rowspan="2" style="width: 10%">ห้อง</th>
		<th rowspan="2" style="width: 10%">เลขที่</th>
		<th colspan="2" class="risk-count">จำนวนด้านที่เสี่ยง</th>
		<th rowspan="2" style="width: 12%">ความสามารถ</th>
		<th rowspan="2" style="width: 12%">ความพิการ</th>
	</tr>
	<tr>
		<th class="risk-count" style="width: 10%">เสี่ยง</th>
		<th class="risk-count" style="width: 10%">มีปัญหา</th>
	</tr>
	<tr ng-repeat="p in list.displays"
		ng-click="list.select(p)"
		ng-class="{'odd': ($index % 2 == 1)}">
		<td class="text-center">[[ p.identifier ]]</td>
		<td class="text-left">[[ p.firstname ]] [[ p.lastname ]]</td>
		<td class="text-center">[[ p.class ]]/[[ p.room ]]</td>
		<td class="text-center">[[ p.number ]]</td>
		<td class="text-center">[[ p.countRisk('high') ]]</td>
		<td class="text-center">[[ p.countRisk('veryHigh')]]</td>
		<td class="text-center">[[ p.hasTalent() ]]</td>
		<td class="text-center">[[ p.hasDisability() ]]</td>
	</tr>
</table>