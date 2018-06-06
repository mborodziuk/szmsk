<?php
class sqlengine {
	function query($query) {
		require("/var/www/nodes/config/db.inc.php");
		$dblink = @mysql_connect($host, $user, $pass) or die('<font size="1" face="verdana"><b>Warning:</b><br>Cannot connect: ' . mysql_error() . '</font>');
		$dbselect = @mysql_select_db($dbname) or die('<font size="1" face="verdana"><b>Warning:</b><br>Cannot select database: ' . mysql_error() . '</font>');    
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET character_set_connection=utf8");
		mysql_query("SET character_set_client=utf8");
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET lc_time_names = 'pl_PL'");
		$mysql_query = mysql_query("$query") or die('<font size="1" face="verdana"><b>Warning:</b><br>Cannot query database: ' . mysql_error() . '</font>');
		mysql_close($dblink);
		$first_word = explode(' ', trim($query));
		if($first_word[0] == "SELECT") {
			while($rows = mysql_fetch_object($mysql_query)) {
				$this->result[] = $rows;
			}
		}
	}
}
