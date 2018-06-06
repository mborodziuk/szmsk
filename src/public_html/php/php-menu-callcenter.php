<?php

include "func/config.php";
$dbh=DBConnect($DBNAME1);

include "customers/customers.php";
$customers=new CUSTOMERS();


include ("failures/failures.php");
$failures=new FAILURES();

include ("email/email.php");
$email=new EMAIL();

include ("mailboxes/mailboxes.php");
$mailboxes=new MAILBOXES();

switch ( $_GET["menu"] )
				{


// A W A R I E
					case "awarie" :
							include("failures/wwwawarie.php");
							break;
					case "dodajawarie" :
							include("failures/dodajawarie.php");
							break;
					case "dodajawariewyslij" :
						if ( $failures->ValidateAwarie())
							{
								$failures->AddNewAwarie($dbh);
								include("failures/wwwawarie.php");
							}
							else 
								include("failures/wwwawarie.php");
							break;
					case "updateawarie" :
							include("failures/updateawarie.php");
							break;
					case "updateawrwyslij" :
							if ( $failures->ValidateAwarie() )
								{
									$failures->UpdateAwarie($dbh, $_GET[awr]);
									include("failures/wwwawarie.php");
								}
							else 
									include("failures/updateawarie.php");
							break;

					case "dodajusawr" :
							include("failures/dodajusawarie.php");
							break;
					case "dodajusawrwyslij" :
						if ( $failures->ValidateUsAwr())
							{
								$failures->AddNewUsAwr($dbh, $_GET[awr]);
								include("failures/wwwawarie.php");
							}
							else 
								include("failures/wwwawarie.php");
							break;
					case "updateusawarie" :
							include("failures/updateusawarie.php");
							break;
					case "updateusawrwyslij" :
							if ( $failures->ValidateUpUsAwr())
								{
									$failures->UpdateUsAwr($dbh, $_SESSION[awaria][id_awr], $_SESSION[usuwanie_awarii][id_usaw]);
									include("failures/wwwawarie.php");
								}
							else 
									include("failures/updateusawarie.php");
							break;
			
					case NULL :
				 			include("func/auth.php");
							break;
					case "zaloguj" :
				 			include("func/auth.php");
							break;
					case "authwyslij" :
				 			if ( $_SESSION['uprawnienia']=='callcenter' )
								include("failures/wwwawarie.php");
							else
								include("func/auth.php");
							break;
					default :
				 			include("func/auth.php");
							break;
					}

?>