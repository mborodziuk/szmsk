<?php

include "func/config.php";
$dbh=DBConnect($DBNAME1);

include "customers/customers.php";
$customers=new CUSTOMERS();

include "iptv/iptv.php";
$iptv=new IPTV();

include ("failures/failures.php");
$failures=new FAILURES();

include ("zlecenia/zlecenia.php");
$zlecenia=new ZLECENIA();

include ("voip/voip.php");
$voip=new VOIP();

include ("email/email.php");
$email=new EMAIL();

include ("mailboxes/mailboxes.php");
$mailboxes=new MAILBOXES();

switch ( $_GET["menu"] )
				{
	    			case "abonenci":
 							include("customers/wwwabonenci.php");
							break;
   				case "dodajabon":
	        				include("customers/dodajabon.php");
							break;
					case "newabonwyslij" :
						if ( $customers->ValidateAbon($dbh))
							{
	 							$customers->AddNewAbon($dbh);
	 							include("customers/wwwabonenci.php");
							}
						else
								include("customers/dodajabon.php");
							break;
					case "updateabon" :
								include("customers/updateabon.php");
							break;
					case "updateabonwyslij" :
						if ( $customers->ValidateAbon($dbh))
							{
								$customers->UpdateAbon($dbh, $_GET["abon"]);
	 							include("customers/wwwabonenci.php");
							}
						else
								include("customers/updateabon.php");
							break;
					case "updateum" :
								include("customers/updateum.php");
								break;
					case "addum" :
								include("customers/addum.php");
							break;
					case "cntraddsend":		
						if ( $customers->ContractValidate($dbh) )
							{
								$customers->ContractAdd($dbh, $_GET[abon]);
	 							include("customers/wwwabonenci.php");
							}
						else
								include("customers/addum.php");
							break;
								break;								
					case "cntrupdsend":		
						if ( $customers->ContractValidate($dbh) )	
							{
								$customers->ContractUpdate($dbh, $_GET[um]);
	 							include("customers/wwwabonenci.php");
							}
						else
								include("customers/updateum.php");
						break;					
					case "komputery" :
							include("php-inst/komputery.php");
							break;
					case "dodajkomp" :
							include("php-inst/dodajkomp.php");
							break;
					case "kompwyslij" :
						if ( ValidateKomp())
							{
	 							AddNewKomp();
								include("php-inst/komputery.php");
							}
						else
							include("php-inst/dodajkomp.php");
							break;
					case "updatekomp" :
							include("php-inst/updatekomp.php");
							break;
					case "updatekompwyslij" :
						if ( ValidateKomp("update"))
							{
								UpdateKomp($_GET["komp"]);
								include("php-inst/komputery.php");
							}
						else
							include("php-inst/updatekomp.php");
							break;

// Bramki Voip

					case "bmk" :
							include("voip/wwwbmk.php");
							break;
					case "addgate" :
							include("voip/addgate.php");
							break;
					case "updategate" :
							include("voip/updategate.php");
							break;
					case "sendgate" :
						if ( $voip->ValidateGate())
							{
	 							$voip->AddGate($dbh);
								include("voip/wwwbmk.php");
							}
						else
							include("voip/addgate.php");
							break;							
					case "sendupdgate" :
						if ( $voip->ValidateGate())
							{
	 							$voip->UpdateGate($dbh, $_GET[gate]);
								include("voip/wwwbmk.php");
							}
						else
							include("voip/updategate.php");
							break;									
// Telefony Voip

					case "tlv" :
							include("voip/wwwtlv.php");
							break;
					case "addtlv" :
							include("voip/addtlv.php");
							break;
					case "updatetlv" :
							include("voip/updatetlv.php");
							break;
					case "sendtlv" :
						if ( $voip->ValidateTlv())
							{
	 							$voip->AddTlv($dbh);
								include("voip/wwwtlv.php");
							}
						else
							include("voip/addtlv.php");
							break;							
					case "sendupdtlv" :
						if ( $voip->ValidateTlv())
							{
	 							$voip->UpdateTlv($dbh, $_GET[tlv]);
								include("voip/wwwtlv.php");
							}
						else
							include("voip/updatetlv.php");
							break;
							
// I P T V
					case "stb" :
							include("iptv/wwwstb.php");
							break;						
					case "addstb" :
							include("iptv/addstb.php");
							break;
					case "sendstb" :
						if ( $iptv->ValidateSTB())
							{
	 							$iptv->AddSTB($dbh);
								include("iptv/wwwstb.php");
							}
						else
							include("iptv/addstb.php");
							break;				
					case "updatestb" :
							include("iptv/updatestb.php");
							break;							
					case "sendupdstb" :
						if ( $iptv->ValidateSTB())
							{
	 							$iptv->UpdateSTB($dbh, $_GET[stb]);
								include("iptv/wwwstb.php");
							}
						else
							include("voip/updatestb.php");
							break;
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
// ZLECENIA
					case "zlecenia" :
							include("zlecenia/wwwzlecenia.php");
							break;
					case "dodajzlecenie" :
							include("zlecenia/dodajzlc.php");
							break;
					case "dodajzlcwyslij" :
						if ( $zlecenia->ValidateZlecenie())
							{
	  							$zlecenia->DodajZlecenie();
							include("zlecenia/wwwzlecenia.php");
							}
							else 
							include("zlecenia/wwwzlecenia.php");
							break;
					case "updatezlc" :
							include("zlecenia/updatezlc.php");			
							break;
					case "updatezlcwyslij" :
							if ( $zlecenia->ValidateZlecenie())
								{
  								$zlecenia->UpdateZlc($_GET[zlc]);
									include("zlecenia/wwwzlecenia.php");
								}
							else 
									include("zlecenia/updatezlc.php");
							break;

					case "dodajwkzc" :
							include("zlecenia/dodajwkzc.php");
							break;
					case "dodajwkzcwyslij" :
						if ($zlecenia->ValidateWykZlc())
							{
	  						$zlecenia->DodajWykZlc($_GET[zlc]);
								include("zlecenia/wwwzlecenia.php");
							}
							else 
							include("zlecenia/dodajwkzc.php");
							break;

					case "updatewkzc" :
							include("zlecenia/updatewkzc.php");
							break;
					case "updatewkzcwyslij" :
							if ( $zlecenia->ValidateUpWykZlc())
								{
	  								$zlecenia->UpdateWykZlc($_SESSION[wykonywanie_zlecen][id_zlc], $_SESSION[wykonywanie_zlecen][id_wkzc]);
							include("zlecenia/wwwzlecenia.php");
								}
							else 
									include("zlecenia/updateuswkzc.php");
							break;
// Email							
					case "wwwmailboxes" :
							include("mailboxes/wwwmailboxes.php");
							break;							
					case "mailboxesadd" :
							if ( $mailboxes->ValidateAdd())
								{					
									$mailboxes->Add($dbh);
								}
									include("mailboxes/wwwmailboxes.php");								
							break;	
							
					case "generate":
						Generate($_GET[typ]);
						echo "Nowe ustawienia wprowadzono do systemu";
						break;

					case "delete":
 						Delete($_SESSION[del1], $_SESSION[del2],$_GET[typ]);
						break;
			
					case NULL :
				 			include("func/auth.php");
							break;
					case "zaloguj" :
				 			include("func/auth.php");
							break;
					case "authwyslij" :
				 			if ( ValidateAuth() )
								include("php-inst/informations.php");
							else
								include("func/auth.php");
							break;
					default :
				 			include("func/auth.php");
							break;
					}

?>