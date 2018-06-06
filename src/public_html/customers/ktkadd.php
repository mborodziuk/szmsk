<?php
	$fd=date("Y-m-01");
	
   $Q1="select a.symbol, a.nazwa, a.id_abon, k.nazwa_smb, t.symbol,
			kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info,	k.podlaczony, k.fv, k.id_taryfy, k.id_komp
			from (( konfiguracje kf full join komputery k on kf.id_konf=k.id_konf) full join towary_sprzedaz t on 
			t.id_tows=k.id_taryfy ) full join abonenci a on a.id_abon=k.id_abon
			where a.id_abon='$_GET[abon]'";
			
	$Q2="select id_stb, typ, mac, sn, id_abon, id_taryfy, aktywny, fv, data_aktywacji, pin 
				from settopboxy where id_abon='$_GET[abon]'";
	
	$Q3="select t.id_tlv, t.numer, t.aktywny, t.fv, a.symbol, a.nazwa,  b.id_bmk, b.producent, b.nr_seryjny, t.id_tvoip, 
	a.id_abon, t.data_aktywacji from   
	(telefony_voip t left join towary_sprzedaz tw on t.id_tvoip=tw.id_tows ) left join ( (telefony_voip tl left join bramki_voip b on tl.id_bmk=b.id_bmk)  left join abonenci a   on a.id_abon=tl.id_abon ) on a.id_abon=t.id_abon
	where a.id_abon='$_GET[abon]'";
?>

<form method="POST" action="index.php?panel=inst&menu=ktkaddsnd&abon=<?php echo $_GET[abon]?>">
<table style="width:500px" >
<tbody>

			<tr>
				<td class="klasa1" colspan="2">
					Nowe dane do korespondencji
					</td>
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
              <?php
               $cecha=array($conf[select],"ul.", "al.", "pl.");
                $www->SelectFromArray($cecha,"kcecha", "ul.");
            ?>
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
					<input size="18" name="k_email" value ="<?php echo "$maile_k[email]"; ?>">
				</td>
			</tr>
			<tr>
				<td class="klasa2"> 
						Ważne od
				</td> 
				<td class="klas4">
					<input size="10" name="wazne_od" value ="<?php 	$fd=date("Y-m-01"); echo "$fd"; ?>">
				</td>
			</tr> 			

			<tr>
	 <td> 
  	 </td>
  	  <td>
  	  	<INPUT type="submit" name="wyslij" value="Uaktualnij" size="30" class="button1"> 
	 </td>
	 </tr>
  </tbody>		
<tbody>
</table>
		
</form>
		
