<group-map class="col-xs-12">

	<!-- Group creation -->
	<div class="col-xs-4 no-pad">
		<div class="row report header" style="padding-bottom: 0px">
			<div class="col-xs-12 text-center no-margin std-pad std-margin-bottom noselect">
				<span>
					<span>กลุ่มคำถาม</span>
				</span>
			</div>
		</div>
		<group-form></group-form>
		<group-list></group-list>
	</div>

	<!-- Questions -->
	<div class="col-xs-8 border-l">
		<form-select></form-select>
		<div class="col-xs-12" ui-view="group"></div>
	</div>
</group-map>