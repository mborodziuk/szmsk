<?php

	$data=$conf[data];

	$Q2="select * from kontakty where wazne_od <= '$conf[data]' and wazne_do >='$conf[data]'  and id_podm='$_GET[abon]'";
	$Q3="select id_podm, telefon, tel_kom from telefony where id_podm='$_GET[abon]'";
	
	$Q5="select id_sch, data from scheduler where encja='abonenci' and kolumna='saldo_dop' and argument='$_GET[abon]'";
	$Q6="select k.id_kontakt, t.telefon, t.tel_kom from telefony t, kontakty k where t.id_podm=k.id_kontakt and k.id_podm='$_GET[abon]'";
	$Q7="select id_podm, email from maile where id_podm='$_GET[abon]'";
	$Q8="select m.id_podm, m.email from maile m, kontakty k where m.id_podm=k.id_kontakt and k.id_podm='$_GET[abon]'";

	$Q10="select n.symbol, n.nazwa, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, a.pesel_nip, a.nrdow_regon, a.status, s.id_bud, 
			a.saldo, a.aktywny, a.platnosc, a.fv_comiesiac, a.fv_email, a.ksiazeczka, a.opis, a.uwagi, n.id_nzw, s.id_sdb, a.saldo_dop, a.haslo
			from abonenci a, ulice u, budynki b, nazwy n, adresy_siedzib s
			where a.id_abon=n.id_abon and a.id_abon=s.id_abon and b.id_bud=s.id_bud and u.id_ul=b.id_ul 
			and s.wazne_od <= '$data' and s.wazne_do >= '$data' and n.wazne_od <= '$data' and n.wazne_do >= '$data'
			and a.id_abon='$_GET[abon]'";


	$Q12="select numer from konta_wirtualne where id_abon='$_GET[abon]'";
			

	$row2=Query2($Q2, $dbh);
	$row3=Query2($Q3, $dbh);

	$row5=Query2($Q5, $dbh);
	$konto=Query2($Q12, $dbh);
	$login=substr($konto[0], 28,4);
	$login="0$login";

	$row6=Query2($Q6, $dbh);
	$row7=Query2($Q7, $dbh);
	$row8=Query2($Q8, $dbh);
	$row10=Query2($Q10, $dbh);


	$a="$_GET[abon]"."$session[abonent][update]";
	$_SESSION[$a]=$abonenci=array
	('id_abon' 		=> $_GET[abon], 	'symbol'			=>$row10[0], 	'nazwa'	=>$row10[1], 	'nr_mieszk'=>$row10[6],
	'pesel_nip'		=>$row10[7],		'nrdow_regon'	=>$row10[8],	'status'	=>$row10[9],	'id_bud'	=>$row10[10], 
	'saldo' => $row10[11], 'aktywny' => $row10[12], 	'platnosc' => $row10[13], 'fv_comiesiac'  => $row10[14], 
	'fv_email'  => $row10[15], 	'ksiazeczka'  => $row10[16], 'opis' => $row10[17], 'uwagi' => $row10[18], 
	'id_nzw' => $row10[19], 'id_sdb' => $row10[20], 'saldo_dop' => $row10[21], 'haslo' => $row10[22], 'saldo_data' => $row5[1], 'id_sch' => $row5[0]
	);
	
	$ta="$_GET[abon]"."_telefony_a";
	$_SESSION["$ta"]=$telefony_a=array
	('id_podm'		=>$row3[0], 'telefon'		=>$row3[1], 	'tel_kom'		=>$row3[2]);
	
	$ma="$_GET[abon]"."_maile_a";
	$_SESSION["$ma"]=$maile_a=array
	('id_podm' =>$row7[0], 'email'=>$row7[1]);
	
	
	$k="$_GET[abon]"."_kontakty";
	$_SESSION["$k"]=$kontakty=array
	('id_kontakt'	=>$row2[0], 	'nazwa'	=>$row2[1], 	'kod'			=>$row2[2], 	'miasto'		=>$row2[3], 	'ulica'=>$row2[4], 
	'nr_bud'	=>$row2[5], 	'nr_mieszk'=>$row2[6], 	'kcecha'=>$row2[11]);
	
	$tk="$_GET[abon]"."_telefony_k";
	$_SESSION["$tk"]=$telefony_k=array
	('id_kontakt' =>$row6[0],'telefon'	=>$row6[1], 	'tel_kom'		=>$row6[2]);
	
	$mk="$_GET[abon]"."_maile_k";
	$_SESSION["$mk"]=$maile_k=array
	('id_podm' =>$row8[0], 'email'=>$row8[1]);
	
	
	$data=date("Y-m-d");
	$srv=$customers->AbonServices($dbh, $_GET[abon], $data);

?>


<form method="POST" action="index.php?panel=inst&menu=updateabonwyslij&abon=<?php echo "$_GET[abon]" ?>">
<table style="width:650px" class="tbk3">
<tbody>
	<tr>
		<td class="klasa1" colspan="2">
			<b> Dane umowy abonenckiej</b>
		</td>

		</tr>

		<tr>
			<td class="klasa4" colspan="2">
				<table class="tbk1" style="text-align: left; width: 650px; height: 75px;" border="1" cellpadding="0" cellspacing="0">
				  <tbody>
    					<tr class="tr1">
					      <td style="width: 5px;">
      						L.p.
	      				</td>
					      <td style="width: 100px;">
      						Nr umowy
	      				</td>
 					     <td style="width: 100px;">
      					Data zawarcia
				       </td>
								<td style="width: 100px;">
      					Data wejścia w życie
				       </td>
 					     <td style="width: 100px;">
      						Okres obowiązywania
									</td>
 					     <td style="width: 100px;">
      						Ulga w zł <br> Ulga pozostała
				       </td>
 					     <td style="width: 100px;">
      						Status
				       </td>
							<td style="width: 5px; ">
								::
							</td>							
 					     <td style="width: 10px;">
      						PDF
				       </td>
							</tr>
	
	<?php
		echo "Ulga nie obejmuje kary za niezwrócony sprzęt przez abonenta.";
		$customers->ContractList($dbh, $_GET[abon]);
	?>
					  </tbody>
				</table>
		</td>	
		</tr>
			<tr>
			<td>
			<a href="index.php?panel=inst&menu=addum&abon=<?php echo "$_GET[abon]" ?>">Nowa umowa >>> </a>
			</td>
			</tr>		
		<tr>
				<td class="klasa1" colspan="2">
					Dane abonenta
				</td>
			</tr>

			<tr>
                                <td class="klasa2">
                                        Aktywny ?
                                </td>
                                <td class="klasa4">
                                <?php
                                    echo TableToCheckbox($abonenci[aktywny], "aktywny");
                                ?>
                                </td>
                        </tr>					
						<tr>
				<td class="klasa2">
					Indywidualny nr konta
				</td>
				<td class="klasa4">
					<?php
						echo $konto[0];
					?>					
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Login i hasło do panelu klienta
				</td>
				<td class="klasa4">
					<?php
						echo "$login / $abonenci[haslo]";
					?>					
				</td>
			</tr>		
				<tr>
				<td class="klasa2">
					Książeczka abonamentowa ?
				</td>
				<td class="klasa4">
					<?php
						echo TableToCheckbox($abonenci[ksiazeczka], "ksiazeczka");
					?>
				</td>
			</tr>			
			<tr>
          <td class="klasa2">
                  Co miesięczna wysyłka FV ?
             </td>
             <td class="klasa4">
                <?php
                  echo TableToCheckbox($abonenci[fv_comiesiac], "fv_comiesiac");
                ?>
             </td>
       </tr>
			<tr>
          <td class="klasa2">
                  Wysyłka FV e-mailem ?
             </td>
             <td class="klasa4">
                <?php
                  echo TableToCheckbox($abonenci[fv_email], "fv_email");
                ?>
             </td>
       </tr>
			<tr>
				<td class="klasa2">
					Płatność do dnia miesiąca
				</td>
				<td class="klasa4">
					<?php
						$dni=range(1,31);
						$www->SelectFromArray($dni, "platnosc",$abonenci[platnosc])
					?>					
				</td>
			</tr>

			<tr>
				<td class="klasa2">
					Status abonenta
				</td>
				<td class="klasa4">
					<?php
						$status=array("Podłączony", "Oczekujący", "Zainteresowany");
						$www->SelectFromArray($status, "status_abonenta",$abonenci[status])
					?>					

					</select>
				</td>
			</tr>
			
		<tr>
				<td class="klasa1" colspan="2">
					Nazwa
				</td>
			</tr>
			<tr>
				<td class="klasa2"> 
						Imię i nazwisko (nazwa instytucji)
				</td> 
				<td class="klasa4">
					<input size="60" name="a_nazwa"  value ="<?php echo "$abonenci[nazwa]"; ?>">
				</td>
			</tr> 
			<tr>
				<td class="klasa2"> 
						Nazwa skrócona (firmy i instytucje)
				</td> 
				<td class="klasa4">
					<input size="30" name="a_symbol" value ="<?php echo "$abonenci[symbol]"; ?>" >
				</td>
			</tr> 
		<tr>
			<td>
			<a href="index.php?panel=inst&menu=nameadd&abon=<?php echo "$_GET[abon]" ?>">Nowa nazwa >>> </a>
			</td>
			</tr>	
			<tr>
					<td class="klasa1" colspan="2">
					Saldo
				</td>		
			<tr>
				<td class="klasa2">
					Saldo
				</td>
				<td class="klasa4">
					<input size="10" name="saldo" value ="<?php echo "$abonenci[saldo]"; ?>"> 
				</td>
			</tr>	
			<tr>
				<td class="klasa2">
					Saldo dopuszczalne
				</td>
				<td class="klasa4">
					<input size="10" name="saldo_dop" value ="<?php echo "$abonenci[saldo_dop]"; ?>"> 
				</td>
					</tr>
					<tr>
								<td class="klasa2">
					Data dop. salda
				</td>
				<td class="klasa4">
					<input size="10" name="saldo_data" value ="<?php echo "$abonenci[saldo_data]"; ?>"> 
				</td>
			</tr>	
		<tr>
				<td class="klasa1" colspan="2">
					Adres siedziby
				</td>
			</tr>			
			<tr>
				<td class="klasa2">
					Budynek
				</td>
				<td class="klasa4">
						<?php
	  						Select($QUERY1, "a_budynek",$row10[10] );
						?>
				
				</td>
			</tr>
		
			<tr>
				<td class="klasa2">
					Nr mieszkania
				</td>
				<td class="klasa4">
					<input size="2" name="a_nrmieszk" value ="<?php echo "$abonenci[nr_mieszk]"; ?>" >
				</td>
			</tr>

						<tr>
			<td>
			<a href="index.php?panel=inst&menu=addressadd&abon=<?php echo "$_GET[abon]" ?>">Nowy adres >>> </a>
			</td>
			</tr>	

			<tr>
				<td class="klasa1" colspan="2">
					Pesel, umer dowodu, NIP, REGON
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					PESEL (NIP)
				</td>
				<td class="klasa4">
					<input size="20" name="pesel_nip"   value ="<?php echo "$abonenci[pesel_nip]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					Nr dowodu osobistego (REGON)
				</td>
				<td class="klasa4">
					<input size="20" name="nrdow_regon"  value ="<?php echo "$abonenci[nrdow_regon]"; ?>" >
				</td>
				</td>
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Dane kontaktowe
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
				<td class="klasa2">
					Tel. stacj. lub druga komórka
				</td>
				<td class="klasa4">
					<input size="15" name="a_teldom" value ="<?php echo "$telefony_a[telefon]"; ?>"> 
				</td>
			</tr>

			<tr>
			<tr>
				<td class="klasa2">
					Adres e-mail
				</td>
				<td class="klasa4">
					<input size="30" name="a_email"  value ="<?php echo "$maile_a[email]"; ?>"> 
				</td>
			</tr>

			<tr>
				<td class="klasa1" colspan="2">
					Dane do korespondencji (jeżeli inna niż dane abonenta)</font></b></td>
			</tr>
			<tr>
				<td class="klasa2">
					Nazwa kontaktu 
					</td>
				<td class="klasa4">
					<input size="70" name="k_nazwa"  value ="<?php echo "$kontakty[nazwa]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2">
					              <?php
               $cecha=array($conf[select],"ul.", "al.", "pl.");
                $www->SelectFromArray($cecha,"kcecha", $kontakty[kcecha]);
            ?>
				</td>
				<td class="klasa4">
					<input size="30" name="k_ulica"  value ="<?php echo "$kontakty[ulica]"; ?>" >
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
					<input size="18" name="k_email" value ="<?php echo "$maile_k[email]"; ?>">
				</td>
			</tr>
			<tr>
			<td>
			<a href="index.php?panel=inst&menu=ktkadd&abon=<?php echo "$_GET[abon]" ?>"> Nowe dane korespondencyjne >>> </a>
			</td>
			</tr>	

				<tr>
				<td class="klasa1" colspan="2">
					Uwagi dodawane na fakturze
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="uwagi" cols="70" rows="5"><?php echo "$abonenci[uwagi]"; ?></textarea>
		</td>	
	</tr>  				
				<tr>
				<td class="klasa1" colspan="2">
					Opis abonenta
				</td>
			</tr>

	<tr>
		<td class="klasa1" colspan="2">
			<textarea name="opis" cols="70" rows="10"><?php echo "$abonenci[opis]"; ?></textarea>
		</td>	
	</tr>  	  

			<tr>
				<td class="klasa1" colspan="2">
					Awarie
				</td>
			</tr>			
						<tr>
			<td>
			<a href="index.php?panel=inst&menu=dodajawarie&abon=<?php echo "$_GET[abon]" ?>">Dodaj awarie >>> </a>
			</td>
						<td>
			<a href="index.php?panel=inst&menu=awarie&abon=<?php echo "$_GET[abon]" ?>">Lista >>> </a>
			</td>
			
			
			</tr>
			<tr>
				<td class="klasa1" colspan="2">
					Uslugi
				</td>
				</tr>
				<tr>
			<td  class="klasa4" colspan="2">
					<?php
							echo "$srv[desc] <br>";
							$sum=number_format($srv[sum], 2, ',','');
							echo "Razem: <b>$sum zł </b> brutto<br>";
					?>
			</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<input type="submit" value="Wyślij" name="przycisk1"  class="button1">
				</td>
			</tr>
<tbody>
</table>
		
</form>
		
