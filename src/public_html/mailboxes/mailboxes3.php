<?

class MAILBOXES
{

	function Add()
	{
		$cmd="/var/vpopmail/bin/vadduser $_POST[login] $_POST[haslo] && /var/vpopmail/bin/valias  $_POST[login] $_POST[alias]";

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