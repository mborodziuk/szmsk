<?php

class MAILBOXES
{

	function Add()
	{
		$cmd="/usr/bin/sudo /var/vpopmail/bin/vadduser $_POST[login] $_POST[haslo] && /usr/bin/sudo /var/vpopmail/bin/valias -i $_POST[login] $_POST[alias1] && /usr/bin/sudo /var/vpopmail/bin/valias -i $_POST[login] $_POST[alias2]";
				
		if	( $last_line=system($cmd, $ret_val) )
			echo "$last_line <br> $ret_val 1 <br>";
	}
	
	function ValidateAdd()
	{
			if ( !empty($_POST[login]) && !empty($_POST[haslo1]) && !empty($_POST[haslo2]) )
				$flag=1;
			else
			{
							echo "Pola \"adres e-mail\", \"hasło\"  nie powinny być puste <br>";
							$flag=0;
			}
			if ( $_POST[haslo1] == $_POST[haslo2] )
				$flag=1;
			else
			{
							echo "Wpisane hasła różnią się ! <br>";
							$flag=0;
			}			
			return $flag;
	}
	
}

?>