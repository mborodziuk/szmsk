<?php

class Telnet 
{
    var $host;
    var $port;
    var $login;
    var $connection;
    var $errno;
    var $errstr;
    var $bashPrompt = "apacheTelnetPrompt";
    var $timeout = 30; // Set this to 30
 
    function Telnet($host,$port) {
    	$this->host = $host;
	$this->port = $port;
    }

    function connect() {
	$this->connection =fsockopen($this->host, $this->port, $this->errno, $this->errstr, 30);
	fread($this->connection, 3);
	$send = array(255,251,24);
	$this->sendBytes($send);
	fread($this->connection, 9);

	$send = array(255,251,32,255,252,35,255,251,39);
	$this->sendBytes($send);
	fread($this->connection, 18);

	$send = array(255, 250, 32, 0, 51, 56, 52, 48, 48, 44, 51, 56,
			 52, 48, 48, 255, 240, 255, 250, 39, 0, 255, 240,
			 255, 250, 24, 0, 76, 73, 78, 85, 88, 255, 240);
	$this->sendBytes($send);
	fread($this->connection, 15);

	$send = array(255, 253, 3, 255, 252, 1, 255, 251, 31, 255, 250, 31,
			0, 80, 0, 25, 255, 240, 255, 253, 5, 255, 251, 33);
	$this->sendBytes($send);

// Get the login prompt
	if($this->expect("login: "))
	    return TRUE;
	else
	    return FALSE;
    }

// Loing method
// Accepts two strings (login name , password)
	function login($login, $password) 
		{
		$this->login = $login;

		$send = array(255, 253, 1);
		$this->sendBytes($send);
	// Send the login name here
		$this->send($this->login."\r".chr(0));
		
	// Expect the Password prompt and send the password
		if(!$this->expect("Password: "))
				return FALSE;

	// Send the password
		$this->send($password."\r".chr(0));

	// Expect the success in login
		if(!$this->expect("Last login: "))
				return FALSE;

	// Set the prompt
		$this->send("export PS1=$this->bashPrompt\r".chr(0));
	// Read the echoed output
		if(!$this->expect("export PS1=$this->bashPrompt\r\n"))
				return false;

	// Expect the changed prompt
		if(!$this->expect($this->bashPrompt))
				return FALSE;

	// You are logged in, return true
		return true;
		}

// Accepted: an array of integers
    function sendBytes($send) {
	for($i = 0; $i < sizeof($send); $i++)
	    if(fwrite($this->connection, chr($send[$i])) == -1)
		return false;
	return true;
    }

    function expect($expected) {
	while(true) {
	    $read = $this->getCharWithTimeout($this->timeout);
	    if(!$read)
		return false;
	    if($read != $expected[0])
		continue;

	    $index = 1;
	    while($index < strlen($expected)) {
		$read = $this->getCharWithTimeout($this->timeout);
		if(!$read)
		    return false;
		if($read == $expected[$index])
		    $index++;
		else if($read == $expected[0])
		    $index = 1;
		else
		    continue 2;
	    }
	    return true;
	}
    }

// Send a string to the socket
// Accepted: the string to be sent
    function send($string) {
	if(fwrite($this->connection, $string) == -1)
	    return false;
	else
	    return true;
    }

    function getCharWithTimeout($timeout) {
	socket_set_blocking($this->connection, false);
	for($i = 0; $i < $timeout; $i++) {
	    $read = fgetc($this->connection);
	    // remove the line below
	    //echo $read;
	    if($read) {
		socket_set_blocking($this->connection, true);
		return $read;
	    } else
		sleep(1);
	}
	socket_set_blocking($this->connection, true);
	return false; 
    }

    function isBashPrompt($value) {
	if($value == $this->bashPrompt)
	    return TRUE;
	else
	    return FALSE;
    }

    function getExitStatus() {
	$this->flushInput();
	$this->send("echo $?\r".chr(0));
	$this->expect("echo $?\r\n"); // Read the echoed output
	$status = fgets($this->connection, 4096);
	return $status;
    }

// Reads all the content present at the input
    function flushInput() {
	$all;
	$info = socket_get_status($this->connection);
	for($i = 0; $i < $info['unread_bytes']; $i++)
	    $all .= fgetc($this->connection);
	return $all;
    }
	
    function logout() {
	$this->send("exit\r".chr(0));
	usleep(25000);
	$this->flushInput();
	fclose($this->connection);
    }
}
?>