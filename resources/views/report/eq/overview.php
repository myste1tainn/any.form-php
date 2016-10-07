<div class="col-xs-12 no-pad" ng-if="results != null">

	<!-- Overall -->
	<table class="col-xs-12 eq std-pad-left">
		<tr>
			<th colspan="3" class="text-center">ดี</th>
			<th rowspan="3" class="no-border">&nbsp;</th>
			<th colspan="3" class="text-center">เก่ง</th>
			<th rowspan="3" class="no-border">&nbsp;</th>
			<th colspan="3" class="text-center">สุข</th>
		</tr>
		<tr class="no-border">
			<td><div class="dot center bg-destructive">&nbsp;</div></td>
			<td><div class="dot center bg-alarming">&nbsp;</div></td>
			<td><div class="dot center bg-friendly">&nbsp;</div></td>
			<td><div class="dot center bg-destructive">&nbsp;</div></td>
			<td><div class="dot center bg-alarming">&nbsp;</div></td>
			<td><div class="dot center bg-friendly">&nbsp;</div></td>
			<td><div class="dot center bg-destructive">&nbsp;</div></td>
			<td><div class="dot center bg-alarming">&nbsp;</div></td>
			<td><div class="dot center bg-friendly">&nbsp;</div></td>
		</tr>
		<tr>
			<td colspan="3" class="no-pad">
				<count-group name="good"></count-group>
			</td>
			<td colspan="3" class="no-pad">
				<count-group name="skilled"></count-group>
			</td>
			<td colspan="3" class="no-pad">
				<count-group name="happy"></count-group>
			</td>
		</tr>
	</table>

	<div class="col-xs-12">
		&nbsp;
	</div>

	<!-- Participant Aspects -->
	<div class="col-xs-12 no-pad" 
		 style="border-right: 1px solid lightgray;">
		<table class="col-xs-12 eq std-pad-left">
			<tr class="measure">
				<th style="width: 25%"></th><th></th><th></th>
				<th style="width: 25%" colspan="3">กลุ่มระดับ (คน)</th>
				<th class="y"><div class="pull-left">0</div></th>
				<th class="y"><div class="pull-left">5</div></th>
				<th class="y"><div class="pull-left">10</div></th>
				<th class="y"><div class="pull-left">15</div></th>
				<th class="y"><div class="pull-left">20</div></th>
				<th class="y"><div class="pull-left">25</div></th>
			</tr>
			<tr class="tick">
				<th colspan="3">ด้าน</th>
				<th class="text-center">
					<div class="dot center bg-destructive">&nbsp;</div>
				</th>
				<th class="text-center">
					<div class="dot center bg-alarming">&nbsp;</div>
				</th>
				<th class="text-center">
					<div class="dot center bg-friendly">&nbsp;</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
				<th class="y">
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
					<div class="col-xs-3 dash no-pad no-margin">|</div>
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">1.1 ควบคุมอารมณ์</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="อารมณ์"></count-group>
				</td>
				<td colspan="6">
					<graph name="good.อารมณ์" participant="results"></graph>
				</td>
			</tr>

			<!-- GOOD -->
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">1.2 เห็นใจผู้อื่น</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="เห็นใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="good.เห็นใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">1.3 รับผิดชอบ</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="รับผิดชอบ"></count-group>
				</td>
				<td colspan="6">
					<graph name="good.รับผิดชอบ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">2.1 มีแรงจูงใจ</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="แรงจูงใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="skilled.แรงจูงใจ" participant="results"></graph>
				</td>
			</tr>

			<!-- SKILLED -->
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">2.2 ตัดสินใจและแก้ปัญหา</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="การตัดสินใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="skilled.การตัดสินใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">2.3 สัมพันธภาพกับผู้อื่น</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="สัมพันธ์ภาพ"></count-group>
				</td>
				<td colspan="6">
					<graph name="skilled.สัมพันธ์ภาพ" participant="results"></graph>
				</td>
			</tr>

			<!-- HAPPNINESS -->
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">3.1 ภูมิใจใจตนเอง</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="ภูมิใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="happy.ภูมิใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">3.2 พึงพอใจในชีวิต</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="พอใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="happy.พอใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div class="pull-left std-pad-left">3.3 สุขสงบทางใจ</div>
				</td>
				<td colspan="3" class="no-pad">
					<count-group name="สุขใจ"></count-group>
				</td>
				<td colspan="6">
					<graph name="happy.สุขใจ" participant="results"></graph>
				</td>
			</tr>
		</table>

	</div>

</div>

<div class="col-xs-12 text-center no-border flex-container flex-center" 
	 style="height: 82.5vh" 
	 ng-if="results == null">
	<h2 class="col-xs-12 text-center">
		{{ errorMessage }}
	</h2>
</div>