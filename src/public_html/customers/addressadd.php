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

<form method="POST" action="index.php?panel=inst&menu=addressaddsnd&abon=<?php echo $_GET[abon]?>">
<table style="width:500px" >
<tbody>

			<tr>
				<td class="klasa1" colspan="2">
					Nowa siedziba
					</td>
			</tr>
			<tr>
			    <td class="klasa2">
					Budynek
				</td>
				<td class="klasa4">
						<?php
	  						Select($QUERY1,"a_budynek");
						?>
					
				</td>
			</tr>
			<tr>
         <td class="klasa2">
            Ulica <i>(jeśli nie ma odpowiedniego bud. powyżej)<i/>
         </td>
      <td class="klasa4">
      <?php
					Select($QUERY9, "a_ulica");
				    ?>
	                        </td>
		        </tr>
			<tr>
				<td class="klasa2">
					Nr budynku <i>(jeśli nie ma odpowiedniego bud. powyżej)<i/>
				</td>
				<td class="klasa4">
					<input size="2" name="a_nrbud" >
				</td>
			</tr>
                        <tr>
                                <td class="klasa2">
                                        Nr mieszkania
	                                </td>
	                                <td class="klasa4">
                                    <input size="2" name="a_nrmieszk" >
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
		
