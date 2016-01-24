@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container form-list">
	<h3>เลือกแบบฟอร์มที่ต้องการใช้งาน</h3>
	<hr />
	<ul class="col-xs-12">
		<li ng-repeat="questionaire in questionaires">
			<a href="{{ url('/questionaire/[[ questionaire.id ]]') }}">
				[[ questionaire.name ]]
			</a>
		</li>
	</ul>
</div>
@endsection
