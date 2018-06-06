<?php
include("../class/sqlengine.class.php");
include("../class/telnet.class.php");
include("../class/cron.class.php");

$cron = new cron;
$results = $cron->macs();