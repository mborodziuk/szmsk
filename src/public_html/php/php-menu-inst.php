<?php

include "func/config.php";

$dbh=DBConnect($DBNAME1);
$dbh2=$szmsk->DbC($DBTYPE2, $HOST2, $DBNAME2, $USER2, $PASS2);
//$dbh3=$szmsk->DbC($DBTYPE3, $HOST3, $DBNAME3, $USER3, $PASS3);

include "customers/customers.php";
$customers=new CUSTOMERS();

include "telnet/PHPTelnet.php";
$telnet=new PHPTelnet();

include "telnet/PHPCiscoTelnet.php";
$ctelnet=new PHPCiscoTelnet();

//include "telnet/telnet2.php";
//$telnet=new TELNET();

include "iptv/iptv.php";
$iptv=new IPTV();

include ("failures/failures.php");
$failures=new FAILURES();

include ("complaint/complaint.php");
$complaint=new COMPLAINT();

include ("zlecenia/zlecenia.php");
$zlecenia=new ZLECENIA();

include ("voip/voip.php");
$voip=new VOIP();

include ("email/email.php");
$email=new EMAIL();

include ("mailboxes/mailboxes.php");
$mailboxes=new MAILBOXES();

include ("computers/computers.php");
$computers=new COMPUTERS();

include ("cpe/cpe.php");
$cpe=new CPE();

include ("onu/onu.php");
$onu=new ONU();

include ("router/router.php");
$router=new ROUTER();


include ("ip/ip.php");
$ipc=new IP();

include ("mobile/sim.php");
$sim=new SIM();

include ("mobile/modem.php");
$modem=new MODEM();

include ("plugging/plugging.php");
$plg=new PLUGGING();

include ("prolongation/prolongation.php");
$prl=new PROLONGATION();
	
switch ( $_GET["menu"] )
				{
				
/// Customers
	    			case "abonenci":
 							include("customers/wwwabonenci.php");
							break;
   				case "dodajabon":
	        				include("customers/dodajabon.php");
							break;
					case "newabonwyslij" :
						if ( $customers->ValidateAbon($dbh))
							{
	 							$customers->AddNewAbon($dbh, $dbh2, $plg);
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
								$customers->UpdateAbon($dbh, $dbh2, $_GET["abon"], $plg);
	 							include("customers/updateabon.php");
								echo "Zaktualizowano dane.";
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
	 							include("customers/updateabon.php");
							}
						else
								include("customers/addum.php");
							break;
								break;								
					case "cntrupdsend":		
						if ( $customers->ContractValidate($dbh) )	
							{
								$customers->ContractUpdate($dbh, $_GET[um], $zlecenia, $szmsk);
	 							include("customers/updateabon.php");
							}
						else
								include("customers/updateum.php");
						break;			
   				case "nameadd":
	        				include("customers/nameadd.php");
							break;
					case "nameaddsnd":		
						if ( $customers->AddNameValidate() )	
							{
								$customers->NameAdd($dbh, $_GET[abon]);
	 							include("customers/updateabon.php");
							}
						else
								include("customers/nameadd.php");
						break;
					case "addressadd":
	        				include("customers/addressadd.php");
							break;
					case "addressaddsnd":		
						if ( $customers->AddAddressValidate() )	
							{
								$customers->AddressAdd($dbh, $_GET[abon]);
	 							include("customers/updateabon.php");
							}
						else
								include("customers/addressadd.php");
						break;

   				case "ktkadd":
	        				include("customers/ktkadd.php");
							break;
					case "ktkaddsnd":		
						if ( $customers->AddKtkValidate() )	
							{
								$customers->KtkAdd($dbh, $_GET[abon]);
	 							include("customers/updateabon.php");
							}
						else
								include("customers/ktkadd.php");
						break;
// miejsca instalacji
					case "msiadd" :
							include("computers/msiadd.php");
							break;
					case "msiaddsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$computers->MsiAdd($dbh, $_GET["komp"]);
								include("computers/updatekomp.php");
							}
							break;
/// computers						
					case "komputery" :
							include("computers/wwwkomputery.php");
							break;
					case "dodajkomp" :
							include("computers/dodajkomp.php");
							break;
					case "kompwyslij" :
						if ( $computers->ValidateKomp($dbh, $ipc))
							{
	 							$computers->AddNewKomp($dbh, $szmsk, $ipc);
								include("computers/wwwkomputery.php");
							}
						else
							include("computers/dodajkomp.php");
							break;
					case "updatekomp" :
							include("computers/updatekomp.php");
							break;
					case "updatekompwyslij" :
						if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$computers->UpdateKomp($dbh, $_GET["komp"], $ipc);
								include("computers/updatekomp.php");
							}
						else
							include("computers/updatekomp.php");
							break;
					case "uslugaadd" :
							include("computers/uslugaadd.php");
							break;
					case "uslugaaddsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$computers->UslugaAdd($dbh, $_GET["komp"], $ipc, $_POST[aktywny_od]);
								include("computers/updatekomp.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "taryfaadd" :
							include("computers/taryfaadd.php");
							break;
					case "taryfaaddsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$computers->TaryfaAdd($dbh, $_GET["komp"], $ipc, $_POST[aktywna_od]);
								include("computers/updatekomp.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "deletekomp" :
							$computers->Delete($dbh);
							include("computers/wwwkomputery.php");
							break;								
							
/// cpe		
					case "cpe" :
							$www->TablePrint($dbh, $cpe, $_POST);
							break;
					case "cpeadd" :
							$www->ObjectAdd($dbh, $cpe);
							break;
					case "cpeaddsnd" :
						if ( $cpe->CpeAddValidate($dbh, $ipc))
							{
	 							$cpe->CpeAdd($dbh, $ipc);
								$www->TablePrint($dbh, $cpe, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $cpe);
							break;
					case "cpeupd" :
							include("cpe/cpeupd.php");
							break;
					case "cpeupdsnd" :
						if ( $cpe->CpeUpdValidate($dbh, $ipc))
							{
								$cpe->CpeUpd($dbh, $_GET[cpe]);
								$www->TablePrint($dbh, $cpe, $_POST);
							}
						else
								$cpe->CpeUpd($dbh, $_GET[cpe]);
							break;
					case "trfcpeadd" :
							include("cpe/taryfaadd.php");
							break;
					case "trfcpesnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$cpe->TaryfaAdd($dbh, $_GET["cpe"], $_POST[aktywny_od]);
								include("cpe/cpeupd.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "deletecpe" :
							$cpe->Delete($dbh);
							$www->TablePrint($dbh, $cpe, $_POST);
							break;								
// ONU
					case "onu" :
							$www->TablePrint($dbh, $onu, $_POST);
							break;
					case "onuadd" :
							include("onu/inactive.php");
							$www->ObjectAdd($dbh, $onu);
							break;
					case "onumng" :
							$onu->Mng($_GET[id], $ctelnet);
							break;
					case "onuinf" :
							$onu->Info($_GET[id], $ctelnet, $telnet);
							break;
							
					case "onuaddsnd" :
						if ( $onu->OnuValidate($dbh, $ipc))
							{
	 							$onu->OnuAdd($dbh, $ipc, $ctelnet, $telnet);
								$www->TablePrint($dbh, $onu, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $onu);
							break;
					case "onuupd" :
							include("onu/onuupd.php");
							break;
					case "onuupdsnd" :
						if ( $onu->OnuValidate($dbh, $ipc))
							{
								$onu->OnuUpd($dbh, $_GET[onu]);
							$www->TablePrint($dbh, $onu, $_POST);
							}
						else
								$onu->OnuUpd($dbh, $_GET[onu]);
							break;
					case "trfonuadd" :
							include("onu/taryfaadd.php");
							break;
					case "trfonusnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$onu->TaryfaAdd($dbh, $_GET["onu"], $_POST[aktywny_od]);
								include("onu/onuupd.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "deleteonu" :
							$onu->Delete($dbh, $ctelnet);
							$www->TablePrint($dbh, $onu, $_POST);
							break;							

/// mobile		SIM
					case "sim" :
							$www->TablePrint($dbh, $sim, $_POST);
							break;
					case "simadd" :
							$www->ObjectAdd($dbh, $sim);
							break;
					case "simaddsnd" :
						if ( $sim->simAddValidate($dbh) )
							{
	 							$sim->simAdd($dbh);
								$www->TablePrint($dbh, $sim, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $sim);
							break;
					case "simupd" :
							include("mobile/simupd.php");
							break;
					case "simupdsnd" :
					if ( $sim->simUpdValidate($dbh))
							{
								$sim->simUpd($dbh, $_GET[sim]);
								$www->TablePrint($dbh, $sim, $_POST);
							}
						else
								$sim->simUpd($dbh, $_GET[sim]);
							break;
					case "trfsimadd" :
							include("mobile/taryfaaddsim.php");
							break;
					case "trfsimsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$sim->TaryfaAdd($dbh, $_GET["sim"], $_POST[aktywny_od]);
								include("mobile/simupd.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "cngsimabn" :
							include("mobile/changesimabon.php");
							break;
					case "cngsimabnsnd" :
							$sim->ChangeAbon($dbh, $_GET[sim], $_GET["abon"]);
							$www->TablePrint($dbh, $sim, $_POST);
							break;	
					case "deletesim" :
							$sim->Delete($dbh);
							$www->TablePrint($dbh, $sim, $_POST);
							break;								
/// mobile modem		
					case "modem" :
							$www->TablePrint($dbh, $modem, $_POST);
							break;
					case "modemadd" :
							$www->ObjectAdd($dbh, $modem);
							break;
					case "modemaddsnd" :
						if ( $modem->modemValidate($dbh))
							{
	 							$modem->modemAdd($dbh, $ipc);
								$www->TablePrint($dbh, $modem, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $modem);
							break;
					case "modemupd" :
							include("mobile/modemupd.php");
							break;
					case "modemupdsnd" :
						if ( $modem->modemValidate($dbh))
							{
								$modem->modemUpd($dbh, $_GET[modem]);
								$www->TablePrint($dbh, $modem, $_POST);
							}
						else
								$modem->modemUpd($dbh, $_GET[modem]);
							break;
					case "trfmdmadd" :
							include("mobile/taryfaaddmdm.php");
							break;
					case "trfmdmsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$modem->TaryfaAdd($dbh, $_GET["modem"], $_POST[aktywny_od]);
								include("mobile/modemupd.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "cngmdmabn" :
							include("mobile/changemdmabon.php");
							break;
					case "cngmdmabnsnd" :
							$modem->ChangeAbon($dbh, $_GET[modem], $_GET["abon"]);
							$www->TablePrint($dbh, $modem, $_POST);
							break;	
					case "deletemodem" :
							$modem->Delete($dbh);
							$www->TablePrint($dbh, $modem, $_POST);
							break;								
							
// Routery klienckie
					case "router" :
							$www->TablePrint($dbh, $router, $_POST);
							break;
					case "routeradd" :
							$www->ObjectAdd($dbh, $router);
							break;
					case "routeraddsnd" :
						if ( $router->RouterValidate($dbh, $ipc) )
							{
	 							$router->RouterAdd($dbh);
								$www->TablePrint($dbh, $router, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $router);
							break;
					case "routerupd" :
							include("router/routerupd.php");
							break;
					case "routerupdsnd" :
						if ( $router->RouterValidate($dbh, $ipc))
							{
								$router->RouterUpd($dbh, $_GET[router]);
							$www->TablePrint($dbh, $router, $_POST);
							}
						else
								$router->RouterUpd($dbh, $_GET[router]);
							break;
					case "trfrouteradd" :
							include("router/taryfaadd.php");
							break;
					case "trfroutersnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$router->TaryfaAdd($dbh, $_GET["router"], $_POST[aktywny_od]);
								include("router/routerupd.php");
							}
							break;
					case "cngrtrabn" :
							include("router/changeabon.php");
							break;
					case "cngrtrabnsnd" :
							$router->ChangeAbon($dbh, $_GET[router], $_GET["abon"]);
							$www->TablePrint($dbh, $router, $_POST);
							break;	
					case "deleterouter" :
							$router->Delete($dbh);
							$www->TablePrint($dbh, $router, $_POST);
							break;

							
// Grafik dyĹĽurĂłw
					case "roster" :
							$www->TablePrint($dbh, $roster, $_POST);
							break;
					case "rosteradd" :
							$www->ObjectAdd($dbh, $roster);
							break;
					case "rosteraddsnd" :
						if ( $roster->RosterValidate($dbh, $ipc) )
							{
	 							$roster->RosterAdd($dbh);
								$www->TablePrint($dbh, $roster, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $roster);
							break;
					case "rosterupd" :
							include("roster/rosterupd.php");
							break;
					case "rosterupdsnd" :
						if ( $roster->RosterValidate($dbh, $ipc))
							{
								$roster->RosterUpd($dbh, $_GET[roster]);
							$www->TablePrint($dbh, $roster, $_POST);
							}
						else
								$roster->RosterUpd($dbh, $_GET[roster]);
							break;
					case "trfrosteradd" :
							include("roster/taryfaadd.php");
							break;
					case "trfrostersnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$roster->TaryfaAdd($dbh, $_GET["roster"], $_POST[aktywny_od]);
								include("roster/rosterupd.php");
							}
							break;
					case "deleteroster" :
							$roster->Delete($dbh);
							$www->TablePrint($dbh, $roster, $_POST);
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
						if ( $voip->ValidateGate($dbh, $ipc))
							{
	 							$voip->AddGate($dbh);
								include("voip/wwwbmk.php");
							}
						else
							include("voip/addgate.php");
							break;							
					case "sendupdgate" :
						if ( $voip->ValidateGate($dbh, $ipc))
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
	 							$voip->AddTlv($dbh, $dbh2);
								include("voip/wwwtlv.php");
							}
						else
							include("voip/addtlv.php");
							break;							
					case "sendupdtlv" :
						if ( $voip->ValidateTlv())
							{
	 							$voip->UpdateTlv($dbh, $dbh2, $_GET[tlv]);
								include("voip/wwwtlv.php");
							}
						else
							include("voip/updatetlv.php");
							break;
					case "trftlvadd" :
							include("voip/taryfaadd.php");
							break;
					case "trftlvsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$voip->TaryfaAdd($dbh, $_GET["tlv"]);
								include("voip/updatetlv.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "deletetlv" :
							$voip->Delete($dbh);
							include("voip/wwwtlv.php");
							break;
							
// I P T V
					case "stb" :
							include("iptv/wwwstb.php");
							break;						
					case "addstb" :
							include("iptv/addstb.php");
							break;
					case "sendstb" :
						if ( $iptv->ValidateSTB($dbh, $ipc))
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
						if ( $iptv->ValidateSTB($dbh, $ipc))
							{
	 							$iptv->UpdateSTB($dbh, $_GET[stb]);
							include("iptv/updatestb.php");
							}
						else
							include("iptv/updatestb.php");
							break;
					case "trfstbadd" :
							include("iptv/taryfaadd.php");
							break;
					case "trfstbsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$iptv->TaryfaAdd($dbh, $_GET["stb"], $_POST[aktywny_od]);
								include("iptv/updatestb.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;							
					case "cngstbabn" :
							include("iptv/changeabon.php");
							break;
					case "cngstbabnsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$iptv->ChangeAbon($dbh, $_GET[stb], $_GET["abon"]);
								include("iptv/wwwstb.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;	
					case "deletestb" :
							$iptv->Delete($dbh);
							include("iptv/wwwstb.php");
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
								$failures->AddNewAwarie($dbh, $szmsk);
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
									$failures->UpdateAwarie($dbh, $szmsk, $_GET[awr]);
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
	  							$zlecenia->DodajZlecenie($dbh, $szmsk);
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
  								$zlecenia->UpdateZlc($dbh, $szmsk, $_GET[zlc]);
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
	  						$zlecenia->DodajWykZlc($dbh, $_GET[zlc]);
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
	  								$zlecenia->UpdateWykZlc($dbh, $_SESSION[wykonywanie_zlecen][id_zlc], $_SESSION[wykonywanie_zlecen][id_wkzc]);
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

	// plugging
    			case "plg":
 							include("plugging/wwwplugging.php");
							break;
   				case "plgmake":
						$plg->PlgMake($dbh, $_SESSION[etap], $zlecenia, $szmsk);
						include("plugging/wwwplugging.php");
							break;

  				case "addnewplg":
						$plg->DodajDoWindykacji($dbh);
							break;
    			case "itlupd":
 							include("plugging/itlupd.php");
							break;
    			case "snditlupd":
						if ( $plg->ItlValidate($dbh, $_GET[itl]))
							{
								$plg->ItlUpd($dbh, $_GET[itl]);
								include("plugging/wwwplugging.php");
							}
						else
								include("plugging/itlupd.php");
							break;	
					case "deleteplg" :
							$plg->Delete($dbh);
							include("plugging/wwwplugging.php");
							break;	

	// prolongation
    			case "prl":
 							include("prolongation/wwwprolongation.php");
							break;
    			case "ctrprladdsnd":
						if ( $customers->ContractValidate($dbh) )
							{
								$prl->CtrPrlAdd($dbh, $customers, $_GET[ctr]);
	 							include("prolongation/wwwprolongation.php");
							}
						else
								include("prolongation/ctrprl.php");
							break;
   				case "prlmake":
						$prl->PrlMake($_SESSION[etap], $zlecenia, $szmsk);
						include("prolongation/wwwprolongation.php");
							break;

  				case "addnewprl":
						$prl->DodajDoWindykacji($dbh);
							break;
    			case "negupd":
 							include("prolongation/negupd.php");
							break;
    			case "ctrprl":
 							include("prolongation/ctrprl.php");
							break;

    			case "sndnegupd":
						if ( $prl->NegValidate($dbh, $_GET[neg]))
							{
								$prl->NegUpd($dbh, $_GET[neg]);
								include("prolongation/wwwprolongation.php");
							}
						else
								include("prolongation/negupd.php");
							break;	
					case "deleteprl" :
							$prl->Delete($dbh);
							include("prolongation/wwwprolongation.php");
							break;	
							
							
//  COMPLAINT - REKLAMACJE
					case "complaint" :
							include("complaint/wwwcomplaint.php");
							break;
					case "cpladd" :
							include("complaint/complaintadd.php");
							break;
					case "cpladdsnd" :
						if ( $complaint->ComplaintValidate())
							{
								$complaint->ComplaintAdd($dbh);
								include("complaint/wwwcomplaint.php");
							}
							else 
								include("complaint/wwwcomplaint.php");
							break;
					case "cplupd" :
							include("complaint/complaintupd.php");
							break;
					case "cplupdsnd" :
							if ( $complaint->ComplaintValidate())
								{
									$complaint->ComplaintUpd($dbh, $_GET[cpl]);
									include("complaint/wwwcomplaint.php");
								}
							else 
									include("complaint/complaintupd.php");
							break;
					case "deletecpl" :
							$complaint->Delete($dbh);
							include("complaint/wwwcomplaint.php");
							break;	

							
							
					case "dodajusawr" :
							include("complaint/dodajuscomplaint.php");
							break;
					case "dodajusawrwyslij" :
						if ( $complaint->ValidateUsAwr())
							{
								$complaint->AddNewUsAwr($dbh, $_GET[awr]);
								include("complaint/wwwcomplaint.php");
							}
							else 
								include("complaint/wwwcomplaint.php");
							break;
					case "updateuscomplaint" :
							include("complaint/updateuscomplaint.php");
							break;
					case "updateusawrwyslij" :
							if ( $complaint->ValidateUpUsAwr())
								{
									$complaint->UpdateUsAwr($dbh, $_SESSION[awaria][id_awr], $_SESSION[usuwanie_awarii][id_usaw]);
									include("complaint/wwwcomplaint.php");
								}
							else 
									include("complaint/updateuscomplaint.php");							
							
///////////////////////////////////////////////////							
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
					case "konwertujabon":		
						 $customers->KonwertujAbon2($dbh);
						 break;							
					default :
				 			include("func/auth.php");
							break;
					}

?>