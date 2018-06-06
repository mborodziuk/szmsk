<?php
$node_id = $_GET["id"];

include("class/sqlengine.class.php");
include("class/telnet.class.php");
include("class/node.class.php");

$sql = new sqlengine;
$devices = $sql->query("SELECT * FROM `nodes` WHERE `id` = '$node_id'");
$devices = $sql->result;

foreach($devices as $device) {
	$node = $device->name;
	$onu = $device->onu;
}

$device = explode(":",$node);
$device = $device[0];

$node = new node;
$results = $node->delnode($device,$onu,$node_id);

header("Location: index.php");

?>