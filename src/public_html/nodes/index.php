<?php

$node_id = $_GET["id"];
$device_id = $_GET["nodes"];
$sort = $_GET["sort"];
$order = $_GET["order"];
$show = $_GET["show"];

if($order == null) {
	$order = 'transTemperature';
	$sort = 'DESC';
}
if($sort == null) {
	$sortby = "ASC";
}
if($sort == "ASC") {
	$sortby = "DESC";
}
if($sort == "DESC") {
	$sortby = "ASC";
}

include("class/sqlengine.class.php");

include("header.php");
?>
<section>
		<div class="container">
					
			<div class="row row row-offcanvas row-offcanvas-left">
					
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">		
					Select node from list:
					<form action="nodes.php" method="get">
					<input type="hidden" name="show" value="devices">
					<select name="nodes">
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

					unset($sql->result,$nodes);
					?>
					</select>
					<input type="submit" value="Show">
					<input type="button" value="Show all nodes" onclick="location.href='index.php'">
					<input type="button" value="Clear values" onclick="location.href='clear.php'">
					<input type="button" value="Add node" onclick="location.href='addnode.php'">
					</form>
					<br><br>
					 <div class="tab-content">
						<div id="userstab" class="panel panel-default tab-pane fade in active">
							<div class="panel-body">
							<table class="table table-responsive table-striped">
								<thead>
									<tr>
										<th>
											<a href="?order=id&sort=<?=$sortby?>">LP</a>
										</th>
										<th>
											<a href="?order=name&sort=<?=$sortby?>">Node</a>
										</th>
										<th>
											<a href="?order=vlan&sort=<?=$sortby?>">VLAN</a>
										</th>
										<th>
											<a href="?order=b.name&sort=<?=$sortby?>">User</a>
										</th>
										<th>
											<a href="?order=street&sort=<?=$sortby?>">Street</a>
										</th>
										<th>
											<a href="?order=rxPowerMin&sort=<?=$sortby?>">RxMin</a>
										</th>
										<th>
											<a href="?order=rxPower&sort=<?=$sortby?>">RxPower</a>
										</th>
										<th>
											<a href="?order=rxPowerMax&sort=<?=$sortby?>">RxMax</a>
										</th>
										<th>
											<a href="?order=rxPowerDiff&sort=<?=$sortby?>">RxDiff</a>
										</th>
										<th>
											<a href="?order=distance&sort=<?=$sortby?>">Distance</a>
										</th>
										<th>
											<a href="?order=transTemperature&sort=<?=$sortby?>">Temp</a>
										</th>
										<th>
											<a href="?order=transTemperatureMax&sort=<?=$sortby?>">Temp Max</a>
										</th>
										<th>
											<a href="?order=Register_Time&sort=<?=$sortby?>">Reg</a>
										</th>
										<th>
											<a href="?order=Deregister_Time&sort=<?=$sortby?>">DeReg</a>
										</th>
										<th>
											<a href="?order=state&sort=<?=$sortby?>">State</a>
										</th>
										<th>
											<a href="?order=last_update&sort=<?=$sortby?>">Update</a>
										</th>
										<th>
											<a href="?order=mac&sort=<?=$sortby?>">MAC</a>
										</th>
										<th>
											<a href="?order=type&sort=<?=$sortby?>">Type</a>
										</th>
									</tr>
								</thead>
								<tbody>
<?php
$order = $_GET["order"];
if($order == null) {
	$order = 'transTemperature';
	$sort = 'DESC';
}

if(!empty($device_id)) {
	$devices = $sql->query("SELECT * FROM `devices` WHERE `id` = '$device_id' LIMIT 1");
	$devices = $sql->result;

	foreach($devices as $device) {
		$device_name = $device->name;
	}
}

unset($devices,$sql->result);

if(!empty($device_id)) {
	$nodes = $sql->query("SELECT a.id,a.name,a.type,a.mac,b.street,a.vlan,a.rxPower,a.distance,a.transTemperature,a.state,a.transTemperatureMax,a.rxPowerMax,a.rxPowerMin,a.rxPowerDiff,a.Register_Time,a.type,a.Deregister_Time,b.name as user,last_update,b.desc FROM `nodes` a LEFT JOIN `users` b ON a.id=b.id_node WHERE a.name LIKE '%".$device_name."%' AND `state` != 'not found' ORDER BY ".$order." ".$sort."");
	$nodes = $sql->result;	
} else {
	$nodes = $sql->query("SELECT a.id,a.name,a.type,a.mac,b.street,a.vlan,a.rxPower,a.distance,a.transTemperature,a.state,a.transTemperatureMax,a.rxPowerMax,a.rxPowerMin,a.rxPowerDiff,a.Register_Time,a.type,a.Deregister_Time,last_update,b.name as user,b.desc FROM `nodes` a LEFT JOIN `users` b ON a.id=b.id_node WHERE `state` != 'not found' ORDER BY ".$order." ".$sort."");
	$nodes = $sql->result;
}

$lp = 1;
foreach($nodes as $node) {
	$temp = round($node->transTemperature);
	$tempmax = round($node->transTemperatureMax);
	$rxpower = round($node->rxPower,2);
	$rxpowermax = round($node->rxPowerMax,2);
	$rxpowermin = round($node->rxPowerMin,2);
	
	if($oldonu == $node->name) {
		continue;
	}

	if($temp >= 70) {
		$tempcolor = "red";
	}
	if($temp <= 69 AND $temp >= 60) {
		$tempcolor = "orange";
	}
	if($temp <= 59 AND $temp >= 50) {
		$tempcolor = "#DFCD00";
	}
	if($temp < 50) {
		$tempcolor = "green";
	}
	if($temp == 0) {
		$tempcolor = "#000";
	}
	if($tempmax >= 70) {
		$tempmaxcolor = "red";
	}
	if($tempmax <= 69 AND $tempmax >= 60) {
		$tempmaxcolor = "orange";
	}
	if($tempmax <= 59 AND $tempmax >= 50) {
		$tempmaxcolor = "#DFCD00";
	}
	if($tempmax < 50) {
		$tempmaxcolor = "green";
	}
	if($tempmax == 0) {
		$tempmaxcolor = "#000";
	}
	if($rxpower > 29) {
		$rxcolor = "red";
	}
	if($rxpower <= 29 AND $rxpower >= 28) {
		$rxcolor = "orange";
	}
	if($rxpower < '27.99' AND $rxpower > 24) {
		$rxcolor = "#DFCD00";
	}
	if($rxpower <= 24 AND $rxpower >= 20) {
		$rxcolor = "green";
	}
	if($rxpower <= 19 AND $rxpower >= 15) {
		$rxcolor = "gray";
	}
	if($rxpower < 15) {
		$rxcolor = "lightgray";
	}
	if($rxpowermax > 29) {
		$rxcolormax = "red";
	}
	if($rxpowermax <= 29 AND $rxpowermax >= 28) {
		$rxcolormax = "orange";
	}
	if($rxpowermax < '27.99' AND $rxpowermax > 24) {
		$rxcolormax = "#DFCD00";
	}
	if($rxpowermax <= 24 AND $rxpowermax >= 20) {
		$rxcolormax = "green";
	}
	if($rxpowermax <= 19 AND $rxpowermax >= 15) {
		$rxcolormax = "gray";
	}
	if($rxpowermax < 15) {
		$rxcolormax = "lightgray";
	}
	if($rxpowermin > 29) {
		$rxcolormin = "red";
	}
	if($rxpowermin <= 29 AND $rxpowermin >= 28) {
		$rxcolormin = "orange";
	}
	if($rxpowermin < '27.99' AND $rxpowermin > 24) {
		$rxcolormin = "#DFCD00";
	}
	if($rxpowermin <= 24 AND $rxpowermin >= 20) {
		$rxcolormin = "green";
	}
	if($rxpowermin <= 19 AND $rxpowermin >= 15) {
		$rxcolormin = "gray";
	}
	if($rxpowermin < 15) {
		$rxcolormin = "lightgray";
	}
	
	if($node->state == 'offline') {
		$color = "#ff0000";
	} elseif($node->state == 'online') {
		$color = "#008600";
	} else {
		$color = "#868686";
	}
	
	$register_time = explode(" ",$node->Register_Time);
	$deregister_time = $node->Deregister_Time;
	
	$node_name = str_replace("epon-onu_", "", $node->name);

	echo "<tr>\n"
		."	<td>$lp</td>"
		."	<td><a href=\"details.php?id=".$node->id."\">$node_name</a></td>\n"
		."	<td>$node->vlan</td>"
		."	<td>$node->user</td>"
		."	<td>$node->street</rd>\n"
		."	<td><font color=\"$rxcolormin\">".$rxpowermin."</font></td>"
		."	<td><font color=\"$rxcolor\">".substr($rxpower,0,4)."</font></td>"
		."	<td><font color=\"$rxcolormax\">".substr($rxpowermax,0,4)."</font></td>"
		."  <td>".$node->rxPowerDiff."</td>"
		."	<td>$node->distance</td>"
		."	<td><font color=\"$tempcolor\">".substr(round($temp, 2),0,4)."&deg;C</font></td>"
		."	<td><font color=\"$tempmaxcolor\">".substr(round($tempmax, 2),0,4)."&deg;C</font></td>"
		."	<td>$register_time[0]</td>"
		."	<td>$deregister_time</td>"
		."	<td><font color=\"$color\">$node->state</font></td>"
		."	<td>".$node->last_update."</td>"
		."	<td>".strtoupper($node->mac)."</td>\n"
		."	<td>$node->type</td>\n"
		."</tr>";
	
	$oldonu = $node->name;
	$lp++;
}
?>
								</tbody>
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