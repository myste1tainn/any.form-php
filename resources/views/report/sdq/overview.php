<div class="col-xs-12 border-b no-pad container-flex flex-center" 
	 ng-repeat="group in results">

	<div class="col-xs-6">
		{{ group.name }}
	</div>
	<div class="col-xs-2" 
		 ng-repeat="criterion in group.criteria">
		<span class="col-xs-12 small-pad-top small-pad-left"
			  ng-class="{'friendly' : criterion.label == 'ปกติ' || criterion.label == 'เป็นจุดแข็ง',
						 'alarming' : criterion.label == 'เสี่ยง',
						 'destructive' : criterion.label == 'มีปัญหา' || criterion.label == 'ไม่มีจุดแข็ง'}">
			{{ criterion.label }}
		</span>
		<span class="col-xs-12 small-pad">
			{{ criterion.count || 0 }}
		</span>
	</div>

</div>