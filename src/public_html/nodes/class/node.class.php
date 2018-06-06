<?php
class node extends telnet {
	function addnode($device,$node,$mac,$type,$tv,$voip,$password='',$vlan) {
		if($type == 'ZTE-F420') {
			$ports = Array(
					"vlan port eth_0/1 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/2 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/3 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/4 mode hybrid def-vlan $vlan vlan $tv"
			);
		} elseif($type == 'ZTE-F460') {
			$ports = Array(
					"vlan port eth_0/1 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/2 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/3 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/4 mode hybrid def-vlan 1 vlan $tv"
			);
   		} elseif($type == 'EL-FHR2411K') {
                        $ports = Array(
                                        "vlan port eth_0/1 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/2 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/3 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/4 mode hybrid def-vlan 1 vlan $tv"
                        );

		} else {
			$ports = Array("vlan port eth_0/1 mode hybrid def-vlan $vlan vlan $tv");
		}
		
		$onu = explode(":",$node);
		$onu = $onu[1];

		$commands = Array(
			"configure terminal",
			"interface $device",
			"onu $onu type $type mac $mac",
			"exit",
			"interface $node",
			"sla-profile 300M",
			"admin enable",
			"switchport mode trunk",
			"switchport vlan $vlan tag",
			"switchport vlan $tv tag",
			"exit",
			"pon-onu-mng $node"
		);
		
		$command = array_merge($commands,$ports);
		unset($commands,$ports);
		
		$commands = Array(
			"exit",
			"exit",
			"write"
		);
		
		$command = array_merge($command,$commands);
		unset($commands);
		
		echo "<pre>";
		print_r($command);
		echo "</pre><br><br>";
		
		@telnet::execute($command);
		@sqlengine::query("UPDATE `nodes` SET `mac` = '$mac', `state` = 'offline', `type` = '$type' WHERE `name` = '$node'");
		
		unset($command);
		
		$command = "show remote onu vlan $node";
		
		@telnet::execute($command);
		$results = $this->result;
		echo "<b>Result of $command</b><pre>";
		print_r($results);
		echo "</pre>";
	}
	
	function renew($node,$type,$vlan,$tv) {
		if($type == 'ZTE-F420') {
			$ports = Array(
					"vlan port eth_0/1 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/2 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/3 mode hybrid def-vlan $vlan vlan $tv",
					"vlan port eth_0/4 mode hybrid def-vlan $vlan vlan $tv"
			);
		} elseif($type == 'ZTE-F460') {
			$ports = Array(
					"vlan port eth_0/1 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/2 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/3 mode hybrid def-vlan 1 vlan $tv",
					"vlan port eth_0/4 mode hybrid def-vlan 1 vlan $tv"
			);
           	} elseif($type == 'EL-FHR2411K') {
                        $ports = Array(
                                        "vlan port eth_0/1 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/2 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/3 mode hybrid def-vlan 1 vlan $tv",
                                        "vlan port eth_0/4 mode hybrid def-vlan 1 vlan $tv"
                        );

		} else {
			$ports = Array("vlan port eth_0/1 mode hybrid def-vlan $vlan vlan $tv");
		}
		
		$commands = Array(
			"configure terminal",
			"pon-onu-mng $node",
		);
		
		$command = array_merge($commands,$ports);
		unset($commands,$ports);
		
		$commands = Array(
			"exit",
			"exit",
			"write"
		);
		
		$command = array_merge($command,$commands);
		unset($commands);
		
		echo "<pre>";
		print_r($command);
		echo "</pre><br><br>";
		
		@telnet::execute($command);
		
		unset($command);
		
		$command = "show remote onu vlan $node";
		
		@telnet::execute($command);
		$results = $this->result;
		echo "<b>Result of $command</b><pre>";
		print_r($results);
		echo "</pre>";
	}
	
	function delnode($device,$onu,$id) {
		$device = str_replace("onu","olt",$device);
		$command = Array(
			"configure terminal",
			"interface $device",
			"no onu $onu",
			"exit",
			"exit",
			"write",
			"exit"
		);
		
		@telnet::execute($command);
		@sqlengine::query("UPDATE `nodes` SET `state` = 'not found' WHERE `id` = '$id'");
	}
	
	function adduser($name,$number,$street,$desc,$node,$mac) {
		@sqlengine::query("SELECT `id` FROM `nodes` WHERE `name` = '$node' LIMIT 1");
		$this->nodes = $this->result;
		unset($this->result);
		
		$nodes = $this->nodes;
		foreach($nodes as $node) {
			$node_id = $node->id;
		}
		
		@sqlengine::query("SELECT id FROM `users` WHERE `id_node` = '$node_id' LIMIT 1");
		$this->users = $this->result;
		unset($this->result);
		
		$users = $this->users;
		if(empty($users)) {
			@sqlengine::query("INSERT INTO `users` (`id`,`id_node`,`abon_nr`,`name`,`street`,`desc`,`mac`) VALUES (null, '".$node_id."','".$number."','".$name."','".$street."','".$desc."','".$mac."')");
		} else {
			foreach($users as $user) {
				@sqlengine::query("UPDATE `users` SET `name` = '$name', `street` = '$street', `desc` = '$desc', `mac` = '$mac', `abon_nr` = '$number' WHERE `id` = '$user->id'");
			}
		}
	}
	
	function changeuser($name,$number,$street,$desc,$node,$mac,$id) {
		@sqlengine::query("UPDATE `users` SET `name` = '$name', `street` = '$street', `desc` = '$desc', `mac` = '$mac', `abon_nr` = '$number' WHERE `id` = '$id'");
	}	
}
