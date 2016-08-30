<table class="risk-body">
	<tr>
		<th rowspan="2" style="width: 12%">รหัสประจำตัว</th>
		<th rowspan="2" style="width: 20%">ชื่อ</th>
		<th rowspan="2" style="width: 10%">ห้อง</th>
		<th rowspan="2" style="width: 10%">เลขที่</th>
		<th colspan="2" class="risk-count">จำนวนข้อที่เสี่ยง/มีปัญหา</th>
		<th rowspan="2" style="width: 12%">ความสามารถ</th>
		<th rowspan="2" style="width: 12%">ความพิการ</th>
	</tr>
	<tr>
		<th class="risk-count" style="width: 10%">เสี่ยง</th>
		<th class="risk-count" style="width: 10%">มีปัญหา</th>
	</tr>
	<tr ng-repeat="p in results"
		ng-click="showDetail(p)"
		ng-class="{'odd': ($index % 2 == 1)}">
		<td class="text-center">{{ p.identifier }}</td>
		<td class="text-left">{{ p.firstname }} {{ p.lastname }}</td>
		<td class="text-center">{{ p.class }}/{{ p.room }}</td>
		<td class="text-center">{{ p.number }}</td>
		<td class="text-center">{{ p.risks.countHighRisk || 0}}</td>
		<td class="text-center">{{ p.risks.countVeryHighRisk || 0}}</td>
		<td class="text-center" ng-if="p.hasTalent()">
			<i class="fa fa-check-circle friendly" >
		</td>
		<td class="text-center" ng-if="!p.hasTalent()">
			<i class="fa fa-ban destructive" aria-hidden="true">
		</td>
		<td class="text-center" ng-if="p.hasDisability()">
			<i class="fa fa-exclamation-circle alarming" >
		</td>
		<td class="text-center" ng-if="!p.hasDisability()">
			<i class="fa fa-check-circle friendly" aria-hidden="true">
		</td>
	</tr>
</table>