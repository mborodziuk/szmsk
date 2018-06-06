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
					<form action="addnode.php" method="get">
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
if(!isset($device_id)) {
	$telnet = new telnet;
	$result = $telnet->execute('show onu unauthentication');
	$result = $telnet->result;
	echo "<pre>";
	print_r($result);
	echo "</pre>";

	unset($telnet,$result);
}
if(isset($device_id)) {

	echo "<table class=\"table table-responsive table-striped\">\n"
		."<thead>\n"
		."	<tr>\n"
		."		<th>Node</th>\n"
		."	</tr>\n"
		."</thead>\n"
		."<tbody>\n";
		
	$devices = $sql->query("SELECT * FROM `devices` WHERE `id` = '$device_id' LIMIT 1");
	$devices = $sql->result;

	unset($sql->result);
	
	foreach($devices as $device) {
		$device_name = $device->name;
	}
	
	$nodes = $sql->query("SELECT * FROM `nodes` WHERE `name` LIKE '%".$device_name."%' AND `state` = 'not found' ORDER BY `id`");
	$nodes = $sql->result;

	foreach($nodes as $node) {
			echo "<tr>\n";
			echo "<td><a href=\"addnode.php?addonu=$node->id\">$node->name</a></td>\n";
			echo "</tr>\n";
	}
	echo "</tbody></table>";
	
	unset($nodes,$sql->result,$devices);
}

if(isset($addonu)) {
	$mac = $_POST["mac"];
	$type = $_POST["type"];
	$tv = $_POST["tv"];
	$vlan = $_POST["vlan"];
	$street = $_POST["street"];
	$name = $_POST["name"];
	$number = $_POST["number"];
	$desc = $_POST["desc"];

	if($type == "ZTE-F401") {
		$checked401 = "checked";
	}
	if($type == "EL-F401" ) {
		$checkedel401 = "checked";
	}
        if($type == "NTS-101" ) {
                $checkednts101 = "checked";
	}
	if($type == "ZTE-F420") {
		$checked420 = "checked";
	}
	if($type == "ZTE-F460") {
		$checked460 = "checked";
	}
	if($tv == "1") {
		$checkedno = "checked";
	}
	if($tv == "3") {
		$checkedyes = "checked";
	}
	
	$nodes = $sql->query("SELECT * FROM `nodes` WHERE `id` = '$addonu'");
	$nodes = $sql->result;

	foreach($nodes as $node) {
		$onuname = $node->name;
		$vlan = $node->vlan;
		$onu = $node->onu;
	}
	
	$device = explode(":",$onuname);
	$device = $device[0];
?>
<script type="text/javascript">
function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>

<script type="text/javascript">
function checkform() {
	var mac = document.getElementById('mac').value;
	var number = document.getElementById('number').value;
	var name = document.getElementById('name').value;
	var street = document.getElementById('street').value;
	var desc = document.getElementById('desc').value;
	var vlan = document.getElementById('vlan').value;
	
	if(number == null || number == '') {
		alert('Field \'number\' required!');
		return false;
	}
	
	if(name == null || name == '') {
		alert('Field \'name\' required!');
		return false;
	}
	
	if(street == null || street == '') {
		alert('Field \'street\' required!');
		return false;
	}
	
	if(vlan == null || vlan == '') {
		alert('Field \'vlan\' required!');
		return false;
	}
	
	if(mac != '') {
		return true;
	} else {
		document.getElementById('mac').style.background='#bb0000';
		document.getElementById('mac').style.color='#ffffff';
		return false;
	}	
}
</script>

<h1><?=$onuname?></h1>
<form action="addnode.php?add=1" method="post" onsubmit="return checkform();">
<input type="hidden" name="device" value="<?=$device?>">
<input type="hidden" name="olt" value="<?=$onuname?>">
MAC: <input type="text" maxlength="14" id="mac"  value="<?=$mac?>" name="mac" style="width: 120px"><br><br>
<table style="border:0">
<tr style="border:0" class="input">
<td valign="top" style="text-align: left; border: 0;" class="input">
Typ:<br>
<input type="radio" name="type" value="ZTE-F401" checked="checked" onclick="getElementById('voipno').disabled=true; getElementById('voipyes').disabled=true; getElementById('voippass').disabled=true;" <?=$checked401?>>ZTE-F401<br>
<input type="radio" name="type" value="EL-F401" onclick="getElementById('voipno').disabled=true; getElementById('voipyes').disabled=true; getElementById('voippass').disabled=true;" <?=$checkedel401?>>EL-F401<br>
<input type="radio" name="type" value="NTS-101" onclick="getElementById('voipno').disabled=true; getElementById('voipyes').disabled=true; getElementById('voippass').disabled=true;" <?=$checkednts101?>>NTS-101<br>
<input type="radio" name="type" value="ZTE-F420" <?=$checked420?> onclick="getElementById('voipno').disabled=false; getElementById('voipyes').disabled=false; getElementById('voippass').disabled=false;">ZTE-F420<br>
<input type="radio" name="type" value="ZTE-F460" <?=$checked460?> onclick="getElementById('voipno').disabled='false'; getElementById('voipyes').disabled='false'; getElementById('voippass').disabled=false;">ZTE-F460<br>
<input type="radio" name="type" value="EL-FHR2411K" <?=$checkedFHR2411K?> onclick="getElementById('voipno').disabled='false'; getElementById('voipyes').disabled='false'; getElementById('voippass').disabled=false;">EL-FHR2411K<br>
</td>
<td valign="top" style="text-align: left; border: 0;" class="input">
TV:<br>
<input type="radio" name="tv" value="1" checked="checked" <?=$checkedno?>> No<br>
<input type="radio" name="tv" value="3" <?=$checkedyes?>> Yes<br>
</td>
<td valign="top" style="text-align: left; border: 0;" class="input">
VOIP:<br>
<input type="radio" name="voip" value="1" checked="checked" <?=$checkedno?> id="voipno" disabled > No<br>
<input type="radio" name="voip" value="2" <?=$checkedyes?> id="voipyes" disabled> Yes<br>
</td>
<td valign="top" style="text-align: left; border: 0;" class="input">
Password:<br>
<input type="text" name="voippass" id="voippass" disabled>
</td>
</tr>
</table>
<br>
<table>
<tr>
<td>VLAN:</td><td style="float: left; text-align: left;"><input type="text"  onkeypress="validate(event)"value="<?=$vlan?>" name="vlan" id="vlan" style="width: 30px;" maxlength="4"></td>
</tr><tr>
<td>Number:</td><td><input type="text" value="<?=$number?>" id="number" name="number" style="width: 250px;"></td>
</tr><tr>
<td>Name:</td><td><input type="text" value="<?=$name?>" name="name" id="name" style="width: 250px;"></td>
</tr><tr>
<td>Street:</td><td><input type="text" value="<?=$street?>" name="street" id="street" style="width: 250px;"></td>
</tr><tr>
<td>Description:</td><td><input type="text" value="<?=$desc?>" name="desc" id="desc" style="width: 250px;"></td>
</tr><tr>
<td colspan="2">
<input type="submit" value="Add Node">
</td>
</tr>
</table>
</form>
<?php
} if($add == 1) {

	$mac = $_POST["mac"];
	$type = $_POST["type"];
	$tv = $_POST["tv"];
	$vlan = $_POST["vlan"];
	$street = $_POST["street"];
	$name = $_POST["name"];
	$number = $_POST["number"];
	$desc = $_POST["desc"];
	$device = $_POST["device"];
	$olt = $_POST["olt"];
	$password = $_POST["voippass"];
	$voip = $_POST["voip"];
	
	if($type == "ZTE-F401") {
		$checked401 = "checked";
	}
	if($type == "ZTE-F420") {
		$checked420 = "checked";
	}
	if($type == "ZTE-F460") {
		$checked460 = "checked";
	}
        if($type == "EL-FHR2411K") {
                $checkedFHR2411K = "checked";
        }

	if($tv == "1") {
		$checkedno = "checked";
	}
	if($tv == "3") {
		$checkedyes = "checked";
	}
	
	$device = str_replace("onu","olt",$device);
	
	$node = new node;
	$results = $node->addnode($device,$olt,$mac,$type,$tv,$voip,$password,$vlan);

	$mac = str_replace(".","",$mac);
	$mac = $mac[0].$mac[1].":".$mac[2].$mac[3].":".$mac[4].$mac[5].":".$mac[6].$mac[7].":".$mac[8].$mac[9].":".$mac[10].$mac[11];
	$mac = strtoupper($mac);

	$results = $node->adduser($name,$number,$street,$desc,$olt,$mac);
?>
							<form action="addnode.php?renew=1" method="post">
							<input type="hidden" name="olt" value="<?=$olt?>">
							<input type="hidden" name="type" value="<?=$type?>">
							<input type="hidden" name="vlan" value="<?=$vlan?>">
							<input type="hidden" name="tv" value="<?=$tv?>">
							<input type="submit" value="Renew VLAN">
							</form>
<?php
}
if($renew == 1) {
	$olt = $_POST["olt"];
	$type = $_POST["type"];
	$vlan = $_POST["vlan"];
	$tv = $_POST["tv"];
	
	$node = new node;
	$results = $node->renew($olt,$type,$vlan,$tv);
}
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
