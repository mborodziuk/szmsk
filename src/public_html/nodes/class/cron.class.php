<?php
class cron extends telnet {
	function daily() {
		@sqlengine::query("SELECT * FROM `nodes` ORDER BY `id` ASC");
		$this->nodes = $this->result;
		unset($this->result);
		
		$nodes = $this->nodes;
		
		foreach($nodes as $node) {			
			$command = "show remote onu transceiver info $node->name";
			@telnet::execute($command,$cron='1');
			$results = $this->result;
			
			if(strpos($results[7],'Code 40300') == false AND strpos($results[8],'Invalid') == false) {
				$temperature = explode(":", $results[8]);
				$temperature = trim($temperature[1]);
				
				$voltage = explode(" ", $results[9]);
				$voltage = trim($voltage[2]);

				$bias = explode(" ", $results[10]);
				$bias = trim($bias[2]);
				
				$txpower = explode(" ", $results[11]);
				$txpower = trim($txpower[2]);
				
				$rxpower = explode(" ", $results[12]);
				$rxpower = trim($rxpower[2]);
				$rxpower = str_replace("-", "", $rxpower);
				
				$temperaturemax = $node->transTemperatureMax;
				$voltagemax = $node->supplyVoltageMax;
				$biasmax = $node->txBiasCurrentMax;
				$txpowermax = $node->txPowerMax;
				$rxpowermax = $node->rxPowerMax;
				
				$temperaturemin = $node->transTemperatureMin;
				$voltagemin = $node->supplyVoltageMin;
				$biasmin = $node->txBiasCurrentMin;
				$txpowermin = $node->txPowerMin;
				$rxpowermin = $node->rxPowerMin;
				
				//Avoid 'username' in database
				if($voltage == 'username') {
					continue;
				}
				
				//Update MAX values
				if($temperaturemax < $temperature) {
					@sqlengine::query("UPDATE `nodes` SET `transTemperatureMax` = '$temperature' WHERE `id` = '$node->id'");
				}
				if($voltagemax < $voltage) {
					@sqlengine::query("UPDATE `nodes` SET `supplyVoltageMax` = '$voltage' WHERE `id` = '$node->id'");
				}
				if($biasmax < $bias) {
					@sqlengine::query("UPDATE `nodes` SET `txBiasCurrentMax` = '$bias' WHERE `id` = '$node->id'");
				}
				if($txpowermax < $txpower) {
					@sqlengine::query("UPDATE `nodes` SET `txPowerMax` = '$txpower' WHERE `id` = '$node->id'");
				}
				if($rxpowermax < $rxpower) {
					@sqlengine::query("UPDATE `nodes` SET `rxPowerMax` = '$rxpower' WHERE `id` = '$node->id'");
				}
				
				//Update MIN values
				if($temperaturemin > $temperature) {
					@sqlengine::query("UPDATE `nodes` SET `transTemperatureMin` = '$temperature' WHERE `id` = '$node->id'");
				}
				if($voltagemin > $voltage) {
					@sqlengine::query("UPDATE `nodes` SET `supplyVoltageMin` = '$voltage' WHERE `id` = '$node->id'");
				}
				if($biasmin > $bias) {
					@sqlengine::query("UPDATE `nodes` SET `txBiasCurrentMin` = '$bias' WHERE `id` = '$node->id'");
				}
				if($txpowermin > $txpower) {
					@sqlengine::query("UPDATE `nodes` SET `txPowerMin` = '$txpower' WHERE `id` = '$node->id'");
				}
				if($rxpowermin > $rxpower) {
					@sqlengine::query("UPDATE `nodes` SET `rxPowerMin` = '$rxpower' WHERE `id` = '$node->id'");
				}

				$command = "show onu mpcpinfo $node->name";
				@telnet::execute($command);
				$results2 = $this->result;
				
				$distances = $results2[15];
				$distance = explode(" ", $distances);

				$distance = str_replace("(","", $distance[13]);
				
				//Historical data
				@sqlengine::query("INSERT INTO `history` (`id`,`id_node`,`date`,`transTemperature`,`supplyVoltage`,`txBiasCurrent`,`txPower`,`rxPower`) VALUES (null,'".$node->id."',NOW(),'".$temperature."','".$voltage."','".$bias."','".$txpower."','".$rxpower."')");
				
				//Current data
				@sqlengine::query("UPDATE `nodes` SET `transTemperature` = '$temperature',`supplyVoltage`='$voltage',`txBiasCurrent`='$bias',`txPower`='$txpower',`rxPower`='$rxpower',`state`='online',`last_update`=NOW(),`distance`='$distance' WHERE `id` = '$node->id'");				
			}
			if(strpos($results[7],'Code 40300') == true AND strpos($results[8],'Invalid') == false) {
				@sqlengine::query("UPDATE `nodes` SET `state` = 'offline', `last_update` = NOW() WHERE `id` = '$node->id'");
			}
			if(strpos($results[7],'Code 40300') == false AND strpos($results[8],'Invalid') == true) {
				@sqlengine::query("UPDATE `nodes` SET `state` = 'not found' WHERE `id` = '$node->id'");
			}
			
			$command = "show remote onu info $node->name";
			@telnet::execute($command,$cron='1');
			$results = $this->result;
			
			if(strpos($results[7],'Code 40813') == false AND strpos($results[8],'Invalid') == false) {
				$onu_type = explode(" ", $results[9]);
				$onu_type = str_replace(".", "", $onu_type[16]);
				
				if($node->type == null) {
					@sqlengine::query("UPDATE `nodes` SET `type` = '$onu_type' WHERE `id` = '$node->id'");
				}
			}
			unset($this->result);
		}
	}
	function hourly() {
		function microtime_float() {
			list($usec, $sec) = explode(" ", microtime());
			return ((float)$usec + (float)$sec);
		}
		$time_overall = microtime_float();
		$current_time = date("H:i a");
		$start = "2:00 am";
		$end = "7:00 am";
		$date1 = DateTime::createFromFormat('H:i a', $current_time);
		$date2 = DateTime::createFromFormat('H:i a', $sunrise);
		$date3 = DateTime::createFromFormat('H:i a', $sunset);
		if ($date1 > $date2 && $date1 < $date3) {
			exit;
		}
	
		@sqlengine::query("SELECT * FROM `nodes` WHERE `state` != 'not found' ORDER BY `id`");
		$this->nodes = $this->result;
		unset($this->result);
		
		$nodes = $this->nodes;
		
		foreach($nodes as $node) {
			$time_start = microtime_float();
			
			$command = "show remote onu transceiver info $node->name";
			@telnet::execute($command,$cron='1');
			$results = $this->result;
			
			if(strpos($results[7],'Code 40300') == false AND strpos($results[8],'Invalid') == false) {
				$temperature = explode(":", $results[8]);
				$temperature = trim($temperature[1]);
				
				$voltage = explode(" ", $results[9]);
				$voltage = trim($voltage[2]);

				$bias = explode(" ", $results[10]);
				$bias = trim($bias[2]);
				
				$txpower = explode(" ", $results[11]);
				$txpower = trim($txpower[2]);
				
				$rxpower = explode(" ", $results[12]);
				$rxpower = trim($rxpower[2]);
				$rxpower = str_replace("-", "", $rxpower);
				
				$temperaturemax = $node->transTemperatureMax;
				$voltagemax = $node->supplyVoltageMax;
				$biasmax = $node->txBiasCurrentMax;
				$txpowermax = $node->txPowerMax;
				$rxpowermax = $node->rxPowerMax;
				
				$temperaturemin = $node->transTemperatureMin;
				$voltagemin = $node->supplyVoltageMin;
				$biasmin = $node->txBiasCurrentMin;
				$txpowermin = $node->txPowerMin;
				$rxpowermin = $node->rxPowerMin;
				
				$rxDiff = $rxpower - $rxpowermin;
				$rxDiff = round($rxDiff,2);
				
				//Avoid 'username' in database
				if($voltage == 'username') {
					continue;
				}
				
				//Update Diffrence between rxMin and rxCurrent
				@sqlengine::query("UPDATE `nodes` SET `rxPowerDiff` = '$rxDiff' WHERE `id` = '$node->id'");
				
				//Update MAX values
				if($temperaturemax < $temperature) {
					@sqlengine::query("UPDATE `nodes` SET `transTemperatureMax` = '$temperature' WHERE `id` = '$node->id'");
				}
				if($voltagemax < $voltage) {
					@sqlengine::query("UPDATE `nodes` SET `supplyVoltageMax` = '$voltage' WHERE `id` = '$node->id'");
				}
				if($biasmax < $bias) {
					@sqlengine::query("UPDATE `nodes` SET `txBiasCurrentMax` = '$bias' WHERE `id` = '$node->id'");
				}
				if($txpowermax < $txpower) {
					@sqlengine::query("UPDATE `nodes` SET `txPowerMax` = '$txpower' WHERE `id` = '$node->id'");
				}
				if($rxpowermax < $rxpower) {
					@sqlengine::query("UPDATE `nodes` SET `rxPowerMax` = '$rxpower' WHERE `id` = '$node->id'");
				}
				
				//Update MIN values
				if($temperaturemin > $temperature) {
					@sqlengine::query("UPDATE `nodes` SET `transTemperatureMin` = '$temperature' WHERE `id` = '$node->id'");
					
					//Update Diffrence between rxMin and rxCurrent
					@sqlengine::query("UPDATE `nodes` SET `rxPowerDiff` = '$rxDiff' WHERE `id` = '$node->id'");
				}
				if($voltagemin > $voltage) {
					@sqlengine::query("UPDATE `nodes` SET `supplyVoltageMin` = '$voltage' WHERE `id` = '$node->id'");
				}
				if($biasmin > $bias) {
					@sqlengine::query("UPDATE `nodes` SET `txBiasCurrentMin` = '$bias' WHERE `id` = '$node->id'");
				}
				if($txpowermin > $txpower) {
					@sqlengine::query("UPDATE `nodes` SET `txPowerMin` = '$txpower' WHERE `id` = '$node->id'");
				}
				if($rxpowermin > $rxpower) {
					@sqlengine::query("UPDATE `nodes` SET `rxPowerMin` = '$rxpower' WHERE `id` = '$node->id'");
				}
								
				//Current data
				@sqlengine::query("UPDATE `nodes` SET `transTemperature` = '$temperature',`supplyVoltage`='$voltage',`txBiasCurrent`='$bias',`txPower`='$txpower',`rxPower`='$rxpower',`state`='online',`last_update`=NOW() WHERE `id` = '$node->id'");				
			}
			if(strpos($results[7],'Code 40300') == true AND strpos($results[8],'Invalid') == false) {
				@sqlengine::query("UPDATE `nodes` SET `state` = 'offline', `last_update` = NOW() WHERE `id` = '$node->id'");
			}
			if(strpos($results[7],'Code 40300') == false AND strpos($results[8],'Invalid') == true) {
				@sqlengine::query("UPDATE `nodes` SET `state` = 'not found' WHERE `id` = '$node->id'");
			}
			
			$command = "show remote onu info $node->name";
			@telnet::execute($command,$cron='1');
			$results = $this->result;
			
			if(strpos($results[7],'Code 40813') == false AND strpos($results[8],'Invalid') == false) {
				$onu_type = explode(" ", $results[9]);
				$onu_type = str_replace(".", "", $onu_type[16]);
				
				if($node->type == null) {
					@sqlengine::query("UPDATE `nodes` SET `type` = '$onu_type' WHERE `id` = '$node->id'");
				}
			}
			$time_end = microtime_float();
			$time = $time_end - $time_start;
			echo "$node->name Respond: ".round($time,2)."s\n";
		}
			$overall = $time_end - $time_overall;
			echo "TOTAL TIME: ".round($overall,2)."s\n";
	}
	function auth() {
		@sqlengine::query("SELECT * FROM `nodes` WHERE `state` != 'not found' ORDER BY `id`");
		$this->nodes = $this->result;
		unset($this->result);
		
		$nodes = $this->nodes;
		
		foreach($nodes as $node) {
			$command = "show onu authentication $node->name";
			@telnet::execute($command,$cron='1');
			$result = $this->result;
			unset($this->result);

			/*$mac = explode(":", $result[10]);
			$mac = trim($mac[1]);
			$mac = str_replace(".","",$mac);
			$mac = $mac[0].$mac[1].":".$mac[2].$mac[3].":".$mac[4].$mac[5].":".$mac[6].$mac[7].":".$mac[8].$mac[9].":".$mac[10].$mac[11];
			$mac = strtoupper($mac);*/
			
			$Register_Time = explode(":", $result[21]);
			$Register_Time = trim($Register_Time[1].":".$Register_Time[2].":".$Register_Time[3]);
			
			$LastAuthTime = explode(":", $result[22]);
			$LastAuthTime = trim($LastAuthTime[1].":".$LastAuthTime[2].":".$LastAuthTime[3]);
			
			$Deregister_Time = explode(":", $result[23]);
			$Deregister_Time = trim($Deregister_Time[1].":".$Deregister_Time[2].":".$Deregister_Time[3]);
			
			@sqlengine::query("UPDATE `nodes` SET `Register_Time` = '$Register_Time', `LastAuthTime` = '$LastAuthTime', `Deregister_Time` = '$Deregister_Time' WHERE `id` = '$node->id'");
		}
	}
	
	function macs() {
		@sqlengine::query("SELECT * FROM `nodes` WHERE `state` != 'not found'");
		$this->nodes = $this->result;
		unset($this->result);
		
		$nodes = $this->nodes;
		
		foreach($nodes as $node) {
			$command = "show mac epon onu $node->name";
			@telnet::execute($command,$cron='1');
			$result = $this->result;
			unset($this->result);
			
			$node_name = $node->name;
			
			$results = array_filter($result, function ($item) use ($node_name) {
				if (stripos($item, $node_name) !== false) {
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
			
			unset($macs[0]);
			
			foreach($macs as $mac) {
				$showmac = $mac[0];
				$showmac = str_replace(".","",$showmac);
				$showmac = $showmac[0].$showmac[1].":".$showmac[2].$showmac[3].":".$showmac[4].$showmac[5].":".$showmac[6].$showmac[7].":".$showmac[8].$showmac[9].":".$showmac[10].$showmac[11];
				$showmac = strtoupper($showmac);
				@sqlengine::query("SELECT * FROM `macs` WHERE `mac` = '$showmac'");
				if(empty($this->result)) {
					@sqlengine::query("INSERT INTO `macs` (`id`, `id_node`, `mac`) VALUES (null, '".$node->id."', '".$showmac."')");
				}
				unset($this->result);
			}

			unset($node_name,$node->name,$node->id,$node,$macs);
		}
	}
	
	function users() {
		@sqlengine::query("SELECT * FROM `macs`");
		$this->macs = $this->result;
		unset($this->result);
		
		$macs = $this->macs;
		
		foreach($macs as $mac) {
			@sqlengine::query("UPDATE `users` SET `id_node` = '$mac->id_node' WHERE `mac` = '$mac->mac'");
		}
		unset($this->result);		
	}
}
