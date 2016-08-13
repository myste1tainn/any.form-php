<div class="container-fluid" style="margin-top: 40px" ng-controller="LoginController">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">ล็อกอิน</div>
				<div class="panel-body">

					<div class="col-xs-12">
						<p>{{error}}</p>
					</div>

					<form class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">ชื่อผู้ใช้</label>
							<div class="col-md-6">
								<input type="username" class="form-control" ng-model="username" name="username" value="{{ old('username') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">รหัสผ่าน</label>
							<div class="col-md-6">
								<input type="password" class="form-control" ng-model="password" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" ng-model="remember" name="remember"> จำการล็อกอินไว้
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button ng-click="login()" class="btn btn-primary" style="margin-right: 15px;">
									เข้าสู่ระบบ
								</button>

								<!-- <a href="/password/email">Forgot Your Password?</a> -->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

