<nav class="navbar navbar-default col-xs-3 col-lg-2">
	<div>
		<div class="navbar-header col-xs-12" style="padding-bottom: 25px">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="logo" href="#">
			</a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav col-xs-12">
				<li class="section">นักเรียน</li>
				<li id="form">
					<a href="forms">
						<table>
						<tr>
							<td><span class="fa fa-pencil-square-o"></span></td>
							<td>แบบฟอร์ม</td>
						</tr>
						</table>
					</a>
				</li>
				@if (Auth::guest())
				<li id="login">
					<a href="auth/login">
						<table>
						<tr>
							<td><span class="fa fa-lock"></span></td>
							<td>เข้าสู่ระบบ</td>
						</tr>
						</table>
					</a>
				</li>
				@else
				<li class="section">อาจารย์</li>
				<li id="risk-screening">
					<a href="teacher/risk-screening">
						<table>
						<tr>
							<td><span class="fa fa-pencil-square-o"></span></td>
							<td>แบบคัดกรอง</td>
						</tr>
						</table>
					</a>
				</li>
				<li id="report">
					<a ui-sref="report({type:'person'})">
						<table>
						<tr>
							<td><span class="fa fa-file-text"></span></td>
							<td>รายงาน</td>
						</tr>
						</table>
					</a>
				</li>
				<li id="logout">
					<a href="auth/logout">
						<table>
						<tr>
							<td><span class="fa fa-sign-out"></span></td>
							<td>ออกจากระบบ</td>
						</tr>
						</table>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>