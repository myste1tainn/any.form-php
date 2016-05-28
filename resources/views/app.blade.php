<?php namespace App;
	
use Cache;

?>
<!DOCTYPE html>
<html lang="en" ng-app="ammart">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meat name="CSRF_TOKEN" content="{{ csrf_token() }}">
	<title>Ammartpanichanukul</title>

	@include('resource')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript">
		// CSRF_TOKEN for accessing APIs
		angular.module('ammart').constant('CSRF_TOKEN', '{{ csrf_token() }}');
		angular.module('ammart').constant('CURRENT_YEAR', '{{ Cache::get('settings.current_academic_year') }}');

		// ID of the risk screening questionaire
		angular.module('ammart').constant('RISK_ID', {{ env('APP_RISK_ID') }});
		angular.module('ammart').constant('SDQ_ID', {{ env('APP_SDQ_ID') }});
		angular.module('ammart').constant('EQ_ID', {{ env('APP_EQ_ID') }});

		// Default number that indicate "Use the current academic year"
		angular.module('ammart').constant('ACADEMIC_YEAR', {{ env('APP_ACADEMIC_DEFAULT') }});

		//
		// angular.module('ammart').constant('', );
	</script>
</head>
<body>
	<base href="{{ env('APP_URI') }}"></base>
	
	@include('navbar')
	
	<div ui-view class="body" style="overflow-x: hidden;">
		
	</div>
</body>
</html>
