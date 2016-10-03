<div class="col-xs-12 no-pad" ng-if="results != null">

	<!-- Participant Information -->
	<div class="col-xs-12 border-tb border-lightgray">
		<!-- <h4>ข้อมูลนักเรียน</h4> -->
		<div class="row small-pad">
			<div class="col-xs-4">
				<div class="row indent-left-2">
					<p class="text-left one-line color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						{{results.identifier}} 
					</p>
					<p class="text-left one-line" style="font-size: 1.7em; margin-bottom: 0px;">
						{{results.firstname}} {{results.lastname}}
					</p>
				</div>
			</div>
			<div class="col-xs-2">
				<div class="row text-center">
					<p class="text-left one-line color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						ห้อง {{results.class}}/{{results.room}} 
					</p>
					<p class="text-left one-line" style="font-size: 1.7em; margin-bottom: 0px;">
						เลขที่ {{results.number}}
					</p>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<p class="text-right color-highlight one-line std-pad-right"
					   style="font-size: 1.2em; margin-bottom: 0px; margin-top: 20px;">
						ดี
					</p>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<div class="circle" style="width: 16px; height: 16px; margin-top: 34px;"
					 ng-class="{'bg-destructive' : results.levelOf('good') == 0, 'bg-alarming' : results.levelOf('good') == 1, 'bg-friendly' : results.levelOf('good') == 2}">
				</div>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<p class="text-right color-highlight one-line std-pad-right"
					   style="font-size: 1.2em; margin-bottom: 0px; margin-top: 20px;">
						เก่ง
					</p>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<div class="circle" style="width: 16px; height: 16px; margin-top: 34px;"
					 	  ng-class="{'bg-destructive' : results.levelOf('skilled') == 0, 'bg-alarming' : results.levelOf('skilled') == 1, 'bg-friendly' : results.levelOf('skilled') == 2}">
					</div>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<p class="text-right color-highlight one-line std-pad-right"
					   style="font-size: 1.2em; margin-bottom: 0px; margin-top: 20px;">
						สุข
					</p>
				</div>
			</div>
			<div class="col-xs-1">
				<div class="row text-center">
					<div class="circle" style="width: 16px; height: 16px; margin-top: 34px;"
					 	  ng-class="{'bg-destructive' : results.levelOf('happy') == 0, 'bg-alarming' : results.levelOf('happy') == 1, 'bg-friendly' : results.levelOf('happy') == 2}">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Participant Aspects -->
	<div class="col-xs-12 no-pad" 
		 style="border-right: 1px solid lightgray;">
		<h4 class="text-center std-pad no-margin">กราฟความฉลาดทางอารมณ์</h4>

		<table class="col-xs-12 eq std-pad-left">
			<tr class="measure">
				<th></th><th></th><th></th>
				<th></th><th></th><th></th>
				<th class="y"><div class="pull-left">0</div></th>
				<th class="y"><div class="pull-left">5</div></th>
				<th class="y"><div class="pull-left">10</div></th>
				<th class="y"><div class="pull-left">15</div></th>
				<th class="y"><div class="pull-left">20</div></th>
				<th class="y"><div class="pull-left">25</div></th>
			</tr>
			<tr class="tick">
				<th colspan="6" style="width: 50%">ช่วงคะแนนปกติของแต่ละด้าน</th>
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
				<td colspan="6">
					<div class="pull-left std-pad-left">1.1 ควบคุมอารมณ์</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (13-17)</div>
				</td>
				<td colspan="6">
					<graph name="good.อารมณ์" participant="results"></graph>
				</td>
			</tr>

			<!-- GOOD -->
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">1.2 เห็นใจผู้อื่น</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (16-20)</div>
				</td>
				<td colspan="6">
					<graph name="good.เห็นใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">1.3 รับผิดชอบ</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (16-22)</div>
				</td>
				<td colspan="6">
					<graph name="good.รับผิดชอบ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">2.1 มีแรงจูงใจ</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (14-20)</div>
				</td>
				<td colspan="6">
					<graph name="skilled.แรงจูงใจ" participant="results"></graph>
				</td>
			</tr>

			<!-- SKILLED -->
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">2.2 ตัดสินใจและแก้ปัญหา</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (13-19)</div>
				</td>
				<td colspan="6">
					<graph name="skilled.การตัดสินใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">2.3 สัมพันธภาพกับผู้อื่น</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (14-20)</div>
				</td>
				<td colspan="6">
					<graph name="skilled.สัมพันธ์ภาพ" participant="results"></graph>
				</td>
			</tr>

			<!-- HAPPNINESS -->
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">3.1 ภูมิใจใจตนเอง</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (9-13)</div>
				</td>
				<td colspan="6">
					<graph name="happy.ภูมิใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">3.2 พึงพอใจในชีวิต</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (16-22)</div>
				</td>
				<td colspan="6">
					<graph name="happy.พอใจ" participant="results"></graph>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="pull-left std-pad-left">3.3 สุขสงบทางใจ</div>
					<div class="pull-right std-pad-right">ช่วงคะแนนปกติ = (15-21)</div>
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