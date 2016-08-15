<div class="std-pad-top">
	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control" 
				ng-model="year"
				ng-change="yearChange()"
				ng-options="y as y.value for y in years">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ปีการศึกษา</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="room"
				ng-change="roomChange()"
				ng-options="c as c.value for c in rooms">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ห้อง</div>


	<div class="pull-right" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="class"
				ng-change="classChange()"
				ng-options="c as c.value for c in classes">
		</select>
	</div>
	<div class="pull-right text-right space-left space-right" style="margin-top: 6px">ชั้น</div>
</div>