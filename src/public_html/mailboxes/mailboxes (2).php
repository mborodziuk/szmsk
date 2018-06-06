<?

class MAILBOXES
{

	 function randltr()
	 {
		 $retval = 'a';
		 $rand = rand() % 64;
		 if ($rand < 26) $retval = $rand + 'a';
		 if ($rand > 25) $retval = $rand - 26 + 'A';
		 if ($rand > 51) $retval = $rand - 52 + '0';
		 if ($rand == 62) $retval = ';';
		 if ($rand == 63) $retval = '.';
		 return($retval);
	 }
 
	 function mkpasswd3(&$clearpass, &$crypted)
	 {
		 srand ((double)microtime()*1000000);
		 
		 $salt = '$1$';
		 for ($i = 0; $i < 5; $i++) $salt .= $this->randltr();
		 $salt .= '0';
		 
		 $crypted = crypt($clearpass, $salt);
		 
		 if (strlen($crypted) > 0) return(true);
		 return(false);
	 }



	function Add()
	{
		
		$login=explode("@", $_POST[login]);
		$alias=explode("@", $_POST[alias]);
		
		$clearpass=$_POST[haslo];
		$crypted = '';
	 
	 if ($this->mkpasswd3($clearpass, $crypted)) 
			printf("%s -> %s\n", $clearpass, $crypted);
	 else echo("Ohoh");
	 
		$q1="insert into vpopmail values ('$login[0]', '$login[1]','$crypted', 0, 0, '$login[0]', '/var/vpopmail/domains/$login[1]/$login[0]','NOQUOTA' )";
		$q2="insert into valias values ('$alias[0]',  '$alias[1]',  '$_POST[login]')";
		MDB2Query2($q1);
		MDB2Query2($q2);		
		
		
		$cmd="/bin/mkdir -m 777 /var/vpopmail/domains/$login[1]/$login[0] && /bin/mkdir -m 777 /var/vpopmail/domains/$login[1]/$login[0]/.maildir && /bin/mkdir -m 777 /var/vpopmail/domains/$login[1]/$login[0]/.maildir/cur && /bin/mkdir -m 777 /var/vpopmail/domains/$login[1]/$login[0]/.maildir/new && /bin/mkdir -m 777 /var/vpopmail/domains/$login[1]/$login[0]/.maildir/tmp";

		if	( ! $last_line=system($cmd, $ret_val) )
			echo "$last_line  <br> $ret_val <br>";
		else 
			echo "$last_line <br> $ret_val <br>";
		
	}
	
	function ValidateAdd()
	{
			if ( !empty($_POST[login]) && !empty($_POST[haslo]) && !empty($_POST[alias]) )
				$flag=1;
			else
			{
							echo "Pola \"adres e-mail\", \"hasło\" i \"alias\" nie powinny być puste <br>";
							$flag=0;
			}
			
			return $flag;
	}
	
}

?>