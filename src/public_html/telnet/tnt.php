#!/usr/bin/php -q

<?php
ini_set('memory_limit', '2000096M');

include "../func/config.php";
include "../func/szmsk.php";
include "../www/www.php";
include "../szmsk/szmsk.php";
include "telnet.php";

$telnet=new TELNET();

$dbh=DBConnect($DBNAME1);


$cmd="show port";
$result = $telnet->exec("172.30.9.3", $cmd);
//$result = $telnet->result;
