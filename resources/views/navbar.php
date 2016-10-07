<nav class="navbar navbar-default col-xs-3 col-lg-2 bgcolor-secondary children">
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
					<a ui-sref="Forms" class="bgcolor-clear children">
						<table>
						<tr>
							<td><span class="fa fa-pencil-square-o color-accent1"></span></td>
							<td>แบบฟอร์ม</td>
						</tr>
						</table>
					</a>
				</li>
				<div ng-if="!user || user.level == 0">
					<li id="login">
						<a ui-sref="login" class="bgcolor-clear children">
							<table>
							<tr>
								<td><span class="fa fa-lock color-accent1"></span></td>
								<td>เข้าสู่ระบบ</td>
							</tr>
							</table>
						</a>
					</li>
				</div>
				<div ng-if="!!user && user.level > 0">
					<li class="section" >อาจารย์</li>
					<li id="report">
						<a ui-sref="ReportDisplay" class="bgcolor-clear children">
							<table>
							<tr>
								<td><span class="fa fa-file-text color-accent1"></span></td>
								<td>รายงาน</td>
							</tr>
							</table>
						</a>
					</li>
					<li id="settings">
						<a ui-sref="settings()" class="bgcolor-clear children">
							<table>
							<tr>
								<td><span class="fa fa-gear color-accent1"></span></td>
								<td>ตั้งค่าระบบ</td>
							</tr>
							</table>
						</a>
					</li>
					<li id="logout">
						<a ui-sref="logout" class="bgcolor-clear children">
							<table>
							<tr>
								<td><span class="fa fa-sign-out color-accent1"></span></td>
								<td>ออกจากระบบ</td>
							</tr>
							</table>
						</a>
					</li>
				</div>
			</ul>
		</div>
	</div>
</nav>