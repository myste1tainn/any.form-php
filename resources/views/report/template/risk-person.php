<div class="row" ui-view="report.type.risk">

	<!-- Participant Information -->
	<div class="row border-top-bottom border-lightgray indent-left-1">
		<!-- <h4>ข้อมูลนักเรียน</h4> -->
		<div class="row">
			<h4 class="text-left" style="padding-left: 1em">
				[[participant.identifier]] 
				ชื่อนักเรียน [[participant.firstname]] [[participant.lastname]] - 
				ห้อง [[participant.class]]/[[participant.room]] 
				เลขที่ [[participant.number]]
			</h4>
			<h4 class="text-left" style="padding-left: 1em">
				ความสามารถพิเศษ: [[participant.talent]]
			</h4>
			<h4 class="text-left" style="padding-left: 1em">
				ความพิการอื่นๆ: [[participant.disabilities]]
				</h4>
		</div>
	</div>


	<!-- Participant Aspects -->
	<div class="col-xs-6" style="border-right: 1px solid lightgray">
		<h4>ข้อมูลความเสี่ยง</h4>
		<table class="risk">
			<tr>
				<td class="text-center normal">
					การเรียน
					<h1 class="normal" style="font-size:4em">
						[[participant.risks.study.length]]
					</h1>
					
				</td>
				<td class="text-center risk">
					สุขภาพ
					<h1 class="risk" style="font-size:4em">
						[[participant.risks.health.length]]
					</h1>
					
				</td>
				<td class="text-center risk">
					ความรุนแรง
					<h1 class="risk" style="font-size:4em">
						[[participant.risks.aggressiveness.length]]
					</h1>
					
				</td>
			</tr>
			<tr>
				<td class="text-center risk">
					เศรษฐกิจ
					<h1 class="risk" style="font-size:4em">
						[[participant.risks.economy.length]]
					</h1>
					
				</td>
				<td class="text-center problem">
					ความปลอดภัย
					<h1 class="problem" style="font-size:4em">
						[[participant.risks.security.length]]
					</h1>
					
				</td>
				<td class="text-center normal">
					สารเสพติด
					<h1 class="normal" style="font-size:4em">
						[[participant.risks.drugs.length]]
					</h1>
					
				</td>
			</tr>
			<tr>
				<td class="text-center problem">
					เพศ
					<h1 class="problem" style="font-size:4em">
						[[participant.risks.sexuality.length]]
					</h1>
					
				</td>
				<td class="text-center normal">
					ติดเกม
					<h1 class="normal" style="font-size:4em">
						[[participant.risks.games.length]]
					</h1>
					
				</td>
				<td class="text-center risk">
					เครื่องมือสื่อสาร
					<h1 class="risk" style="font-size:4em">
						[[participant.risks.electronics.length]]
					</h1>
					
				</td>
			</tr>
		</table>
	</div>

	<div class="col-xs-6">
		<h4>รายละเอียดความเสี่ยง</h4>
	</div>

</div>