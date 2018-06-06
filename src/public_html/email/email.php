<?php

class EMAIL
{

	function WyslijMaila($from, $to, $subject, $body="")
	{
			include "func/config.php";
						
			include_once( 'Mail.php' );

			$subject=iconv('UTF-8', 'ISO-8859-2', $subject);
			$body=iconv('UTF-8', 'ISO-8859-2', $body);

			$params['host']=$conf[smtp];
			
			$headers['From']=$from;
			$headers['To']=$to;
			$headers['Subject']=$subject;
			$headers["Content-Type"] = "text/plain; format=flowed; charset=ISO-8859-2; reply-type=original"; 

			$message=& Mail::factory('smtp', $params);
			$message->send($to, $headers, $body);

			echo "Wysłano maila do adresata: $to <br>";
	}

	function SendMail($from, $name, $to, $subject, $body, $ftab)
	{
		include "func/config.php";
		require_once('PHPMailer/class.phpmailer.php');

		//
		$mail = new PHPMailer();
		$mail->CharSet = "UTF-8"; 
		$mail->IsSMTP();// send via SMTP
		$mail->Host = "$conf[smtp]"; // SMTP servers
		$mail->SMTPAuth = false; // turn on/off SMTP authentication
		$mail->From = $from;
		$mail->FromName = $name;
		$mail->AddAddress($to);
		$mail->AddReplyTo($from);
		$mail->WordWrap = 50;// set word wrap

	/*	//now Attach all files submitted
		foreach($attachments as $key => $value) 
			{ //loop the Attachments to be added ...
				$mail->AddAttachment("uploads"."/".$value);
			}*/

		foreach ( $ftab as $file)
			$mail->AddAttachment($file);	
		
		$mail->Body = "$body";
		//
		$mail->IsHTML(true);// send as HTML
		$mail->Subject = $subject;

		if(!$mail->Send())
		{
			echo "Message was not sent <p>";
			echo "Mailer Error: " . $mail->ErrorInfo;
			exit;
			return 0;
		}
		else
		{
			//echo "<br> Message has been sent <br>";
			return 1;
		}
			
	/*	// after mail is sent with attachments , delete the images on server ...
		foreach($attachments as $key => $value) {//remove the uploaded files ..
		unlink("uploads"."/".$value);*/
	}

	
	function SendFV2($dbh, $od, $do)
	{
		require('fpdf.php');
		include "body.php";
		include "pdf/pdf.php";
		include "func/config.php";
		include "slownie/slownie.php";
		
		// email address of the recipient
		$to = "admin@netico.pl";

		// email address of the sender
		$from = "netico@netico.pl";

		// subject of the email 
		$subject = "Faktura VAT za usługi interetowe i telefoniczne."; 
		$name="NETICO S.C.";
		// email header format complies the PEAR's Mail class
		// this header includes sender's email and subject

		// We will send this email as HTML format
		// which is well presented and nicer than plain text
		// using the heredoc syntax
		// REMEMBER: there should not be any space after PDFMAIL keyword

		$bodyheader="<a href=\"http://www.netico.pl\"> <img src=\"$conf[pdf_logo1]\" />  </a>";

		$body=body1();
//$body=$bodyheader.$body;


	
		$q="select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, a.nazwa,
				a.pesel_nip, u.nazwa, b.numer, a.nr_mieszk, d.wystawil, u.miasto, u.kod, a.id_abon, k.nazwa, 
				k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, m.email, a.saldo
					
				from ((dokumenty_sprzedaz d  full join umowy_abonenckie um on d.id_odb=um.id_abon) 
				full join kontakty k  on k.id_podm=um.id_abon) 
				join ((budynki b join ulice u on b.id_ul=u.id_ul) join 
				((abonenci a full join maile m on a.id_abon=m.id_podm) full join konta_wirtualne kw on a.id_abon=kw.id_abon) 
				on a.id_bud=b.id_bud) 	on d.id_odb=a.id_abon  
						
				where d.data_wyst >= '$od' and d.data_wyst <= '$do' and a.fv_email='T'";
		
		set_time_limit(600);                                                                        
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
				$dokks=array
				(
					'nr_d'			=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'		=> $row[4],	'miejsce_wyst'		=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'			=> $row[8],	'nr_bud'		=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'		=> $row[12],	'kod'			=> $row[13], 'id_abon' => $row[14],
					'k_nazwa' 	=> $row[15],	'k_ulica' 			=> $row[16],'k_nr_bud'	 	=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'	=> $row[21], 'email' => $row[22], 'saldo'			 => $row[23]
				);

				$ftab=array();	
				$q1="select id_tlv from telefony_voip where id_abon='$dokks[id_abon]'  and fv='T' and aktywny='T' limit 1";
				$id_tlv=Query2($q1, $dbh);

				$ftab=array();				
				$pdf=new PDF();
				$pdf->SetUTF8(true); 
				$pdf->SetCompression(true);
				$pdf->AliasNbPages();
				$pdf->AddFont('Tahoma','','tahoma.php');
				$pdf->AddFont('Tahoma','B','tahomabd.php');
				$pdf->SetAutoPageBreak( 1, 10);
				$pdf=$pdf->MakeFV($pdf, $dbh, $dokks, "ORYGINAŁ", 1, "func/config.php");
				if ( !empty($id_tlv) )
				{
					$pdf->VoipBiling($pdf, $dbh, $od, $do, $dokks[id_abon], "func/config.php");
				}
				$file="/home/szmsk/tmp/FV-$dokks[nazwa]-$dokks[data_wyst].pdf";
				$pdf->Output($file, "F");
				
				array_push($ftab, $file);
				$flag=$this->SendMail($dokks[email], $name, $to, $subject, $body, $ftab);
				if ( $flag==0 )
						echo "<br> Nie wysłano e-maila do $dokks[email]!<br>";
				else
							echo "<br> Wysłano e-maila do $dokks[email].<br>";
			}
		if ( $flag==0 )
			echo "<br> Problem z wysłaniem faktur.<br>";
		else
			echo "<br> Wysłano e-maile z fakturami VAT.<br>";			
	}
	
	//Wysyła pojedynczego maila z FV
	function InvoiceSendMk($dbh, $dokks, $mail)
	{
		
		include "func/config.php";
	
	// email address of the recipient
		$to = "admin@netico.pl";

		// email address of the sender
		$from = "finanse@netico.pl";

		// subject of the email 
		$subject = "Faktura VAT za usługi multimedialne."; 
		$name="NETICO S.C. - Finanse";
		// email header format complies the PEAR's Mail class
		// this header includes sender's email and subject

		// We will send this email as HTML format
		// which is well presented and nicer than plain text
		// using the heredoc syntax
		// REMEMBER: there should not be any space after PDFMAIL keyword

		$bodyheader="<a href=\"http://www.netico.pl\"> <img src=\"$conf[pdf_logo1]\" />  </a>";

		
		set_time_limit(1000);                                                                        
	
			$q1="select id_tlv from telefony_voip where id_abon='$dokks[id_abon]' and fv='T' and aktywny='T' limit 1";
			$id_tlv=Query2($q1, $dbh);
			$q2="select s.id_spw from sprawy_windykacyjne s, windykowanie w where s.id_abon='$dokks[id_abon]' and s.zwindykowana='N' and s.id_spw=w.id_spw 
and w.krok in ('info2', 'blokada', 'pismo', 'krd') limit 1";
			$id_spw=Query2($q2, $dbh);
			
			$ftab=array();				
			$pdf=new PDF();
			$pdf->SetUTF8(true); 
			$pdf->SetCompression(true);
			$pdf->AliasNbPages();
			$pdf->AddFont('Tahoma','','tahoma.php');
			$pdf->AddFont('Tahoma','B','tahomabd.php');
			$pdf->SetAutoPageBreak( 1, 10);
			$pdf->MakeFV($pdf, $dbh, $dokks, "ORYGINAŁ", 1, "func/config.php");
			$file="/home/szmsk/tmp/FakturaVAT-$dokks[nazwa]-$dokks[data_wyst].pdf";
			$pdf->Output($file, "F");
			array_push($ftab, $file);
			if ( !empty($id_tlv) )
			{
				$pdf=new PDF();
				$pdf->SetUTF8(true); 
				$pdf->SetCompression(true);
				$pdf->AliasNbPages();
				$pdf->AddFont('Tahoma','','tahoma.php');
				$pdf->AddFont('Tahoma','B','tahomabd.php');
				$pdf->SetAutoPageBreak( 1, 10);
			  $od="$mail[od]";
			  $do="$mail[do]";
			
				$pdf->VoipBiling($pdf, $dbh, $od, $do, $dokks[id_abon], $mail[voip], "func/config.php");
						
				$file2="/home/szmsk/tmp/Biling-$dokks[nazwa]-$dokks[data_wyst].pdf";
				$pdf->Output($file2, "F");
				array_push($ftab, $file2);
			}
			if ( !empty($id_spw) )
			{
				$pdf=new PDF();
				$pdf->SetUTF8(true); 
				$pdf->SetCompression(true);
				$pdf->AliasNbPages();
				$pdf->AddFont('Tahoma','','tahoma.php');
				$pdf->AddFont('Tahoma','B','tahomabd.php');
				$pdf->SetAutoPageBreak( 1, 10);
			
				$pdf->PonaglenieZaplaty($pdf, $dbh, $id_spw[0], "func/config.php");
						
				$file3="/home/szmsk/tmp/PonaglenieZaplaty-$dokks[nazwa]-$conf[data].pdf";
				$pdf->Output($file3, "F");
				array_push($ftab, $file3);
			}
		
		if ( !empty($dokks[email])  && isEmail($dokks[email]) )
		{
		  echo "<br> Wysyłanie e-maila do <b> $dokks[nazwa] - $dokks[email]</b>";
			$flag=$this->SendMail($from, $name, $dokks[email], $subject, $body, $ftab);
		 //$to="mirth@wp.pl";
			//$flag=$this->SendMail($from, $name, $to, $subject, $mail[body], $ftab);
		}
		else 
		{
			$flag=0;
			echo "<br> Klient <b> $dokks[nazwa] nie ma wpisanego adresu e-mail</b>!<br>";
		}	
		
		if ( $flag==0 )
					echo " - Nie wysłano !<br>";
			else
					echo " - Wysłano z powodzeniem.<br>";
			return $flag;
	}

	
		// Ta funkcja wysyła 1 maila z fakturą w taki sposob ze biling jest osobnym zalacznikiem	
	function InvoiceSend($dbh, $nr_ds)
	{
		require('fpdf.php');
		include "body.php";
		include "pdf/pdf.php";
		include "slownie/slownie.php";
		include "voip/voip.php";
		$voip=new VOIP();
		$body=body1();
				
		include "func/config.php";
		
			$q=" select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, m.email, a.saldo
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= d.data_wyst and k.wazne_do >= d.data_wyst ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join ((adresy_siedzib s left join maile m on s.id_abon=m.id_podm)join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.nr_ds='$nr_ds'";
				
			
				
		set_time_limit(600);                                                                        
		$sth=Query($dbh,$q);
		$row=$sth->fetchRow(); 
		
				$dokks=array
				(
					'nr_d'			=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'=> $row[4],	'miejsce_wyst'		=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'			=> $row[8],	'nr_bud'		=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'		=> $row[12],	'kod'			=> $row[13], 'id_abon' => $row[14],
					'k_nazwa' 	=> $row[15],	'k_ulica' 			=> $row[16],'k_nr_bud'	 	=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'	=> $row[21], 'email' => $row[22], 'saldo'			 => $row[23]
				);

						
				$d1=explode("-", $dokks[data_wyst]);
				$pm=PrevMonth("$d1[0]-$d1[1]");
				$d2=explode("-", $pm);
				$pod="$pm-01";
				$il_dni= date(t,mktime(0,0,0,$d2[1],1,$d2[0]));
				$pdo="$pm-$il_dni";

								
				$mail=array
				(
				'od' => $pod,  'do' => $pdo, 'body' => $body, 'voip' => $voip
				);
				
				$flag=$this->InvoiceSendMk($dbh, $dokks, $mail);
	}
	
	// Ta funkcja wysyła maile z fakturami w taki sposob ze biling jest osobnym zalacznikiem	
	function InvoicesSend($dbh, $od, $do)
	{
		require('fpdf.php');
		include "body.php";
		include "pdf/pdf.php";
		include "slownie/slownie.php";
		include "voip/voip.php";
		$voip=new VOIP();
		$body=body1();
				
		include "func/config.php";
		
			$q=" select  distinct d.nr_ds, d.data_wyst, d.data_sprzed, d.term_plat, d.forma_plat, d.miejsce_wyst, n.nazwa, a.pesel_nip, u.nazwa, b.numer, s.nr_lok, d.wystawil, u.miasto, u.kod, a.id_abon,
k.nazwa, k.ulica, k.nr_bud, k.nr_mieszk, k.kod, k.miasto, kw.numer, m.email, a.saldo
from
((abonenci a join nazwy n on a.id_abon=n.id_abon) join (kontakty k right join dokumenty_sprzedaz d on d.id_odb=k.id_podm and k.wazne_od <= d.data_wyst and k.wazne_do >= d.data_wyst ) on d.id_odb=a.id_abon)
join
((budynki b join ulice u on b.id_ul=u.id_ul) join ((adresy_siedzib s join maile m on s.id_abon=m.id_podm)join konta_wirtualne kw on s.id_abon=kw.id_abon) on s.id_bud=b.id_bud)
on d.id_odb=kw.id_abon
where s.wazne_od <= d.data_wyst and s.wazne_do >= d.data_wyst and n.wazne_od <= d.data_wyst and n.wazne_do >= d.data_wyst
and d.data_wyst >= '$od' and d.data_wyst <= '$do'
and a.fv_email='T' order by d.nr_ds";
				
				
				$d1=explode("-", $od);
				$pm=PrevMonth("$d1[0]-$d1[1]");
				$d2=explode("-", $pm);
				$pod="$pm-01";
				$il_dni= date(t,mktime(0,0,0,$d2[1],1,$d2[0]));
				$pdo="$pm-$il_dni";
				
				$mail=array
				(
				'od' => $pod,  'do' => $pdo, 'body' => $body, 'voip' => $voip
				);
				
		set_time_limit(600);                                                                        
		$sth=Query($dbh,$q);
		while ($row=$sth->fetchRow() )
			{
				$dokks=array
				(
					'nr_d'			=> $row[0], 	'data_wyst'		=> $row[1],	'data_sprzed'	=> $row[2], 'term_plat'		=>	$row[3],	
					'forma_plat'=> $row[4],	'miejsce_wyst'		=> $row[5],	'nazwa'			=> $row[6],	'pesel_nip'		=> $row[7],
					'ulica'			=> $row[8],	'nr_bud'		=> $row[9],	'nr_mieszk'		=> $row[10],'wystawil'		=> $row[11],
					'miasto'		=> $row[12],	'kod'			=> $row[13], 'id_abon' => $row[14],
					'k_nazwa' 	=> $row[15],	'k_ulica' 			=> $row[16],'k_nr_bud'	 	=> $row[17], 'k_nr_mieszk' => $row[18],
					'k_kod'			=> $row[19],	'k_miasto'			=> $row[20], 'konto'	=> $row[21], 'email' => $row[22], 'saldo'			 => $row[23]
				);

		
				$flag=$this->InvoiceSendMk($dbh, $dokks, $mail);
			}

		if ( $flag==0 )
			echo "<br> Problem z wysłaniem faktur.<br>";
		else
			echo "<br> Wysłano e-maile z fakturami VAT.<br>";			
	}


}

?>