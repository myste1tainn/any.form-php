@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container do">

	<h3>[[ questionaire.name ]]</h3>
	<hr />

	<div class="col-xs-12" style="padding-right: 0">
		<table class="name col-xs-4 pull-right">
			<tr>
				<td class="text-right">หมายเลขประจำตัว</td>
				<td style="padding-right: 0">
					<input 	class="text-center" 
							type="number" 
							ng-model="participant.identifier" />
				</td>
				<!-- <td>ชื่อ</td>
				<td>
					<input ng-model="participant.name" />
				</td>
				<td>ชั้นปี</td>
				<td>
					<input ng-model="participant.class" />
				</td>
				<td>ห้อง</td>
				<td>
					<input ng-model="participant.room" />
				</td> -->
			</tr>
		</table>
	</div>

	<table class="questions">
		<tr ng-repeat="r in questionaire.header.rows">
			<th ng-repeat="c in r.cols"
				rowspan="[[ c.rowspan ]]" 
				colspan="[[ c.colspan ]]">
				[[ c.label ]]
			</th>
		</tr>
		<tr ng-repeat="q in questionaire.questions">
			<td class="text-right">[[ q.label ]]</td>
			<td class="text-left">[[ q.name ]]</td>
			<td ng-repeat="c in q.choices" 
				ng-class="{'selected' : isChoosen(q, c)}"
				ng-click="toggleChoose(q, c)">
			</td>
		</tr>
	</table>

	<button type="submit" 
			ng-click="submit()"
			style="margin-bottom: 100px"
			class="pull-right std-pad std-margin min-w-100">
		ส่ง
	</button>
</div>
@endsection