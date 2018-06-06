<?php

$device_id = $_GET["device_id"];
$addonu = $_GET["addonu"];
$add = $_GET["add"];
$renew = $_GET["renew"];

include("class/sqlengine.class.php");
include("class/telnet.class.php");
include("class/node.class.php");

include("header.php");
?>
<section>
		<div class="container">
					
			<div class="row row row-offcanvas row-offcanvas-left">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					Select node from list:
					<form action="switchnode.php" method="get">
					<select name="device_id">
					<?php
					$sql = new sqlengine;
					$devices = $sql->query("SELECT * FROM `devices`");
					$devices = $sql->result;

					foreach($devices as $device) {
						unset($sql->result);
						$nodes = $sql->query("SELECT * FROM `nodes` WHERE `name` LIKE '$device->name%' LIMIT 1");
						$nodes = $sql->result;
						foreach($nodes as $node) {
						
							$friendly_name = $node->street;
							if($street != null) {
								$friendly_name = explode(" ", $friendly_name);
								$friendly_name = $friendly_name[0];
							}
						
							echo "<option value=\"$device->id\">$device->name $friendly_name</option>\n";
						}
					}

					unset($sql->result,$nodes,$devices);
					?>
					</select>
					<input type="submit" value="OK"> <input type="button" value="Back to home" onclick="location.href='index.php'">
					</form><br><br>			
					 <div class="tab-content">
						<div id="userstab" class="panel panel-default tab-pane fade in active">
							<div class="panel-body">
<?php
if(isset($device_id)) {
	$sql[] = "SELECT * FROM `devices` WHERE `id` = '".$device_id."'";
	include("lib/mysql.php");
	$result = $_CONFIG['MySQL']['query'];
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$device_name = $row["name"];
	
	$sort = $_GET["sort"];
	if($sort == null) {
		$sortby = "ASC";
	}
	if($sort == "ASC") {
		$sortby = "DESC";
	}
	if($sort == "DESC") {
		$sortby = "ASC";
	}
?>
<table>
<thead>
	<tr>
		<th>Node</th><th>Link state</th><th>Last update</th>
	</tr>
</thead>
<tbody>
<?php
	$sql[] = "SELECT * FROM `nodes` WHERE `name` LIKE '%".$device_name."%' AND `state` LIKE 'not found' ORDER BY `name`";

	include("lib/mysql.php");
	$result = $_CONFIG['MySQL']['query'];
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$id = $row["id"];
		$name = $row["name"];
		$state = $row["state"];
		
		echo "<tr>\n";
		echo "<td style=\"text-align: left;\"><a href=\"switchnode.php?addonu=$id&node_id=$node_id\">$name</a></td><td style=\"color: $color; text-align: center;\">$state</td><td>$date</td>\n";
		echo "</tr>\n";
	}
}
?>
</table>
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
