<?php
	$dbh=DBConnect($DBNAME1);

   $Q1="select nr_uma, data_zaw, typ_um, status from UMOWY_ABONENCKIE where id_abon='$_SESSION[id_abon]'";
	$Q2="select * from kontakty where id_podm='$_SESSION[id_abon]'";
	$Q3="select id_podm, telefon, tel_kom from telefony where id_podm='$_SESSION[id_abon]'";
	$Q4="select u.kod, u.miasto, u.nazwa, b.numer, mi.nr_mieszk 
			from ulice u, budynki b, miejsca_instalacji mi 
			where u.id_ul=b.id_ul and mi.id_bud=b.id_bud and mi.id_abon='$_SESSION[id_abon]'";
	$Q5="select w.id_wlasc, w.nazwa, w.id_bud, w.nr_mieszk, w.zgoda from wlasciciele w, abonenci a 
			where w.id_bud=a.id_bud and a.nr_mieszk=w.nr_mieszk and a.id_abon='$_SESSION[id_abon]'";
	$Q6="select k.id_kontakt, t.telefon, t.tel_kom from telefony t, kontakty k where t.id_podm=k.id_kontakt and k.id_podm='$_SESSION[id_abon]'";
	$Q7="select id_podm, email from maile where id_podm='$_SESSION[id_abon]'";
	$Q8="select m.id_podm, m.email from maile m, kontakty k where m.id_podm=k.id_kontakt and k.id_podm='$_SESSION[id_abon]'";
   $Q10="select a.symbol, a.nazwa, u.kod, u.miasto, u.nazwa, b.numer, a.nr_mieszk, a.pesel_nip, a.nrdow_regon, a.status, a.id_bud, a.saldo
			from abonenci a, ulice u, budynki b
			where b.id_bud=a.id_bud and u.id_ul=b.id_ul and a.id_abon='$_SESSION[id_abon]'";

	$row1=Query2($Q1, $dbh);
	$row2=Query2($Q2, $dbh);
	$row3=Query2($Q3, $dbh);
	$row4=Query2($Q4, $dbh);
	$row5=Query2($Q5, $dbh);
	if ( empty($row5) )
		{
			$Q5=" select w.id_wlasc, w.nazwa, w.id_bud, w.nr_mieszk, w.zgoda  from wlasciciele w, miejsca_instalacji mi 
					where mi.id_bud=w.id_bud and mi.nr_mieszk=w.nr_mieszk and mi.id_abon='$_SESSION[id_abon]'";
			$row5=Query2($Q5, $dbh);
		}
	$row6=Query2($Q6, $dbh);
	$row7=Query2($Q7, $dbh);
	$row8=Query2($Q8, $dbh);
	$row10=Query2($Q10, $dbh);

	$nr_uma=$row1[0];
	$data_zaw=$row1[1];

	$_SESSION['umowy']=$umowy=array
	('nr_uma'	=>$row1[0],		'data_zaw'	=>$row1[1], 	'typ_um'			=>$row1[2], 	'status'	=>$row1[3]);

	$_SESSION['abonenci']=$abonenci=array
	(	'id_abon' 	=> $_SESSION[id_abon],	'symbol'	=>$row10[0], 		'nazwa'	=>$row10[1], 	
		'kod'			=>$row10[2],				'miasto'	=>$row10[3],		'ulica'	=>$row10[4],	'nr_bud'	=>$row10[5],'nr_mieszk'=>$row10[6],
		'pesel_nip'	=>$row10[7],				'nrdow_regon'	=>$row10[8],'status'	=>$row10[9],	'id_bud'	=>$row10[10], 'saldo' => $row10[11]);

	$_SESSION['telefony_a']=$telefony_a=array
	('id_podm'		=>$row3[0], 'telefon'		=>$row3[1], 	'tel_kom'		=>$row3[2]);
	$_SESSION['maile_a']=$maile_a=array
	('id_podm' =>$row7[0], 'email'=>$row7[1]);
	$_SESSION['miejsa_instalacji']=$miejsca_instalacji=array
	('id_abon' => $_SESSION[id_abon], 'kod'=>$row4[0], 	'miasto'=>$row4[1], 	'ulica'	=>$row4[2], 	'nr_bud'		=>$row4[3], 	'nr_mieszk'	=>$row4[4]);
	$_SESSION['kontakty']=$kontakty=array
	('id_kontakt'	=>$row2[0], 	'nazwa'	=>$row2[1], 	'kod'			=>$row2[2], 	'miasto'		=>$row2[3], 	'ulica'=>$row2[4], 
		'nr_bud'	=>$row2[5], 	'nr_mieszk'=>$row2[6]);
	$_SESSION['telefony_k']=$telefony_k=array
	('id_kontakt' =>$row6[0],'telefon'	=>$row6[1], 	'tel_kom'		=>$row6[2]);
	$_SESSION['maile_k']=$maile_k=array
	('id_podm' =>$row8[0], 'email'=>$row8[1]);
	$_SESSION['wlasciciele']=$wlasciciele=array
	('id_wlasc' =>$row5[0], 'nazwa'	=>$row5[1], 'id_bud' =>$row5[2], 'nr_mieszk' =>$row5[3], 	'zgoda'	=>$row5[4]);
?>

<form method="POST" action="index.php?panel=inst&menu=updateabonwyslij&abon=<?php echo "$_SESSION[id_abon]" ?>">
<table style="width:500px" >
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Dane umowy abonenckiej</b>
		</td>
	</tr>
	<tr>
		<td class="klasa2" style="width : 250px;">
			Numer umowy
		</td>
		<td class="klasa4">
			<?php 
				echo "$nr_uma"; 
			?>
		</td>
	</tr>
	<tr>
		<td class="klasa2">
				Data zawarcia umowy (dzień/miesiąc/rok)
		</td>
		<td class="klasa4">
			<?php
				echo "$data_zaw";
			?>
		</td>
	</tr>
			<tr>
				<td class="klasa2">
					Okres obowiązywania umowy
				</td>
				<td class="klasa4">
						<?php
						echo "$umowy[typ_um]";
						?>
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Dane abonenta
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Umowa obowiązuje ?
				</td>
				<td class="klasa4">
					<?php
						echo 	$s=TableToCheckbox("$umowy[obowiazujaca]", "obowiazujaca");
					?>
				</td>
			</tr>	
			<tr>
				<td class="klasa2">
					Status
				</td>
				<td class="klasa4">
						<?php
						echo "$abonenci[status]";
						?>
				</td>
			</tr>
			
			<tr>
				<td class="klasa2"> 
						Imię i nazwisko (nazwa instytucji)
				</td> 
				<td class="klasa4">
					<?php 
						echo "$abonenci[nazwa]"; 
					?>
				</td>
			</tr> 
			<tr>
				<td class="klasa2"> 
						Symbol
				</td> 
				<td class="klasa4">
					<?php 
						echo "$abonenci[symbol]"; 
					?>
				</td>
			</tr> 
			<tr>
				<td class="klasa2">
					PESEL / NIP
				</td>
				<td class="klasa4">
					<?php 
						echo "$abonenci[pesel_nip]"; 
					?>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Seria i nr dowodu osobistego / REGON
				</td>
				<td class="klasa4">
					<?php 
						echo "$abonenci[nrdow_regon]"; 
					?>
				</td>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<?php
							echo " $abonenci[kod] $abonenci[miasto] <br> ul. $abonenci[ulica] $abonenci[nr_bud]/$abonenci[nr_mieszk]";
						?>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon stacjonarny
				</td>
				<td class="klasa4">
					<input size="15" name="a_teldom" value ="<?php echo "$telefony_a[telefon]"; ?>"> 
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="15" name="a_telkom"  value ="<?php echo "$telefony_a[tel_kom]"; ?>"> 
				</td>
			</tr>
			<tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="25" name="a_email"  value ="<?php echo "$maile_a[email]"; ?>"> 
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Miejsce instalacji (jeżeli inne niż adres abonenta)
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres
				</td>
				<td class="klasa4">
						<?php
							echo " $miejsca_instalacji[kod] $miejsca_instalacji[miasto] <br> ul. $miejsca_instalacji[ulica] $miejsca_instalacji[nr_bud]/$miejsca_instalacji[nr_mieszk]";
						?>
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2" >
					Dane do korespondencji (jeżeli inna niż dane abonenta)</font></b></td>
			</tr>
			<tr>
				<td class="klasa2">
					Imię i nazwisko osoby kontaktowej
				</td>
				<td class="klasa4">
					<input size="20" name="k_nazwa"  value ="<?php echo "$kontakty[nazwa]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Ulica
				</td>
				<td class="klasa4">
					<input size="20" name="k_ulica"  value ="<?php echo "$kontakty[ulica]"; ?>" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Numer budynku
				</td>
				<td class="klasa4">
					<input size="2" name="k_nrbud"  value ="<?php echo "$kontakty[nr_bud]"; ?>" >
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Nr mieszkania
				</td>
				<td class="klasa4">
					<input size="2" name="k_nrmieszk" value ="<?php echo "$kontakty[nr_mieszk]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Kod pocztowy
				</td>
				<td class="klasa4">
					<input size="6" name="k_kod"   value ="<?php echo "$kontakty[kod]"; ?>">
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Miasto
				</td>
				<td class="klasa4">
					<input size="20" name="k_miasto" value ="<?php echo "$kontakty[miasto]"; ?>">
				</td>	
			</tr>
			<tr>
				<td class="klasa2">
					Telefon domowy
				</td>
				<td class="klasa4">
					<input size="20" name="k_teldom" value ="<?php echo "$telefony_k[telefon]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Telefon komórkowy
				</td>
				<td class="klasa4">
					<input size="18" name="k_telkom" value ="<?php echo "$telefony_k[tel_kom]"; ?>" >
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="25" name="k_email" value ="<?php echo "$maile_k[email]"; ?>"">
				</td>
			</tr>

			<tr>
				<td class="klasa1" colspan="2">
					Właściciel lokalu // Główny lokator (jeżeli inny niż Abonent)
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Imię i nazwisko (nazwa)
				</td>
				<td class="klasa4">
					<?php 
						echo "$wlasciciele[nazwa]"; 
					?>
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Zgoda na montaż instalacji dostępu do Internetu ?
				</td>
				<td class="klasa4">
					<?php
						$s=TableToCheckbox($wlasciciele[zgoda], "w_zgoda");
						echo $s;
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="Uaktualnij" name="przycisk1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
