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
		<tr>
			<th rowspan="2" colspan="2">
				อาการพฤติกรรมหรือความรู้สึก
			</th>
			<th colspan="4">
				ระดับอาการ
			</th>
		</tr>
		<tr>
			<th>ไม่เคยเลย</th>
			<th>เป็นครั้งคราว</th>
			<th>เป็นบ่อยๆ</th>
			<th>เป็นประจำ</th>
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