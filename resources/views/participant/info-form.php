<table class="name col-xs-12">
	<tr>
		<td class="" style="width: 10em">
			<input 	class="text-center" 
					type="number" 
					placeholder="หมายเลขประจำตัว"
					ng-model="participant.identifier" />
		</td>
		<td class="">
			<input ng-model="participant.firstname"
				   placeholder="ชื่อ" />
		</td>
		<td class="">
			<input ng-model="participant.lastname"
				   placeholder="สกุล" />
		</td>
		<td class="" style="width:6%">
			<input class="text-center" 
				   ng-model="participant.number"
				   placeholder="เลขที่" />
		</td>
		<td class="" style="width:6%">
			<input class="text-center" 
				   ng-model="participant.class"
				   placeholder="ชั้นปี" />
		</td>
		<td class="" style="width:6%">
			<input class="text-center" 
				   ng-model="participant.room"
				   placeholder="ห้อง" />
		</td>
		<td class="" style="width:10%">
			<input class="text-center" 
				   ng-model="participant.academicYear"
				   placeholder="ปีการศึกษา" />
		</td>
	</tr>
</table>