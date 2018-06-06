<?php

	if(empty($_POST))
		$_POST=$_SESSION[$session[komp][pagination]];

	if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) ) 
		{	
            $_POST[od_rok]=date("Y",  strtotime("0 Months") );
            $_POST[od_miesiac]=date("m", strtotime("0 Months") );
            $_POST[od_dzien]=date("01");
		}

	if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) ) 
		{	
            $_POST[do_rok]=date("Y", strtotime("+3 Months") );
            $_POST[do_miesiac]=date("m", strtotime("+3 Months") );
            $_POST[do_dzien]=date("d");
		}
		
	if (empty($_POST[order]))
		$_POST[order]="ID Komputera";
	if (empty($_POST[taryfa]))
		$_POST[taryfa]="Wszystkie";

?>

<a href="index.php?panel=inst&menu=dodajkomp">Nowy komputer</a> &nbsp;
<br/>
<br/>

<form method="POST" action="index.php?panel=admin&menu=komputery">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;"> 
			Podłączony od 
		</td>
      <td>
			<?php
				$lata=array($_POST[od_rok]);
				for ($i=1; $i<=10; ++$i)
					{
						$rok1=$_POST[od_rok]+$i;
						$rok2=$_POST[od_rok]-$i;
						array_push($lata, $rok1);
						array_unshift($lata, $rok2);
					}
				$www->SelectFromArray($lata,"od_rok", $_POST[od_rok]); 
			?>
		</td> 
	   <td style="width: 20px;">
			<?php
				$miesiace=array("01","02","03","04","05","06","07","08","09","10","11","12");
				$www->SelectFromArray($miesiace,"od_miesiac", $_POST[od_miesiac]); 
			?>
		</td>
	   <td style="width: 20px;">
			<?php
				$dni=array("01","02","03","04","05","06","07","08","09","10","11","12", "13","14","15",
								"16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
				$www->SelectFromArray($dni,"od_dzien", $_POST[od_dzien]); 
			?>
		</td>
      <td> Pakiet </td>
      <td> Sortowanie  </td>
      <td> Abonent  </td>
      <td> Wyślij  </td>
		</tr>
    <tr class="tr1">
      <td style="width: 80px;">Podłączony do</td>
      <td>
			<?php
				$lata=array($_POST[od_rok]);
				for ($i=1; $i<=10; ++$i)
					{
						$rok1=$_POST[od_rok]+$i;
						$rok2=$_POST[od_rok]-$i;
						array_push($lata, $rok1);
						array_unshift($lata, $rok2);
					}
				$www->SelectFromArray($lata,"do_rok", $_POST[do_rok]); 
			?>
		</td> 
	   <td style="width: 20px;">
			<?php
				$www->SelectFromArray($miesiace,"do_miesiac", $_POST[do_miesiac]); 
			?>
		</td>
	   <td style="width: 20px;">
			<?php
				$www->SelectFromArray($dni,"do_dzien", $_POST[do_dzien]); 
			?>
		</td>
      <td style="width: 200px;">
			<?php
				$taryfa=array("Wszystkie","STD-O", "STD34", "MED-O");
				$www->SelectFromArray($taryfa,"stan", $_POST[taryfa]); 
			?>
		</td>
		<td style="width: 200px;">
			<?php
				$order=array("ID Komputera", "Nazwa abonenta");
				$www->SelectFromArray($order,"order", $_POST[order]); 
			?>
		</td>
		 <td style="width: 200px;">
     <?php
	        $ida=$www->SelectWlasc($dbh, "abon", $_POST[abon]);
	    ?>
	  </td>
	 
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>



<form method="POST" action="index.php?panel=inst&menu=deletekomp&typ=komp">

<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 5%;">
      	Id
      </td>
      <td style="width: 20%;">
      	Nazwa
       </td>
      <td style="width: 22%;">
      	Abonent
      </td>
      <td style="width: 10%;">
      	Adresy IP
      </td>
      <td style="width: 10%;">
      	Adres NAT1:1
      </td>
      <td style="width: 10%; ">
      	Adresy fizyczne
      </td>
      <td style="width: 10%;">
				Taryfa
      </td>
      <td style="width: 10px;">
	      Usługa
      </td>
      <td style="width: 3%;">
			::
      </td>
    </tr>
    <?php
    $computers->ListaKomputerow($dbh, $_POST);
	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

<form method="POST" action="index.php?menu=generate&typ=netgen">
<table style="text-align: left; width: 900px; height: 30px;">
  <tbody>
    <tr class="tr1">
      <td style="width: 200px;">
				:: Generator konfiguracji
      </td>
		<td>
				<input type="submit" value="Uruchom >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>

