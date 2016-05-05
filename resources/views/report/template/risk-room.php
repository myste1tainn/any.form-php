<room class="col-xs-12 std-pad" 
	  ui-view="report.risk">

	<div class="col-xs-6"></div>
	<div class="col-xs-1 text-r	ight" style="margin-top: 6px">ชั้น</div>
	<div class="col-xs-2" style="margin-bottom: 20px">
		<select class="form-control"
				ng-model="class"
				ng-change="classChange()"
				ng-options="class as class.value for class in classes">
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

	<div class="col-xs-12 std-pad border-b">
		<h1 class="col-xs-6">ด้านการเรียน</h1>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b">
		<h3 class="col-xs-6">ด้านการสุขภาพ</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b l-border-l">
		<h3 class="col-xs-6">ด้านพฤติกรรมก้าวร้าว</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b">
		<h3 class="col-xs-6">ด้านเศรษฐกิจ</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b l-border-l">
		<h3 class="col-xs-6">ด้านความปลอดภัย</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b">
		<h3 class="col-xs-6">ด้านสารเสพติด</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b l-border-l">
		<h3 class="col-xs-6">ด้านพฤติกรรมทางเพศ</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b">
		<h3 class="col-xs-6">ด้านการติดเกม</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b l-border-l">
		<h3 class="col-xs-6">ด้านเครื่องมือสื่อสาร</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">10</h1>
			<div class="pull-left">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12">20</h1>
			<div class="pull-left">คน มีปัญหา</div>
		</div>
	</div>
	
</room>