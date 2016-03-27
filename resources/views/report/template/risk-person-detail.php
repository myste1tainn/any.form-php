<div class="row" ui-view="risk-main">

	<!-- Participant Information -->
	<div class="row border-top-bottom border-lightgray">
		<!-- <h4>ข้อมูลนักเรียน</h4> -->
		<div class="row small-pad">
			<div class="col-xs-4">
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
			<div class="col-xs-2">
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
			<div class="col-xs-3">
				<div class="row text-center">
					<p class="text-left color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						ความสามารถพิเศษ
					</p>
					<p class="text-left" style="font-size: 1.7em; margin-bottom: 0px;">
						[[participant.talent]]
					</p>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="row text-center">
					<p class="text-left color-highlight"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						ความพิการอื่นๆ
					</p>
					<p class="text-left" style="font-size: 1.7em; margin-bottom: 0px;">
						[[participant.disabilities]]
					</p>
				</div>
			</div>
		</div>
	</div>


	<!-- Participant Aspects -->
	<div class="col-xs-12 col-md-6 no-pad std-pad-left" 
		 style="border-right: 1px solid lightgray;">
		<h4 class="text-center">ข้อมูลความเสี่ยง</h4>
		<table class="risk">
			<tr>
				<td class="text-center rnormal" 
					ng-click="tab.selectAspect(participant.risks.study)">
					
					<h1 class="rnormal" 
						style="font-size:4em" 
						data-type="การเรียน"
						ng-class="{'selected':tab.isSelected(participant.risks.study)}">
						[[
						participant.risks.study.high.length +
						participant.risks.study.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.health)">
					
					<h1 class="rveryhigh" 
						style="font-size:4em" 
						data-type="สุขภาพ"
						ng-class="{'selected':tab.isSelected(participant.risks.health)}">
						[[
						participant.risks.health.high.length +
						participant.risks.health.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.aggressiveness)">
					
					<h1 class="rveryhigh" 
						style="font-size:4em" 
						data-type="ความรุนแรง"
						ng-class="{'selected':tab.isSelected(participant.risks.aggressiveness)}">
						[[
						participant.risks.aggressiveness.high.length +
						participant.risks.aggressiveness.veryHigh.length
						]]
					</h1>
					
				</td>
			</tr>
			<tr>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.economy)">
					
					<h1 class="rveryhigh" 
						style="font-size:4em" 
						data-type="เศรษฐกิจ"
						ng-class="{'selected':tab.isSelected(participant.risks.economy)}">
						[[
						participant.risks.economy.high.length +
						participant.risks.economy.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rhigh" 
					ng-click="tab.selectAspect(participant.risks.security)">
					
					<h1 class="rhigh" 
						style="font-size:4em" 
						data-type="ความปลอดภัย"
						ng-class="{'selected':tab.isSelected(participant.risks.security)}">
						[[
						participant.risks.security.high.length +
						participant.risks.security.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rnormal" 
					ng-click="tab.selectAspect(participant.risks.drugs)">
					
					<h1 class="rnormal" 
						style="font-size:4em" 
						data-type="สารเสพติด"
						ng-class="{'selected':tab.isSelected(participant.risks.drugs)}">
						[[
						participant.risks.drugs.high.length +
						participant.risks.drugs.veryHigh.length
						]]
					</h1>
					
				</td>
			</tr>
			<tr>
				<td class="text-center rhigh" 
					ng-click="tab.selectAspect(participant.risks.sexuality)">
					
					<h1 class="rhigh" 
						style="font-size:4em" 
						data-type="เพศ"
						ng-class="{'selected':tab.isSelected(participant.risks.sexuality)}">
						[[
						participant.risks.sexuality.high.length +
						participant.risks.sexuality.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rnormal" 
					ng-click="tab.selectAspect(participant.risks.games)">
					
					<h1 class="rnormal" 
						style="font-size:4em" 
						data-type="ติดเกม"
						ng-class="{'selected':tab.isSelected(participant.risks.games)}">
						[[
						participant.risks.games.high.length +
						participant.risks.games.veryHigh.length
						]]
					</h1>
					
				</td>
				<td class="text-center rveryhigh" 
					ng-click="tab.selectAspect(participant.risks.electronics)">
					
					<h1 class="rveryhigh" 
						style="font-size:4em" 
						data-type="เครื่องมือสื่อสาร"
						ng-class="{'selected':tab.isSelected(participant.risks.electronics)}">
						[[
						participant.risks.electronics.high.length +
						participant.risks.electronics.veryHigh.length
						]]
					</h1>
					
				</td>
			</tr>
		</table>
	</div>

	<!-- Apsect Views -->
	<div class="col-xs-12 col-md-6"
		 ui-view="risk-aspect-detail">
		<div class="vertical-align text-center anim-fade"
			 ng-if="!tab.selectedAspect">
			<h4 class="color-lowlight" 
				style="margin:auto;">
				กรุณาเลือกด้าน<br/>
				เพื่อดูรายละเอียดความเสี่ยง
			</h4>
		</div>
		<div class="anim-fade"
			 ng-if="tab.selectedAspect">
			 <h4 class="text-center">รายละเอียดความเสี่ยง</h4>
			<div ng-if="tab.selectedAspect.high.length == 0 && tab.selectedAspect.veryHigh.length == 0">
				<h1 class="auto-margin text-center" style="color: green">
					ปกติ
				</h1>
			</div>
			<div ng-if="tab.selectedAspect.high.length > 0 || tab.selectedAspect.veryHigh.length > 0">
				<ul ng-if="tab.selectedAspect.high.length > 0">
					<div class="color-accent">เสี่ยง</div>
					<li ng-repeat="item in tab.selectedAspect.high">
						[[item.name]]
					</li>
				</ul>
				<ul ng-if="tab.selectedAspect.veryHigh.length > 0"> 
					<div class="color-accent">มีปัญหา</div>
					<li ng-repeat="item in tab.selectedAspect.veryHigh">
						[[item.name]]
					</li>
				</ul>
			</div>
		</div>
	</div>

</div>