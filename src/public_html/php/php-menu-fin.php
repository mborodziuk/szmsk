<?php

	include "func/config.php";
	$dbh=DBConnect($DBNAME1);
	$dbh2=$szmsk->DbC($DBTYPE2, $HOST2, $DBNAME2, $USER2, $PASS2);
					
	include "customers/customers.php";
	$customers=new CUSTOMERS();					
					
	include("cesje/cesje.php");							
	$cesje=new CESJE();  
	
	include ("zlecenia/zlecenia.php");
	$zlecenia=new ZLECENIA();

	include("debitnotes/debitnotes.php");							
	$debitnote=new DEBITNOTE();  

	include("windykacja/windykacja.php");							
	$windykacja=new WINDYKACJA();  

	include("jazdy/jazdy.php");
	$jazdy=new JAZDY();
	
	include("pracownicy/pracownicy.php");
	$pracownicy=new PRACOWNICY();
	
	include ("instytucje/instytucje.php");
	$instytucje=new INSTYTUCJE();

	include ("email/email.php");
	$email=new EMAIL();

	include ("contracts/contracts.php");
	$contracts=new CONTRACTS();

	include ("buildings/buildings.php");
	$buildings=new BUILDINGS();
	
	include ("invoices/invoices.php");
	$invoices=new INVOICES();

	include ("payments/payments.php");
	$payment=new PAYMENTS();
	
	include("payouts/payouts.php");							
	$payout=new PAYOUTS();  
	
	include ("ingoingletters/ingoingletters.php");
	$ingoingletter=new INGOINGLETTERS();

	include ("service/service.php");
	$service=new SERVICE();

	include ("commitment/commitment.php");
	$cmt=new COMMITMENT();


include ("plugging/plugging.php");
$plg=new PLUGGING();
	
	switch ( $_GET["menu"] )
				{
					case "informacje" :
							include("php-fin/informations.php");
							break;
					case NULL :
				 			include("php-fin/informations.php");
							break;
					case "sndivcs":
 							$email->InvoicesSend($dbh, $_GET[data_od], $_GET[data_do] );
							break;
					case "sendFV":
 							$email->InvoiceSend($dbh, $_GET[nr] );
							break;
// ABONENCI
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
					case "zastosuj_abon" :
 						$customers->ZastosujAbon($dbh, $windykacja, $plg);
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
							
							
// Termination Of Contract (Wypowiedzenia umow))
	    			case "wypowiedzenia":
 							include("contracts/wwwterminations.php");
							break;
   				case "terminationadd":
	        				include("contracts/terminationadd.php");
							break;							
   				case "terminationupd":
	        				include("contracts/terminationupd.php");
							break;
					case "sendterminationadd" :
						if ( $contracts->ValidateTerminationAdd($dbh))
							{
	 							$contracts->TerminationAdd($dbh);
 								include("contracts/wwwterminations.php");
							}
						else
							include("contracts/terminationadd.php");
							break;
					case "sendterminationupd" :
						if ( $contracts->ValidateTerminationAdd($dbh, $_GET["trm"]))
							{
	 							$contracts->TerminationUpd($dbh, $_GET["trm"]);
 								include("contracts/wwwterminations.php");
							}
						else
							include("contracts/terminationupd.php");
							break;				
// Pisma przychodzące
	    			case "ingoingletters":
 							include("ingoingletters/wwwingoingletters.php");
							break;
   				case "inltradd":
	        				include("ingoingletters/inltradd.php");
							break;							
   				case "inltrupd":
	        				include("ingoingletters/inltrupd.php");
							break;
					case "inltraddsnd" :
						if ( $ingoingletter->ValidateInLtrAdd($dbh))
							{
	 							$ingoingletter->InLtrAdd($dbh);
 								include("ingoingletters/wwwingoingletters.php");
							}
						else
							include("ingoingletters/inltradd.php");
							break;
					case "inltrupdsnd" :
						if ( $ingoingletter->ValidateInLtrUpd($dbh, $_GET["inltr"]))
							{
	 							$ingoingletter->InLtrUpd($dbh, $_GET["inltr"]);
 								include("ingoingletters/wwwingoingletters.php");
							}
						else
							include("ingoingletters/inltrupd.php");
							break;
							
// WINDYKACJA
    			case "windykacja":
 							include("windykacja/wwwwindykacja.php");
							break;
   				case "zastosuj_windyk":
						$windykacja->ZastosujWindykacja($_SESSION[krok], $zlecenia, $szmsk);
						//include("windykacja/wwwwindykacja.php");
							break;
   				case "automate":
						$windykacja->Automate($dbh);
							break;
  				case "addnewwindyk":
						$windykacja->DodajDoWindykacji($dbh);
							break;
   				case "pozew":
						$windykacja->CreatePlaint($dbh, $_GET[id_spw]);
					//	include("windykacja/wwwwindykacja.php");
							break;
    			case "spwupd":
 							include("windykacja/spwupd.php");
							break;
    			case "sndspwupd":
						if ( $windykacja->SpwValidate($dbh, $_GET[spw]))
							{
								$windykacja->SpwUpd($dbh, $_GET[spw]);
								include("windykacja/wwwwindykacja.php");
							}
						else
								include("windykacja/spwupd.php");
							break;		
// CESJE
	    			case "cesje":
 							include("cesje/wwwcesje.php");
							break;
					case "dodajcesje" :
							include("cesje/dodajcesje.php");
							break;
					case "dodajcesjewyslij" :
					//	if ( ValidateAwarie())
					//	{
	  							$cesje->AddNewCesje();
								include("cesje/wwwcesje.php");
							break;
// BUDYNKI
    			case "buildings":
 							include("buildings/wwwbuildings.php");
							break;
   				case "buildadd":
	        		include("buildings/buildadd.php");
							break;
					case "buildaddsnd" :
						if ( $buildings->BuildValidate($dbh))
							{
								$buildings->BuildAdd($dbh);
								include("buildings/wwwbuildings.php");
							}
						else
							include("buildings/buildadd.php");					
							break;
					case "buildupd" :
							include("buildings/buildupd.php");
							break;
					case "buildupdsnd" :
						if ( $buildings->BuildValidate())
							{
								$buildings->BuildUpd($dbh,$_GET[bud]);
								include("buildings/wwwbuildings.php");
																
							}
					  else
						  include("buildings/buildupd.php");												
							break;
// WPŁATY
					case "payments":
						include("payments/wwwpayments.php");
						break;
					case "paymentadd":
						include("payments/paymentadd.php");
						break;
					case "paymentaddsnd" :
						if ( $payment->AddValidate())
							{
								$payment->Add($dbh);
								include("payments/wwwpayments.php");
							}
						else
							include("payments/paymentadd.php");
							break;
					case "paymentupd" :
							include("payments/paymentupd.php");
							break;
					case "paymentupdsnd" :
						if ( $payment->UpdValidate($_GET[wpl]))
							{
								$payment->Upd($dbh, $_GET[wpl]);
								include("payments/wwwpayments.php");
							}
						else
							include("payments/paymentadd.php");
							break;
					case "paymentimp":
						include("payments/paymentimp.php");
						break;
					case "paymentimpsnd" :
							$payment->PaymentsLoad($dbh, $szmsk);
							include("payments/wwwpayments.php");
							break;
          case "rozlicz":
                Rozlicz();
                // include("php-fin/wplaty.php");
                break;
					case "paymentsupdall" :
							$payment->PaymentUpdAll($dbh, $_SESSION[upd1]);
							break;

// WYPŁATY
					case "payouts":
						include("payouts/wwwpayouts.php");
						break;
					case "payoutadd":
						include("payouts/payoutadd.php");
						break;
					case "payoutaddsnd" :
						if ( $payout->AddValidate())
							{
								$payout->Add($dbh);
								include("payouts/wwwpayouts.php");
							}
						else
							include("payouts/payoutadd.php");
							break;
					case "payoutupd" :
							include("payouts/payoutupd.php");
							break;
					case "payoutupdsnd" :
						if ( $payout->UpdValidate($_GET[wyp]))
							{
								$payout->Upd($dbh, $_GET[wyp]);
								include("payouts/wwwpayouts.php");
							}
						else
							include("payouts/payoutadd.php");
							break;
					case "payoutimp":
						include("payouts/payoutimp.php");
						break;
					case "payoutimpsnd" :
							$payout->payoutsLoad($dbh, $szmsk);
							include("payouts/wwwpayouts.php");
							break;
					case "payoutsupdall" :
							$payout->payoutUpdAll($dbh, $_SESSION[upd1]);
							break;

// DOSTAWCY
				case "dostawcy":
 							include("php-fin/dostawcy.php");
							break;
   				case "dodajdost":
	        				include("php-fin/dodajdost.php");
							break;
					case "newdostwyslij" :
						if ( ValidateDost())
							{
	 							AddNewDost();
							}
							break;
					case "updatedost" :
							include("php-fin/updatedost.php");
							break;
					case "updatedostwyslij" :
						if ( ValidateDost($_GET[dost]))
							{
								UpdateDost($_GET[dost]);
							}
							break;

// TOWARY
    			case "tow":
 							include("service/wwwservice.php");
							break;
   				case "dodajtow":
	        				include("service/srvadd.php");
							break;
					case "newtowwyslij" :
						if ( $service->ValidateTow())
							{
	 							$service->AddNewTow($dbh, $_GET[typ]);
							}
							break;
					case "updatetow" :
							include("service/srvupd.php");
							break;
					case "updatetowwyslij" :
						if ( $service->ValidateTow() )
							{
								$service->UpdateTow($dbh, $_GET[typ], $_GET[id]);
							}
							break;

// PISMA
					case "pisma":
 							include("php-fin/pisma.php");
							break;
   				case "dodajpismo":
	        				include("php-fin/dodajpismo.php");
							break;
					case "newpismowyslij" :
						if ( ValidatePismo())
							{
	 							AddNewPismo($_GET[typ]);
							}
							break;
					case "updatepismo" :
							include("php-fin/updatepismo.php");
							break;
					case "updatepismowyslij" :
						if ( ValidatePismo() )
							{
								UpdatePismo($_GET[typ], $_GET[pismo]);
							}
							break;
// PRACOWNICY
					case "pracownicy":
 							include("pracownicy/wwwpracownicy.php");
							break;
   				case "dodajprac":
	        				include("pracownicy/dodajprac.php");
							break;
					case "newpracwyslij" :
						if ( $pracownicy->ValidatePrac())
							{
	 							$pracownicy->AddNewPrac();
	 							include("pracownicy/wwwpracownicy.php");
							}
						else
	     				include("pracownicy/dodajprac.php");
							break;
					case "updateprac" :
							include("pracownicy/updateprac.php");
							break;
					case "updatepracwyslij" :
						if ( $pracownicy->ValidatePrac() )
							{
								$pracownicy->UpdatePrac($_GET[prac]);
	 							include("pracownicy/wwwpracownicy.php");
							}
						else
							include("pracownicy/updateprac.php");
							break;
// PRACE
					case "prace":
 							include("php-fin/prace.php");
							break;
   				case "dodajprace":
	        				include("php-fin/dodajprace.php");
							break;
					case "newpracewyslij" :
						if ( ValidatePrace())
							{
	 							AddNewPrace();
	 							include("php-fin/prace.php");
							}
						else
	   					include("php-fin/dodajprace.php");
							break;
					case "updateprace" :
							include("php-fin/updateprace.php");
							break;
					case "updatepracewyslij" :
						if ( ValidatePrace() )
							{
								UpdatePrace($_GET[praca]);
	 							include("php-fin/prace.php");
							}
						else
							include("php-fin/updateprace.php");
							break;
// Jazdy
					case "przebpoj":	
							include ("jazdy/przebpoj.php");
							break;
					case "addnewjzd":
							$jazdy->CreateJourneys($_GET[data_od], $_GET[data_do], $_GET[pojazd]);
							break;
					case "updatejzd" :
							$jazdy->UpdateJzd($_SESSION[upd1]);
							break;
// Instytucje
					case "instytucje":	
							include ("instytucje/wwwinstytucje.php");
							break;
					case "dodajinst":
							include ("instytucje/dodajinst.php");
							break;
					case "updateinst" :
							include ("instytucje/updateinst.php");
							break;
					case "newinstwyslij":
							if ($instytucje->ValidateInst())
								$instytucje->AddNewInst();
							include ("instytucje/wwwinstytucje.php");								
							break;
					case "updateinstwyslij":
							if ($instytucje->ValidateInst())
								$instytucje->UpdateInst($_GET[inst]);
							include ("instytucje/wwwinstytucje.php");								
							break;
							
							
// UMOWY PRACY
					case "umowypracy":
 							include("php-fin/umowypracy.php");
							break;
   					case "dodajump":
	        				include("php-fin/dodajump.php");
							break;
					
					case "newumpwyslij" :
						if ( ValidateUmp())
							{
	 							AddNewUmp();
	 							include("php-fin/umowypracy.php");
							}
						else
	        				include("php-fin/dodajump.php");
							break;
					case "updateump" :
							include("php-fin/updateump.php");
							break;
					case "updateumpwyslij" :
						if ( ValidateUmp() )
							{
								UpdateUmp($_GET[ump]);
	 							include("php-fin/umowypracy.php");
							}
						else
							include("php-fin/updateump.php");
							break;
// GWARANCJE
					case "gwar":
 							include("php-fin/gwarancje.php");
							break;
   				case "dodajgwar":
	        				include("php-fin/dodajgwar.php");
							break;
   				case "dodajgwar1":
						if ( ValidateGwar())
							{
	 							AddNewGwar($_GET[typ]);
				  				include("php-fin/dodajgwar1.php");
							}
						else
			  				include("php-fin/dodajgwar.php");
	      				break;
   				case "dodajgwar2":
	        				include("php-fin/dodajgwar2.php");
							break;
					case "newgwarwyslij" :
						if ( ValidatePozGwar())
							{
	 							AddPozGwar($_GET[typ]);
	 							include("php-fin/gwarancje.php");
							}
							break;
					case "updategwar" :
							include("php-fin/updategwar.php");
							break;
					case "updategwarwyslij" :
						if ( ValidateGwar() )
							{
								UpdateGwar($_GET[typ], $_GET[nr]);
							}
							break;
					
// DOKUMENTY KSIEGOWE
					case "invoices":
 							include("invoices/wwwinvoices.php");
							break;
   					case "invoiceadd1":
       				include("invoices/invoiceadd1.php");
							break;
   					case "invoiceadd2":
						if ( $invoices->InvoiceValidate1())
							{
	        				include("invoices/invoiceadd2.php");
							}
						else
			  				include("invoices/invoiceadd1.php");
	      					break;
					case "invoiceaddsnd" :
						if ( $invoices->InvoiceValidate2())
							{
	 							$invoices->InvoiceAdd($dbh, $_GET[typ]);
	 							include("invoices/wwwinvoices.php");
							}
							break;
					case "invoiceupd1" :
							include("invoices/invoiceupd1.php");
							break;
					case "invoiceupdsnd1" :
						if ( $invoices->InvoiceValidate1() )
							{
								$invoices->InvoiceUpd($dbh, $_GET[typ],$_GET[nr]);
								$_GET[typ]="sprzedaz";
								$_GET[nr]=$_SESSION[dokks][nr_ds];
	 							include("invoices/invoiceupd1.php");
							}
							break;
					case "invoiceupd2" :
							include("invoices/invoiceupd2.php");
							break;
					case "invoiceupdsnd2" :
						if ( $invoices->InvoiceValidate2())
							{
	 							$invoices->InvoiceUpd2($dbh, "sprzedaz");
								$_GET[typ]="sprzedaz";
								$_GET[nr]=$_SESSION[dokks][nr_ds];
	 							include("invoices/invoiceupd1.php");
							}
							break;
					case "invoiceupd3" :
							include("invoices/invoiceupd3.php");
							break;
					case "invoiceupdsnd3" :
						if ( $invoices->InvoiceValidate2())
							{
	 							$invoices->InvoiceUpd3($dbh);
								$_GET[typ]="sprzedaz";
								$_GET[nr]=$_SESSION[dokks][nr_ds];
	 							include("invoices/invoiceupd1.php");
							}
							break;
					case "ainvoiceadd1":
 							include("invoices/ainvoiceadd1.php");
							break;
   				case "ainvoiceadd2":
//						if ( ValidateFabon())
							{
				  				include("invoices/ainvoiceadd2.php");
							}
						//else
//			  				include("php-fin/dodajfabon.php");
	      					break;
					case "ainvoicesnd" :
//						if ( ValidatePozDokks())
							{
								include ("periodic/periodic.php");
								$periodic=new PERIODIC($dbh);
	 							$invoices->AInvoiceAdd($dbh);
//	 							include("php-fin/dokks.php");
							}
							break;
								
					case "ksiazeczka"  :
							include("php-fin/dodajka.php");
							break;
          case "przetworz"  :
               przetworz();
               break;
																								
					case "updatedokkswyslij" :
						if ( ValidateDokks() )
							{
								UpdateDokks($_GET[typ],$_GET[nr]);
							}
							break;
					case "deletefv":
 						$invoices->DeleteFv($dbh);
						break;

// NOTY OBCIAZENIOWE
					case "debitnotes":
					
 							include("debitnotes/wwwdebitnotes.php");
							break;
   					case "debitnoteadd":
	        				include("debitnotes/debitnoteadd.php");
							break;
   					case "debitnotesend":
						if ( $debitnote->ValidateDebitNote())
							{
								$debitnote->DebitNoteAdd($dbh);
				  				include("debitnotes/wwwdebitnotes.php");
							}
						else
			  				include("debitnotes/dodajfv.php");
	      					break;
   					case "debitnoteupd":
	        				include("debitnotes/debitnoteupd.php");
							break;
   					case "dbtntupdsnd":
						if ( $debitnote->ValidateDebitNote())
							{
								$debitnote->DebitNoteUpd($dbh, $_GET[no]);
				  				include("debitnotes/wwwdebitnotes.php");
							}
						else
			  				include("debitnotes/debitnodeupd.php");
							break;
					case "deleteno":
 						$debitnote->DeleteNo($dbh);
						break;

/// commitment		
					case "cmt" :
							$www->TablePrint($dbh, $cmt, $_POST);
							break;
					case "cmtadd" :
							$www->ObjectAdd($dbh, $cmt);
							break;
					case "cmtaddsnd" :
						if ( $cmt->cmtValidate($dbh, $ipc))
							{
	 							$cmt->cmtAdd($dbh, $ipc);
								$www->TablePrint($dbh, $cmt, $_POST);
							}
						else
							$www->ObjectAdd($dbh, $cmt);
							break;
					case "cmtupd" :
							include("commitment/cmtupd.php");
							break;
					case "cmtupdsnd" :
						if ( $cmt->cmtValidate($dbh, $ipc))
							{
								$cmt->cmtUpd($dbh, $_GET[cmt]);
								$www->TablePrint($dbh, $cmt, $_POST);
							}
						else
								$cmt->cmtUpd($dbh, $_GET[cmt]);
							break;
					case "trfcmtadd" :
							include("commitment/taryfaadd.php");
							break;
					case "trfcmtsnd" :
					//	if ( $computers->ValidateKomp($dbh,  $ipc))
							{
								$cmt->TaryfaAdd($dbh, $_GET["cmt"], $_POST[aktywny_od]);
								include("commitment/cmtupd.php");
							}
						//else
							//include("computers/updatekomp.php");
							break;
					case "deletecmt" :
							$cmt->Delete($dbh);
							$www->TablePrint($dbh, $cmt, $_POST);
							break;		

	
							
							

					case "delete":
 						Delete($_SESSION[del1], $_SESSION[del2]);
						break;
						
					case NULL :
				 			include("php-fin/auth.php");
							break;
					case "zaloguj" :
				 			include("php-fin/auth.php");
							break;
					case "authwyslij" :
				 			if ( ValidateAuth() )
								include("php-fin/informations.php");
							else
								include("php-fin/auth.php");
							break;
					default :
				 			include("php-fin/auth.php");
							break;
			}
		

	    
	?>

