<div class="row" ng-if="participant != null">

	<!-- Participant Information -->
	<div class="row border-tb border-lightgray">
		<!-- <h4>ข้อมูลนักเรียน</h4> -->
		<div class="row small-pad">
			<div class="col-xs-6">
				<div class="row indent-left-2">
					<p class="text-left color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						[[participant.identifier]] 
					</p>
					<p class="text-left" style="font-size: 1.7em; margin-bottom: 0px;">
						[[participant.firstname]] [[participant.lastname]]
					</p>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row text-center">
					<p class="text-left color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						ห้อง [[participant.class]]/[[participant.room]] 
					</p>
					<p class="text-left" style="font-size: 1.7em; margin-bottom: 0px;">
						เลขที่ [[participant.number]]
					</p>
				</div>
			</div>
		</div>
	</div>


	<!-- Participant Aspects -->
	<div class="col-xs-12 col-md-8 no-pad std-pad-left" 
		 style="border-right: 1px solid lightgray;">
		<h4 class="text-center std-pad no-margin">ข้อมูลความเสี่ยง</h4>
		<!-- <table class="risk">
			<tr>
				<td class="text-center rveryhigh" 
					colspan="2"
					ng-click="tab.selectAspect(participant.risks.aggressiveness)">
					
					<h1 style="font-size:4em" 
						data-type="สังคม">
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.health)">
					
					<h1 style="font-size:4em" 
						data-type="เพื่อน">
					</h1>
					
				</td>
			</tr>
			<tr>
				<td class="text-center rnormal" 
					ng-click="tab.selectAspect(participant.risks.study)">
					
					<h1 style="font-size:4em" 
						data-type="อารมณ์">
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.health)">
					
					<h1 style="font-size:4em" 
						data-type="เกเร">
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.aggressiveness)">
					
					<h1 style="font-size:4em" 
						data-type="สมาธิสั้น">
					</h1>
					
				</td>
			</tr>
		</table> -->

		<table class="sdq">
			<tr>
				<td class="text-center" ng-repeat="g in participant.groups">
					<h1 style="font-size:1.7em" 
						class="[[g.result.modifier]]"
						data-type="[[g.label]]">
						[[g.result.string]]
					</h1>
				</td>
			</tr>
		</table>

		<h4 class="col-xs-12 text-center">ความเรื้อรังของปัญหา</h4>
		<div class="col-xs-12 text-center text-xxxl border-tb">6-12 เดือน</div>

		<h4 class="col-xs-12 text-center std-pad no-margin border-b">ปัญหาทำให้ไม่สบายใจ</h4>
		<div class="col-xs-12 text-center text-xxxl ">ใช่</div>

	</div>

	<div class="col-xs-12 col-md-4 no-pad" 
		 style="border-right: 1px solid lightgray;">

		<h4 class="col-xs-12 text-center std-pad no-margin border-b">ปัญหารบกวนชีวิตประจำวัน</h4>
		<div class="col-xs-12">
			<p class="text-l">ความเป็นอยูที่บ้าน</p>
			<p class="text-l">การคบเพื่อน</p>
			<p class="text-l">การเรียนในห้องเรียน</p>
			<p class="text-l">กิจกรรมยามว่าง</p>
		</div>
		
	</div>

</div>

<div class="col-xs-12 text-center no-border flex-container flex-center" 
	 style="height: 82.5vh" 
	 ng-if="participant == null">
	<h2 class="col-xs-12 text-center">
		[[ errorMessage ]]
	</h2>
</div>