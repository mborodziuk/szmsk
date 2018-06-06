<?php
include "func/config.php";
$dbh=DBConnect($DBNAME1);


include ("failures/failures.php");
$failures=new FAILURES();

		
					switch ( $_GET["menu"] )
					{
			
					case "wyloguj" :
							session_destroy();
							include("func/auth.php");
							break;
					case "informacje" :
							include("php-abon/informations.php");
							break;

					case "daneabonenta" :
							include("php-abon/updateabon.php");
							break;
					case "updateabonwyslij" :
							if ( ValidateAbon2() )
							{
								UpdateAbon2($_GET["abon"]);
								include("php-abon/updateabon.php");
							}
							break;

					case "komputery" :
							include("php-abon/komputery.php");
							break;
					case "kompwyslij" :
						if ( ValidateKomp())
							{
	 							AddNewKomp();
								include("php-abon/komputery.php");
							}
							break;
					case "updatekomp" :
							include("php-abon/updatekomp.php");
							break;
					case "updatekompwyslij" :
						if ( ValidateKomp())
							{
								UpdateKomp($_GET["komp"]);
								include("php-abon/komputery.php");
							}
						else
							include("php-abon/updatekomp.php");
							break;

					case "konta" :
							include("php-abon/konta.php");
							break;
					case "dodajkonto" :
							if ( CheckHowMany($QUERY8) >=3 )
								echo "Można posiadać maksymalnie 3 konta.";
							else
								include("php-abon/dodajkonto.php");
							break;
					case "dodajkontowyslij" :
						if ( ValidateKonto())
							{
	  							AddNewAccount();
								include("php-abon/konta.php");
							}
							else 
									include("php-abon/dodajkonto.php");
							break;
					case "updatekonto" :
							include("php-abon/updatekonto.php");
							break;
					case "updatekontowyslij" :
							if ( ValidateKonto("update"))
								{
	  								UpdateKonto($_GET[konto]);
									include("php-abon/konta.php");
								}
							else 
									include("php-abon/updatekonto.php");
							break;

					case "vhwww" :
							include("php-abon/vhwww.php");
							break;
					case "dodajvhwww" :
							if ( CheckHowMany($QUERY9) >=1 )
								{
									echo "Można posiadać maksymalnie 1 Wirtualnego Hosta WWW.<br>";
									include("php-abon/vhwww.php");
								}
							else
								include("php-abon/dodajvhwww.php");
							break;
					case "dodajvhwwyslij" :
						if ( ValidateVHW())
							{
								AddNewVHWWW();
								include("php-abon/vhwww.php");
							}
						else
							include("php-abon/dodajvhwww.php");
							break;
					case "updatevhwww" :
							include("php-abon/updatevhwww.php");
							break;
					case "updatevhwwyslij" :
							if ( ValidateVHW("update"))
								{
									UpdateVHWWW($_GET[vhwww]);
									include("php-abon/vhwww.php");
								}
							else 
									include("php-abon/updatevhwww.php");
							break;

					case "vhftp" :
							include("php-abon/vhftp.php");
							break;
					case "dodajvhftp" :
							if ( CheckHowMany($QUERY10) >=1 )
								{
									echo "Można posiadać maksymalnie 1 Wirtualnego Hosta FTP.<br>";
									include("php-abon/vhftp.php");
								}
							else
								include("php-abon/dodajvhftp.php");
							break;
					case "dodajvhfwyslij" :
						if ( ValidateVHF())
							{
								AddNewVHFTP();
								include("php-abon/vhftp.php");
							}
							else
								include("php-abon/dodajvhftp.php");
							break;
					case "updatevhf" :
							include("php-abon/updatevhftp.php");
							break;
					case "updatevhfwyslij" :
							if ( ValidateVHF("update"))
								{
	  								UpdateVHFTP($_GET[vhftp]);
									include("php-abon/vhftp.php");
								}
							else 
									include("php-abon/updatevhftp.php");
							break;

					case "delete":
							unset($_POST[antyspam]);
							unset($_POST[antywir]);
	 						Delete($_SESSION[del1], $_SESSION[del2]);
							break;

					case "generate":
						Generate($_GET[typ]);
						echo "Nowe ustawienia wprowadzono do systemu";
						break;

					default: 
							include("php-abon/informations.php");
							break;
				
					case NULL :
				 			include("func/auth.php");
							break;
					case "zaloguj" :
				 			include("func/auth.php");
							break;
					case "authwyslij" :
				 			if ( ValidateAuth("'admin','fin','inst','user'",$_SESSION[login],$_SESSION[haslo]) )
								include("php-abon/informations.php");
				 			else if ( ValidateAuth("'callcenter'",$_SESSION[login],$_SESSION[haslo]) )
									include("failures/dodajawarie.php");
							else
								include("func/auth.php");
							break;
					default :
				 			include("func/auth.php");
							break;
					}
	?>
