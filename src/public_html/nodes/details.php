<?php

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

if($save == 1) {
	$name = $_POST["name"];
	$street = $_POST["street"];
	$desc = $_POST["desc"];
	$number = $_POST["number"];
	$nodestreet = $_POST["nodestreet"];
	$device_name = $_POST["device_name"];
	$node_mac = $_POST["node_mac"];
	
	$users = $sql->query("SELECT * FROM `users` WHERE `id_node` = '$node_id' LIMIT 1");
	$users = $sql->result;
	
	if(empty($users)) {
		$users = $sql->query("INSERT INTO `users` (`id`, `id_node`, `abon_nr`, `name`, `street`, `desc`, `mac`) VALUES (null, '".$node_id."', '".$number."', '".$name."', '".$street."', '".$desc."', '".$node_mac."')");
	} else {
		$users = $sql->query("UPDATE `users` SET `name` = '$name', `street` = '$street', `abon_nr` = '$number', `desc` = '$desc' WHERE `id_node` = '$node_id'");
	}
	
	$nodes = $sql->query("UPDATE `nodes` SET `street` = '$nodestreet' WHERE `name` LIKE '%$device_name%'");
	
	unset($nodes,$users,$sql->result);
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
<?php
$nodes = $sql->query("SELECT * FROM `nodes` WHERE `id` = '$node_id' LIMIT 1");
$nodes = $sql->result;

foreach($nodes as $node) {
	echo "<h1>$node->name</h1>";
}

unset($sql->result,$nodes);

$telnet = new telnet;
$result = $telnet->execute("show mac epon onu $node->name");
$result = $telnet->result;

$node_name = $node->name;
$node_id = $node->id;
$node_street = $node->street;
$node_mac = $node->mac;

$results = array_filter($result, function ($item) use ($node_name) {
	if(stripos($item, $node_name) !== false) {
		return true;
	}
	return false;
});

$y=0;
foreach($results as $resultx) {
	$output = preg_replace('!\s+!', ' ', $resultx);
	$macs[$y] = explode(" ", $output);
	$y++;
}

unset($macs[0],$telnet->result,$results,$result);

echo "<b>Registered Macs</b><br>";

foreach($macs as $mac) {
	$showmac = $mac[0];
	$showmac = str_replace(".","",$showmac);
	$showmac = $showmac[0].$showmac[1].":".$showmac[2].$showmac[3].":".$showmac[4].$showmac[5].":".$showmac[6].$showmac[7].":".$showmac[8].$showmac[9].":".$showmac[10].$showmac[11];
	$showmac = strtoupper($showmac);
	
	echo "$showmac<br>";
}

echo "<b>Register time</b><br>";
echo "$node->Register_Time<br>";
echo "<b>Deregister time</b><br>";
echo "$node->Deregister_Time<br>";
echo "<b>Last authentication</b><br>";
echo "$node->LastAuthTime<br><br>";
echo "Distance meter:<br>";

$results = $telnet->execute("show remote onu port info $node->name");
$results = $telnet->result;

echo "<pre>";
foreach($results as $result) {
                echo "$result";
}
echo "</pre>";
unset($results);



$results = $telnet->execute("show remote onu vlan $node->name");
$results = $telnet->result;

echo "<pre>";
foreach($results as $result) {
                echo "$result";
}
echo "</pre>";
unset($results);



$results = $telnet->execute("show onu mpcpinfo $node->name");
$results = $telnet->result;

echo "<pre>";
foreach($results as $result) {
		echo "$result";
}
echo "</pre>";
unset($results);


$results = $telnet->execute("show remote onu transceiver info $node->name");
$results = $telnet->result;

echo "<pre>";
foreach($results as $result) {
		echo "$result";
}
echo "</pre>";

unset($results);

$results = $telnet->execute("show remote onu info $node->name");
$results = $telnet->result;

echo "</pre>";
echo "<pre>";
foreach($results as $result) {
		echo "$result";
}
echo "</pre>";

$results = $telnet->execute("show onu sla upstream $node->name");
$results = $telnet->result;

echo "</pre>";
echo "<pre>";
foreach($results as $result) {
		echo "$result";
}
echo "</pre>";

unset($results);

$results = $telnet->execute("show onu sla downstream $node->name");
$results = $telnet->result;

echo "</pre>";
echo "<pre>";
foreach($results as $result) {
		echo "$result";
}
echo "</pre>";

unset($results);
?>

<table class="table table-responsive table-striped">
<thead>
	<tr>
		<th>
			Temperature
		</th>
		<th>
			RxPower
		</th>
		<th>
			TxPower
		</th>
		<th>
			Min Temperature
		</th>
		<th>
			Min RxPower
		</th>
		<th>
			Min TxPower
		</th>
		<th>
			Max Temperature
		</th>
		<th>
			Max RxPower
		</th>
		<th>
			Max TxPower
		</th>
		<th>
			Update
		</th>
	</tr>
</thead>
<tbody>
<?php
	$nodes = $sql->query("SELECT * FROM `nodes` WHERE `id` = '$node_id' LIMIT 1");
	$nodes = $sql->result;
	
	echo "<tr>";
	foreach($nodes as $node) {	
		$temp = round($node->transTemperature);
		$tempmax = round($node->transTemperatureMax);
		$rxpower = round($node->rxPower,2);
		$rxpowermax = round($node->rxPowerMax,2);
		$tempmin = round($node->transTemperatureMin);
		$rxpowermin = round($node->rxPowerMin,2);
		
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
		if($tempmin >= 70) {
			$tempmincolor = "red";
		}
		if($tempmin <= 69 AND $tempmin >= 60) {
			$tempmincolor = "orange";
		}
		if($tempmin <= 59 AND $tempmin >= 50) {
			$tempmincolor = "#DFCD00";
		}
		if($tempmin < 50) {
			$tempmincolor = "green";
		}
		if($tempmin == 0) {
			$tempmincolor = "#000";
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
		echo "<td><font color=\"$tempcolor\">".round($node->transTemperature,2)."&deg;C</font></td><td><font color=\"$rxcolor\">".round($node->rxPower,2)."</font></td><td>".round($node->txPower,2)."</td><td><font color=\"$tempmincolor\">".round($node->transTemperatureMin,2)."&deg;C</font></td><td><font color=\"$rxcolormin\">".round($node->rxPowerMin,2)."</font></td><td>".round($node->txPowerMin,2)."</td><td><font color=\"$tempmaxcolor\">".round($node->transTemperatureMax,2)."&deg;C</font></td><td><font color=\"$rxcolormax\">".round($node->rxPowerMax,2)."</font></td><td>".round($node->txPowerMax,2)."</td><td>$node->last_update</td>";
	}
	echo "</tr>";
	echo "</tbody>";
	echo "</table>";
?>

<table class="table table-responsive table-striped">
<thead>
	<tr>
		<th>
			Temperature
		</th>
		<th>
			RxPower
		</th>
		<th>
			TxPower
		</th>
		<th>
			Update
		</th>
	</tr>
</thead>
<tbody>

<?php
	$quartyear = date("Y-m-d 00:00:00",strtotime("-90 days"));
	$halfyear = date("Y-m-d 00:00:00",strtotime("-180 days"));
	$year = date("Y-m-d 00:00:00",strtotime("-365 days"));

	unset($nodes,$sql->result);
	
	$nodes = $sql->query("SELECT * FROM `history` WHERE `id_node` = '$node_id' ORDER BY `id` DESC LIMIT 5");
	$nodes = $sql->result;
	
	if(!empty($nodes)) {	
		foreach($nodes as $node) {
			echo "<tr>";
			$temp = round($node->transTemperature);
			$rxpower = round($node->rxPower,2);

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
		
			echo "<td><font color=\"$tempcolor\">".round($node->transTemperature,2)."&deg;C</font></td><td><font color=\"$rxcolor\">".round($node->rxPower,2)."</font></td><td>".round($node->txPower,2)."</td><td>$node->date</td>";
			echo "</tr>";
		}
	}
	
	unset($nodes,$sql->result);
	
	$nodes = $sql->query("SELECT * FROM `history` WHERE `id_node` = '$node_id' AND `date` <= '$quartyear' LIMIT 1");
	$nodes = $sql->result;
	
	if(!empty($nodes)) {	
		foreach($nodes as $node) {
			echo "<tr>";
			$temp = round($node->transTemperature);
			$rxpower = round($node->rxPower,2);

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
		
			echo "<td><font color=\"$tempcolor\">".round($node->transTemperature,2)."&deg;C</font></td><td><font color=\"$rxcolor\">".round($node->rxPower,2)."</font></td><td>".round($node->txPower,2)."</td><td>$node->date</td>";
			echo "</tr>";
		}
	}	
	
	unset($nodes,$sql->result);
	
	$nodes = $sql->query("SELECT * FROM `history` WHERE `id_node` = '$node_id' AND `date` <= '$halfyear' LIMIT 1");
	$nodes = $sql->result;
	
	if(!empty($nodes)) {
		foreach($nodes as $node) {
			echo "<tr>";
			$temp = round($node->transTemperature);
			$rxpower = round($node->rxPower,2);

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
		
			echo "<td><font color=\"$tempcolor\">".round($node->transTemperature,2)."&deg;C</font></td><td><font color=\"$rxcolor\">".round($node->rxPower,2)."</font></td><td>".round($node->txPower,2)."</td><td>$node->date</td>";
			echo "</tr>";
		}
	}
	
	unset($nodes,$sql->result);
	
	$nodes = $sql->query("SELECT * FROM `history` WHERE `id_node` = '$node_id' AND `date` <= '$year' LIMIT 1");
	$nodes = $sql->result;
	
	if(!empty($nodes)) {
		foreach($nodes as $node) {
			echo "<tr>";
			$temp = round($node->transTemperature);
			$rxpower = round($node->rxPower,2);

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
		
			echo "<td><font color=\"$tempcolor\">".round($node->transTemperature,2)."&deg;C</font></td><td><font color=\"$rxcolor\">".round($node->rxPower,2)."</font></td><td>".round($node->txPower,2)."</td><td>$node->date</td>";
			echo "</tr>";
		}
	}
	
	unset($nodes,$sql->result);

?>
</tbody>
</table>

<script type="text/javascript">
function conf(url) {
	var c = confirm("Are you sure?");
	if(c == true) {
		location.href=url;
	} else {
		return false;
	}
}
</script>

<input type="button" value="Clear values" onclick="location.href='clear.php?id=<?=$node_id?>'">

<?php
echo "<a name=\"user\"></a><h2>User</h2><form action=\"details.php?save=1&id=$node_id#user\" method=\"post\">";

$users = $sql->query("SELECT * FROM `users` WHERE `id_node` = '$node_id' LIMIT 1");
$users = $sql->result;

$device_name = explode(":",$node_name);
$device_name = $device_name[0];

if(!empty($users)) {
	foreach($users as $user) {
		echo "<input type=\"hidden\" name=\"device_name\" value=\"$device_name\">";
		echo "<input type=\"hidden\" name=\"node_mac\" value=\"$node_mac\">";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Number\" name=\"number\" value=\"$user->abon_nr\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Name\" name=\"name\" value=\"$user->name\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Street\" name=\"street\" value=\"$user->street\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Node Street\" name=\"nodestreet\" value=\"$node_street\"><br>";
		echo "<textarea name=\"desc\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Description\">$user->desc</textarea><br>";
		echo "<input type=\"submit\" value=\"Save\">&nbsp;<input type=\"button\" onclick=\"return conf('delnode.php?id=$node_id');\" name=\"delete\" value=\"Delete\">";
	}
} else {
		echo "<input type=\"hidden\" name=\"device_name\" value=\"$device_name\">";
		echo "<input type=\"hidden\" name=\"node_mac\" value=\"$node_mac\">";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Number\" name=\"number\" value=\"$user->abon_nr\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Name\" name=\"name\" value=\"$user->name\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Street\" name=\"street\" value=\"$user->street\"><br>";
		echo "<input type=\"text\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Node Street\" name=\"nodestreet\" value=\"$node_street\"><br>";
		echo "<textarea name=\"desc\" style=\"width: 200px; margin-bottom: 3px;\" placeholder=\"Description\">$user->desc</textarea><br>";
		echo "<input type=\"submit\" value=\"Save\">&nbsp;<input type=\"button\" onclick=\"return conf('delnode.php?id=$node_id');\" name=\"delete\" value=\"Delete\">";
}

echo "</form>";
?>
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
