<?php

class TELNET 
{
	
function exec($host, $user, $password, $cmd,$cron='0') 
{
///	require("/var/www/nodes/config/telnet.inc.php");
	$fp = fsockopen($host, 23, $errno, $errstr, 30);
	fwrite($fp, $user);
	fwrite($fp, "\r\n");
	fwrite($fp, $password);
	fwrite($fp, "\r\n");
		
	if(is_array($cmd)) 
	{
			foreach($cmd as $cmds) 
			{
				fwrite($fp, $cmds);
				fwrite($fp, "\r\n");
				exec('sleep 0.1');
			}
	} 
	else 
	{
			//Wyślij polecenie
			fwrite($fp, $cmd);
			fwrite($fp, "\r\n");
			exec('sleep 0.2');
	}
	
	$i=0;
		while (!feof($fp)) {
			$currentline = fgets($fp, 128);
			$lines[$i] = $currentline;
			exec("sleep 0.01");
			fwrite($fp, "\r\n");
			if(strpos("$currentline", "ON#")) {
				$ponlines++;
			}
			if($ponlines == 2) {
				break;
			}
			$i++;
		}
		fwrite($fp, "quit");
		fclose($fp);
		
		exec('sleep 0.1');
		//Wyczyść logowanie
		for($a=0;$a<=5;$a++) {
			unset($lines[$a]);
		}
		
		$this->result = $lines;
		exec("sleep 0.5");
}

}
