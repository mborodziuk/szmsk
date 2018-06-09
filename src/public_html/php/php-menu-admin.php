<?php

include "func/config.php";
$dbh=DBConnect($DBNAME1);

include "telnet/PHPTelnet.php";
$telnet=new PHPTelnet();

include "telnet/PHPCiscoTelnet.php";
$ctelnet=new PHPCiscoTelnet();
	
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

include ("computers/computers.php");
$computers=new COMPUTERS();

include ("node/node.php");
$node=new NODE();

include ("odf/odf.php");
$odf=new ODF();

include ("ap/ap.php");
$ap=new AP();

include ("patchcord/ptc.php");
$ptc=new PTC();

include ("polaczenie/plc.php");
$plc=new PLC();

include ("olt/olt.php");
$olt=new OLT();

include ("spliter/spliter.php");
$spt=new SPLITER();

include ("mufa/mufa.php");
$mufa=new MUFA();


include ("interface/interface.php");
$ifc=new IFC();

include ("socket/socket.php");
$skt=new SKT();

include ("trakt/trt.php");
$trt=new TRT();

include ("vlan/vlan.php");
$ivn=new VLAN();

include ("subnet/subnet.php");
$subnet=new SUBNET();

include ("sector/sector.php");
$sector=new SECTOR();

include ("taryfa/taryfa.php");
$taryfa=new TARYFA();

include ("line/line.php");
$line=new LINE();

include ("ip/ip.php");
$ipc=new IP();

include ("operator/operator.php");
$operator=new OPERATOR();

include ("indicator/indicator.php");
$indicator=new INDICATOR();

switch ( $_GET["menu"] )
				{
					case "informacje" :
							include("php-admin/informations.php");
							break;
					case NULL :
				 			include("php-admin/informations.php");
							break;
// ABONENCI
	    			case "abonenci":
 							include("customers/wwwabonenci.php");
							break;
   				case "dodajabon":
	        				include("customers/dodajabon.php");
							break;
					case "dodajaboni":
      	  				include("customers/dodajabon.php");
							break;
					case "newabonwyslij" :
						if ( $customers->ValidateAbon($dbh) )
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
							
/// computers						
					case "komputery" :
							include("computers/wwwkomputery.php");
							break;
					case "dodajkomp" :
							include("computers/dodajkomp.php");
							break;
					case "kompwyslij" :
						if ( $computers->ValidateKomp($dbh))
							{
	 							$computers->AddNewKomp($dbh);
								include("computers/wwwkomputery.php");
							}
						else
							include("computers/dodajkomp.php");
							break;
					case "updatekomp" :
							include("computers/updatekomp.php");
							break;
					case "updatekompwyslij" :
						if ( $computers->ValidateKomp($dbh, "update"))
							{
								$computers->UpdateKomp($dbh, $_GET["komp"]);
								include("computers/wwwkomputery.php");
							}
						else
							include("computers/updatekomp.php");
							break;		
/// nodes		
					case "nodes" :
							if(empty($_POST))
									$_POST=$_SESSION[$session[node][pagination]];
							if (empty($_POST[Liczba]))
									$_POST[Liczba]="50";
							$www->PanelPrint($dbh, $node, $_POST);
									$_SESSION[$session[node][pagination]]=$_POST;
							$www->TablePrint($dbh, $node, $_POST);
							break;
					case "nodeadd" :
							$www->ObjectAdd($dbh, $node);
							break;
					case "nodemng" :
							$node->Mng($_GET[id], $telnet);
							break;
					case "nodeaddsnd" :
						if ( $node->NodeValidate())
							{
	 							$node->NodeAdd($dbh);
							if(empty($_POST))
									$_POST=$_SESSION[$session[node][pagination]];
							if (empty($_POST[Liczba]))
									$_POST[Liczba]="50";
							$www->PanelPrint($dbh, $node, $_POST);
									$_SESSION[$session[node][pagination]]=$_POST;
							$www->TablePrint($dbh, $node, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $node);
							break;
					case "nodeupd" :
							include("node/nodeupd.php");
							break;
					case "nodeupdsnd" :
						if ( $node->NodeValidate())
							{
								$node->NodeUpd($dbh, $_GET[node]);
							if(empty($_POST))
									$_POST=$_SESSION[$session[node][pagination]];
							if (empty($_POST[Liczba]))
									$_POST[Liczba]="50";
							$www->PanelPrint($dbh, $node, $_POST);
									$_SESSION[$session[node][pagination]]=$_POST;
							$www->TablePrint($dbh, $node, $_POST);
							break;
							}
						else
							include("node/nodeupd.php");
							break;
					case "deletenode" :
							$node->Delete($dbh);
							if(empty($_POST))
									$_POST=$_SESSION[$session[node][pagination]];
							if (empty($_POST[Liczba]))
									$_POST[Liczba]="50";
							$www->PanelPrint($dbh, $node, $_POST);
									$_SESSION[$session[node][pagination]]=$_POST;
							$www->TablePrint($dbh, $node, $_POST);
							break;	
/// lines		
					case "line" :
							$www->TablePrint($dbh, $line, $_POST);
							break;
					case "lineadd" :
							$www->ObjectAdd($dbh, $line);
							break;
					case "lineaddsnd" :
						if ( $line->LineValidate())
							{
	 							$line->LineAdd($dbh);
								$www->TablePrint($dbh, $line, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $line);
							break;
					case "lineupd" :
							include("line/lineupd.php");
							break;
					case "lineupdsnd" :
						if ( $line->LineValidate())
							{
								$line->LineUpd($dbh, $_GET[line]);
								$www->TablePrint($dbh, $line, $_POST);
							break;
							}
						else
							include("line/lineupd.php");
							break;
					case "deleteline" :
							$line->Delete($dbh);
							$www->TablePrint($dbh, $line, $_POST);
							break;
/// Przełącznice		
					case "odf" :
							$www->TablePrint($dbh, $odf, $_POST);
							break;
					case "odfadd" :
							$www->ObjectAdd($dbh, $odf);
							break;
					case "odfaddsnd" :
						if ( $odf->OdfValidate())
							{
	 							$odf->OdfAdd($dbh);
								$www->TablePrint($dbh, $odf, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $odf);
							break;
					case "odfupd" :
							include("odf/odfupd.php");
							break;
					case "odfupdsnd" :
						if ( $odf->OdfValidate())
							{
								$odf->OdfUpd($dbh, $_GET[odf]);
								$www->TablePrint($dbh, $odf, $_POST);
							break;
							}
						else
							include("odf/odfupd.php");
							break;
					case "deleteodf" :
							$odf->Delete($dbh);
							$www->TablePrint($dbh, $odf, $_POST);
							break;
							
/// aps		
					case "ap" :
							$www->TablePrint($dbh, $ap, $_POST);
							break;
					case "apadd" :
							$www->ObjectAdd($dbh, $ap);
							break;
					case "apaddsnd" :
						if ( $ap->ApValidate())
							{
	 							$ap->ApAdd($dbh);
								$www->TablePrint($dbh, $ap, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $ap);
							break;
					case "apupd" :
							include("ap/apupd.php");
							break;
					case "apupdsnd" :
						if ( $ap->ApValidate())
							{
								$ap->ApUpd($dbh, $_GET[ap]);
								$www->TablePrint($dbh, $ap, $_POST);
							break;
							}
						else
							include("ap/apupd.php");
							break;
					case "deleteap" :
							$ap->Delete($dbh);
							$www->TablePrint($dbh, $ap, $_POST);
							break;	
/// OLT	
					case "olt" :
							$www->TablePrint($dbh, $olt, $_POST);
							break;
					case "oltadd" :
							$www->ObjectAdd($dbh, $olt);
							break;
					case "oltmng" :
							$olt->Mng($_GET[id], $ctelnet);
							break;
					case "oltinf" :
							$olt->Info($_GET[id], $telnet, $ctelnet);
							break;
					case "oltaddsnd" :
						if ( $olt->OltValidate())
							{
	 							$olt->OltAdd($dbh);
								$www->TablePrint($dbh, $olt, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $olt);
							break;
					case "oltupd" :
							include("olt/oltupd.php");
							break;
					case "oltupdsnd" :
						if ( $olt->OltValidate())
							{
								$olt->OltUpd($dbh, $_GET[olt]);
								$www->TablePrint($dbh, $olt, $_POST);
							break;
							}
						else
							include("olt/oltupd.php");
							break;	
					case "deleteolt" :
							$olt->Delete($dbh);
							$www->TablePrint($dbh, $olt, $_POST);
							break;							
							
/// Trakty	
					case "trt" :
							$www->TablePrint($dbh, $trt, $_POST);
							break;
					case "trtadd" :
							$www->ObjectAdd($dbh, $trt);
							break;
					case "trtaddsnd" :
						if ( $trt->TrtValidate())
							{
	 							$trt->TrtAdd($dbh);
								$www->TablePrint($dbh, $trt, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $trt);
							break;
					case "trtupd" :
							include("trakt/trtupd.php");
							break;
					case "trtupdsnd" :
						if ( $trt->TrtValidate())
							{
								$trt->TrtUpd($dbh, $_GET[trt]);
								//$_GET=$_SESSION[$session[mufa][update]];
								include("mufa/mufaupd.php");
							break;
							}
						else
							include("trakt/trtupd.php");
							break;	
					case "deletetrt" :
							$trt->Delete($dbh);
							$www->TablePrint($dbh, $trt, $_POST);
							break;
/// Połączenie	
					case "plc" :
							$www->TablePrint($dbh, $plc, $_POST);
							break;
					case "plcadd" :
							$www->ObjectAdd($dbh, $plc);
							break;
					case "plcaddsnd" :
						if ( $plc->PlcValidate())
							{
	 							$plc->PlcAdd($dbh, $_GET[id_ifc]);
								$www->TablePrint($dbh, $plc, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $plc);
							break;
					case "plcupd" :
							include("polaczenie/plcupd.php");
							break;
					case "plcupdsnd" :
						if ( $plc->PlcValidate())
							{
								$plc->PlcUpd($dbh, $_GET[plc]);
								//$_GET=$_SESSION[$session[mufa][update]];
								include("interface/ifcupd.php");
							break;
							}
						else
							include("polaczenie/plcupd.php");
							break;	
					case "deleteplc" :
							$plc->Delete($dbh);
							$www->TablePrint($dbh, $plc, $_POST);
							break;							
/// Patchcord	
					case "ptc" :
							$www->TablePrint($dbh, $ptc, $_POST);
							break;
					case "ptcadd" :
							$www->ObjectAdd($dbh, $ptc);
							break;
					case "ptcaddsnd" :
						if ( $ptc->PtcValidate())
							{
	 							$ptc->PtcAdd($dbh, $_GET[id_ifc]);
								$www->TablePrint($dbh, $ptc, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $ptc);
							break;
					case "ptcupd" :
							include("patchcord/ptcupd.php");
							break;
					case "ptcupdsnd" :
						if ( $ptc->PtcValidate())
							{
								$ptc->PtcUpd($dbh, $_GET[ptc]);
								//$_GET=$_SESSION[$session[mufa][update]];
								include("interface/ifcupd.php");
							break;
							}
						else
							include("patchcord/ptcupd.php");
							break;	
					case "deleteptc" :
							$ptc->Delete($dbh);
							$www->TablePrint($dbh, $ptc, $_POST);
							break;							
/// Splitery		
					case "spliter" :
							$www->TablePrint($dbh, $spt, $_POST);
							break;
					case "sptadd" :
							$www->ObjectAdd($dbh, $spt);
							break;
					case "sptaddsnd" :
						if ( $spt->SptValidate())
							{
	 							$spt->SptAdd($dbh);
								$www->TablePrint($dbh, $spt, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $spt);
							break;
					case "sptupd" :
							include("spliter/spliterupd.php");
							break;
					case "sptupdsnd" :
						if ( $spt->SptValidate())
							{
								$spt->SptUpd($dbh, $_GET[spt]);
								$www->TablePrint($dbh, $spt, $_POST);
							break;
							}
						else
							include("spliter/spliterupd.php");
							break;
					case "deletespt" :
							$spt->Delete($dbh);
							$www->TablePrint($dbh, $spt, $_POST);
							break;							
							
/// Mufy	
					case "mufy" :
							$www->TablePrint($dbh, $mufa, $_POST);
							break;
					case "mufaadd" :
							$www->ObjectAdd($dbh, $mufa);
							break;
					case "mufaaddsnd" :
						if ( $mufa->MufaValidate())
							{
	 							$mufa->MufaAdd($dbh);
								$www->TablePrint($dbh, $mufa, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $mufa);
							break;
					case "mufaupd" :
							include("mufa/mufaupd.php");
							break;
					case "mufaupdsnd" :
						if ( $mufa->MufaValidate())
							{
								$mufa->MufaUpd($dbh, $_GET[mufa]);
								$www->TablePrint($dbh, $mufa, $_POST);
							break;
							}
						else
							include("mufa/mufaupd.php");
							break;		
					case "deletemufa" :
							$mufa->Delete($dbh);
							$www->TablePrint($dbh, $mufa, $_POST);
							break;	
		
/// interface	
					case "ifc" :
							$www->TablePrint($dbh, $ifc, $_POST);
							break;
					case "ifcadd" :
							$ifca[id_wzl]=$_GET[id_wzl];
							$www->ObjectAdd($dbh, $ifc, $ifca);
							break;
					case "ifcaddsnd" :
							$_GET[node]=$_SESSION[ifc][id_wzl];
						if ( $ifc->IfcValidate())
							{
	 							$ifc->IfcAdd($dbh);
							include("node/nodeupd.php");
							}
						else
							$www->ObjectAdd($dbh, $ifc);
							break;
					case "ifcupd" :
							include("interface/ifcupd.php");
							break;
					case "ifcupdsnd" :
						if ( $ifc->IfcValidate())
							{
								$ifc->IfcUpd($dbh, $_GET[ifc]);
								$_GET[node]=$_SESSION[ifc][id_wzl];
								include("node/nodeupd.php");
							}
						else
							include("interface/ifcupd.php");
							break;	
							
/// Socket	
					case "skt" :
							$www->TablePrint($dbh, $skt, $_POST);
							break;
					case "sktadd" :
							$skta[id_odf]=$_GET[id_odf];
							$www->ObjectAdd($dbh, $skt, $skta);
							break;
					case "sktaddsnd" :
							$_GET[odf]=$_SESSION[skt][id_odf];
						if ( $skt->SktValidate())
							{
	 							$skt->SktAdd($dbh);
							include("odf/odfupd.php");
							}
						else
							$www->ObjectAdd($dbh, $skt);
							break;
					case "sktupd" :
							include("socket/sktupd.php");
							break;
					case "sktupdsnd" :
						if ( $skt->SktValidate())
							{
								$skt->SktUpd($dbh, $_GET[skt]);
								$_GET[odf]=$_SESSION[skt][id_odf];
								include("odf/odfupd.php");
							}
						else
							include("socket/sktupd.php");
							break;
/// vlan
					case "ivn" :
							$www->TablePrint($dbh, $ivn, $_POST);
							break;
					case "ivnadd" :
					$ivna[id_wzl]=$_GET[id_wzl];
							$www->ObjectAdd($dbh, $ivn, $ivna);
							break;
					case "ivnaddsnd" :
						$_GET[node]=$_SESSION[ivn][id_wzl];
						if ( $ivn->IvnValidate($dbh, $ipc))
							{
	 							$ivn->IvnAdd($dbh, $_GET[id_wzl], $ipc);
							include("node/nodeupd.php");
							}
						else
							$www->ObjectAdd($dbh, $ivn);
							break;
					case "ivnupd" :
							include("vlan/ivnupd.php");
							break;
					case "ivnupdsnd" :
						if ( $ivn->IvnValidate($dbh, $ipc))
							{
								$ivn->IvnUpd($dbh, $_GET[ivn], $ipc);
								$_GET[node]=$_SESSION[ivn][id_wzl];
								include("node/nodeupd.php");
							}
						else
							include("vlan/ivnupd.php");
							break;	
// subnet
					case "snt" :
							$www->TablePrint($dbh, $subnet, $_POST);
							break;
					case "subnetadd" :
							$www->ObjectAdd($dbh, $subnet);
							break;
					case "subnetaddsnd" :
						if ( $subnet->SubnetValidate())
							{
	 							$subnet->SubnetAdd($dbh);
								$www->TablePrint($dbh, $subnet, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $subnet);
							break;
					case "subnetupd" :
							include("subnet/subnetupd.php");
							break;
					case "subnetupdsnd" :
						if ( $subnet->SubnetValidate())
							{
								$subnet->SubnetUpd($dbh, $_GET[subnet]);
								$www->TablePrint($dbh, $subnet, $_POST);
							break;
							}
						else
							include("subnet/subnetupd.php");
							break;								
/// sectors
					case "sectors" :
							$www->TablePrint($dbh, $sector, $_POST);
							break;
					case "sectoradd" :
							$www->ObjectAdd($dbh, $sector);
							break;
					case "sectoraddsnd" :
						if ( $sector->SectorValidate())
							{
	 							$sector->SectorAdd($dbh);
								$www->TablePrint($dbh, $sector, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $sector);
							break;
					case "sectorupd" :
							include("sector/sectorupd.php");
							break;
					case "sectorupdsnd" :
						if ( $sector->SectorValidate())
							{
								$sector->SectorUpd($dbh, $_GET[sector]);
								$www->TablePrint($dbh, $sector, $_POST);
							break;
							}
						else
							include("sector/sectorupd.php");
							break;	
// KONTA
					case "konta" :
							include("php-admin/konta.php");
							break;
					case "dodajkonto" :
							include("php-admin/dodajkonto.php");
							break;
					case "dodajkontowyslij" :
						if ( ValidateKonto())
							{
	  							AddNewAccount();
								include("php-admin/konta.php");
							}
							else 
								include("php-admin/dodajkonto.php");
							break;
					case "updatekonto" :
							include("php-admin/updatekonto.php");
							break;
					case "updatekontowyslij" :
							if ( ValidateKonto("update"))
								{
	  								UpdateKonto($_GET[konto]);
									include("php-admin/konta.php");
								}
							else 
									include("php-admin/updatekonto.php");
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
							if ( $failures->ValidateAwarie())
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
					case "dodajzleceniewyslij" :
						if ( $zlecenie->ValidateZlecenie())
							{
	  							$zlecenie->DodajZlecenie();
							include("zlecenia/wwwzlecenia.php");
							}
							else 
							include("zlecenia/wwwzlecenia.php");
							break;
					case "updateawarie" :
							include("failures/updateawarie.php");
							break;
					case "updateawrwyslij" :
							if ( ValidateAwarie())
								{
	  								UpdateAwarie($_GET[awr]);
							include("zlecenia/wwwzlecenia.php");
								}
							else 
									include("func/updateawarie.php");
							break;

					case "dodajusawr" :
							include("func/dodajusawarie.php");
							break;
					case "dodajusawrwyslij" :
						if ( ValidateUsAwr())
							{
	  							AddNewUsAwr($_GET[awr]);
							include("zlecenia/wwwzlecenia.php");
							}
							else 
								include("func/awarie.php");
							break;
					case "updateusawarie" :
							include("func/updateusawarie.php");
							break;
					case "updateusawrwyslij" :
							if ( ValidateUpUsAwr())
								{
	  								UpdateUsAwr($_SESSION[usuwanie_awarii][id_awr], $_SESSION[usuwanie_awarii][id_usaw]);
							include("zlecenia/wwwzlecenia.php");
								}
							else 
									include("func/updateusawarie.php");
							break;
// Voip Connections
					case "voipcon" :
							include("voip/wwwconnections.php");
							break;
/// Taryfy	
					case "taryfa" :
							$www->TablePrint($dbh, $taryfa, $_POST);
							break;
					case "taryfaadd" :
							$www->ObjectAdd($dbh, $taryfa);
							break;
					case "taryfaaddsnd" :
						if ( $taryfa->TaryfaValidate())
							{
	 							$taryfa->TaryfaAdd($dbh);
								$www->TablePrint($dbh, $taryfa, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $taryfa);
							break;
					case "taryfaupd" :
							include("taryfa/taryfaupd.php");
							break;
					case "taryfaupdsnd" :
						if ( $taryfa->TaryfaValidate())
							{
								$taryfa->TaryfaUpd($dbh, $_GET[taryfa]);
								$www->TablePrint($dbh, $taryfa, $_POST);
							break;
							}
						else
							include("taryfa/taryfaupd.php");
							break;
					case "deletetaryfa" :
							$taryfa->Delete($dbh);
							$www->TablePrint($dbh, $taryfa, $_POST);
							break;	
// VIRTUAL HOSTS
					case "vhwww" :
							include("php-admin/vhwww.php");
							break;
					case "dodajvhwww" :
							include("php-admin/dodajvhwww.php");
							break;
					case "dodajvhwwyslij" :
						if ( ValidateVHW())
							{
	  							AddNewVHWWW();
								include("php-admin/vhwww.php");
							}
						else
								include("php-admin/dodajvhwww.php");
							break;
					case "updatevhwww" :
							include("php-admin/updatevhwww.php");
							break;
					case "updatevhwwyslij" :
							if ( ValidateVHW("update"))
								{
									UpdateVHWWW($_GET[vhwww]);
									include("php-admin/vhwww.php");
								}
							else 
								include("php-admin/updatevhwww.php");
							break;

					case "vhftp" :
							include("php-admin/vhftp.php");
							break;
					case "dodajvhftp" :
							include("php-admin/dodajvhftp.php");
							break;
					case "dodajvhfwyslij" :
						if ( ValidateVHF())
							{
	  							AddNewVHFTP();
								include("php-admin/vhftp.php");
							}
							else
								include("php-admin/dodajvhftp.php");
							break;
					case "updatevhf" :
							include("php-admin/updatevhftp.php");
							break;
					case "updatevhfwyslij" :
							if ( ValidateVHF("update"))
								{
	  								UpdateVHFTP($_GET[vhftp]);
									include("php-admin/vhftp.php");
								}
							else 
									include("php-admin/updatevhwww.php");
							break;

					case "domeny" :
							include("php-admin/domeny.php");
							break;
					case "dodajdomene" :
							include("php-admin/dodajdomene.php");
							break;
					case "dodajdomenewyslij" :
						if ( ValidateDomena())
							{
	  							AddNewDomena();
								include("php-admin/domeny.php");
							}
							else
								include("php-admin/dodajdomene.php");
							break;
					case "updatedomene" :
							include("php-admin/updatedomene.php");
							break;
					case "updatedomenewyslij" :
							if ( ValidateDomena("update"))
								{
	  								UpdateDomena($_GET[domena]);
									include("php-admin/domeny.php");
								}
							else 
									include("php-admin/updatedomene.php");
							break;

// STATYSTYKI
				case "statystyki" :
							include("php-admin/statystyki.php");
							break;
	
					case "generate":
						Generate($_GET[typ]);
						echo "Nowe ustawienia wprowadzono do systemu";
						break;
						
// Operatorzy telekomunikacyjni
					case "operator" :
							$www->TablePrint($dbh, $operator, $_POST);
							break;
					case "operatoradd" :
							$www->ObjectAdd($dbh, $operator);
							break;
					case "operatoraddsnd" :
						if ( $operator->OperatorValidate($dbh) )
							{
	 							$operator->OperatorAdd($dbh);
								$www->TablePrint($dbh, $operator, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $operator);
							break;
					case "operatorupd" :
							include("operator/operatorupd.php");
							break;
					case "operatorupdsnd" :
						if ( $operator->OperatorValidate($dbh))
							{
								$operator->OperatorUpd($dbh, $_GET[opr]);
							$www->TablePrint($dbh, $operator, $_POST);
							}
						else
								$operator->OperatorUpd($dbh, $_GET[opr]);
							break;
					case "deleteoperator" :
							$operator->Delete($dbh);
							$www->TablePrint($dbh, $operator, $_POST);
							break;
							
// RAPORTY
				case "report" :
							include("report/wwwreport.php");
							break;
	
// Wkaźniki
					case "indicator" :
							include("indicator/wwwindicator.php");
							break;

// RAPORTY
				case "phpinfo" :
							include("info/phpinfo.php");
							break;

							
							
					case "generate":
						Generate($_GET[typ]);
						echo "Nowe ustawienia wprowadzono do systemu";
						break;
						
						
					case "delete":
 						Delete($_SESSION[del1], $_SESSION[del2],$_GET[typ], $_SESSION[del3]);
						break;
						
						
					case NULL :
				 			include("func/auth.php");
							break;
					case "zaloguj" :
				 			include("func/auth.php");
							break;
					case "authwyslij" :
				 			if ( ValidateAuth() )
								include("php-admin/informations.php");
							else
								include("func/auth.php");
							break;
					default :
				 			include("func/auth.php");
							break;

					}

	?>
