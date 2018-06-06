<?php

$id = $_GET["id"];

include("class/sqlengine.class.php");

$sql = new sqlengine;
if(empty($id)) {
	$result = $sql->query("UPDATE `nodes` SET `transTemperatureMin`='999',`supplyVoltageMin`='999',`txBiasCurrentMin`='999',`txPowerMin`='999',`rxPowerMin`='999',`transTemperatureMax`='0',`supplyVoltageMax`='0',`txBiasCurrentMax`='0',`txPowerMax`='0',`rxPowerMax`='0'");
	header("Location: index.php");
	exit;
} else {
	$result = $sql->query("UPDATE `nodes` SET `transTemperatureMin`='999',`supplyVoltageMin`='999',`txBiasCurrentMin`='999',`txPowerMin`='999',`rxPowerMin`='999',`transTemperatureMax`='0',`supplyVoltageMax`='0',`txBiasCurrentMax`='0',`txPowerMax`='0',`rxPowerMax`='0' WHERE `id` = '$id'");
	header("Location: details.php?id=$id");
	exit;
}
?>