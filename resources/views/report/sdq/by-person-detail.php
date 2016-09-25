<div class="col-xs-12" ng-if="results != null">

	<!-- Participant Information -->
	<div class="row border-tb border-lightgray">
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
			<div class="col-xs-6">
				<div class="row text-center">
					<p class="text-left color-highlight one-line"
					   style="font-size: 1.2em; margin-bottom: -20px; padding-left: 2px; margin-top: 5px;">
						เพิ่มเติม
					</p>
					<p class="text-left one-line" style="font-size: 1.7em; margin-bottom: 0px;">
						{{ results.comments }}
					</p>
				</div>
			</div>
		</div>
	</div>


	<!-- Participant Aspects -->
	<div class="col-xs-12 col-md-8 no-pad std-pad-left" 
		 style="border-right: 1px solid lightgray;">
		<h4 class="text-center std-pad no-margin">ข้อมูลความเสี่ยง</h4>

		<table class="sdq">
			<tr>
				<td class="text-center" ng-repeat="g in results.groups">
					<h1 style="font-size:1.7em" 
						class="{{g.result.modifier}}"
						data-type="{{g.label}}">
						{{g.result.string}}
					</h1>
				</td>
			</tr>
		</table>

		<h4 class="col-xs-12 text-center">ความเรื้อรังของปัญหา</h4>
		<div class="col-xs-12 text-center text-xxxl border-tb">{{ results.chronic }}</div>

		<h4 class="col-xs-12 text-center std-pad no-margin border-b">ปัญหาทำให้ไม่สบายใจ</h4>
		<div class="col-xs-12 text-center text-xxxl ">{{ results.notease }}</div>

	</div>

	<div class="col-xs-12 col-md-4 no-pad" 
		 style="border-right: 1px solid lightgray;">

		<h4 class="col-xs-12 text-center std-pad no-margin border-b">ปัญหารบกวนชีวิตประจำวัน</h4>
		<div class="col-xs-12">
			<div ng-repeat="problem in results.lifeProblems">
				<span class="text-normal col-xs-6 std-pad text-left">{{problem.name}}</span>
				<span class="text-normal col-xs-6 std-pad text-right">{{problem.label}}</span>
			</div>
		</div>
		
	</div>

</div>

<div class="col-xs-12 text-center no-border flex-container flex-center" 
	 style="height: 82.5vh" 
	 ng-if="results == null">
	<h2 class="col-xs-12 text-center">
		{{ errorMessage }}
	</h2>
</div>