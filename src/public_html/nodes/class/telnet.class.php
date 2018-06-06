<?php
class telnet extends sqlengine {
	function execute($command,$cron='0') {
		require("/var/www/nodes/config/telnet.inc.php");
		$fp = fsockopen($telnet_host, 23, $errno, $errstr, 30);
		fwrite($fp, $telnet_user);
		fwrite($fp, "\r\n");
		fwrite($fp, $telnet_password);
		fwrite($fp, "\r\n");
		
		if(is_array($command)) {
			foreach($command as $commands) {
				fwrite($fp, $commands);
				fwrite($fp, "\r\n");
				exec('sleep 0.1');
			}
		} else {
			//Wyślij polecenie
			fwrite($fp, $command);
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
