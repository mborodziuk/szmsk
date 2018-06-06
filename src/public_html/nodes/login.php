<?php
/*
$node_id = $_GET["id"];
$device_id = $_GET["nodes"];
$sort = $_GET["sort"];
$order = $_GET["order"];
$show = $_GET["show"];
$save = $_GET["save"];

include("class/sqlengine.class.php");
include("class/telnet.class.php");
include("class/node.class.php");

$sql = new sqlengine;
*/

session_start();

$logout = $_GET["logout"];

if($logout == 1) {
	$_SESSION['logged'] = false;
}

$login = $_POST["login"];
$password = $_POST["password"];

if($login == "admin" AND $password == "kupi3c") {
	$_SESSION['logged'] = true;
	header("Location: index.php");
	exit;
} else {
	$_SESSION['logged'] = false;
	$login_request = true;
}

include("header.php");
?>
<section>
		<div class="container">
					
			<div class="row row row-offcanvas row-offcanvas-left">
					
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					 <div class="tab-content">
						<div id="userstab" class="panel panel-default tab-pane fade in active">
							<div class="panel-body">
							<div style="margin: auto; width: 124px;">
							<form action="login.php" method="post">
							Login:<br>
							<input type="text" name="login"><br>
							Password:<br>
							<input type="password" name="password"><br><br>
							<input type="submit" value="Login">
							</form>
							</div>
							</div>
						</div>
					</div>
					</div>
					</div><!-- /. row-->
			</div>
		</div>
	</section>
</div>
<?php
include("footer.php");
?>