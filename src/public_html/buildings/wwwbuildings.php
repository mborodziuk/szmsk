<a href="index.php?panel=fin&menu=buildadd">Nowy budynek </a> &nbsp;
<br/>
<br/>

<?php

	if(empty($_POST))
		$_POST=$_SESSION[$session[building][pagination]];
	
	if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) ) 
		{	
			$_POST[od_rok]=date("Y");
			$_POST[od_miesiac]=date("m");
			$_POST[od_dzien]=date("01");
		}

	if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) ) 
		{	
			$_POST[do_rok]=date("Y");
			$_POST[do_miesiac]=date("m");
			$_POST[do_dzien]=date("d");
		}

/*	if (empty($_POST[predkosc]))
		$_POST[predkosc]="1000";*/
	if (empty($_POST[liczba]))
		$_POST[liczba]="50";
		
		$p=array
		(	
			'liczba' 		=> $_POST[liczba], 'predkosc' => $_POST[predkosc],
			'data_od' => "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
		 	'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
			'ul' => $_POST[ul], 'miasto'	=> $_POST[miasto] );

?>
<form method="POST" action="index.php?panel=fin&menu=buildings&order=<?echo $_GET[order]?>">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 80px;"> Przyłączony od dnia </td>
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
      <td> Liczba na stronie</td>
      <td> Prędkość przyłącza  </td>
      <td> Miasto  </td>
      <td> Ulica  </td>
      <td> Wyślij  </td>
		</tr>
    <tr class="tr1">
      <td style="width: 80px;">Do dnia</td>
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
				$liczba=array(10, 20, 30, 50, 100, 200, 3000);
				$www->SelectFromArray($liczba,"liczba", $_POST[liczba]); 
			?>
		</td>
		      <td style="width: 200px;">
			<?php
				$predkosc=array($conf[select], 1000, 100, 50, 25);
				$www->SelectFromArray($predkosc,"predkosc", $_POST[predkosc],  $conf[select]); 
			?>
		</td>
		<td style="width: 200px;">
                <?php
                $q="select distinct miasto from ulice order by miasto";
                Select($q, "miasto", $p[miasto], $conf[select]);
                ?>
		</td>
		 <td style="width: 200px;">
	        <?php
				$q="select distinct nazwa from ulice order by nazwa";
    			Select($q, "ul", $p[ul], $conf[select]);
	        ?>
	  </td>
	 
		<td style="width: 200px;">
				<input type="submit" class="button1" value="Filtruj" name="przycisk">
		</td>
	</tr>
</table>
</form>



<form method="POST" action="index.php?menu=delete">
<?php
	$_SESSION[del1]=array('budynki'=>'id_bud');
	$_SESSION[del2]=array();
?>
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
  <tbody>
    <tr class="tr1">
      <td style="width: 10px;">
      	<a href=index.php?panel=fin&menu=buildings&order=b.id_bud> Id </a>      </td>
      <td style="width: 70px;">
      	<a href=index.php?panel=fin&menu=buildings&order=u.miasto> Miasto </a>
       </td>
      <td style="width: 80px;">
      	<a href=index.php?panel=fin&menu=buildings&order=u.nazwa,b.numer> Ulica </a>
       </td>
      <td style="width: 70px;">
				<a href=index.php?panel=fin&menu=buildings&order=a.nazwa> Administracja </a> 
      </td>
	      <td style="width: 40px;">
      	Ilość abonentów
      </td>
      <td style="width: 40px;">
				<a href=index.php?panel=fin&menu=buildings&order=b.il_mieszk> Ilość mieszkańców </a> 
      </td>
      <td style="width: 70px; ">
      					<a href=index.php?panel=fin&menu=buildings&order=b.przylacze> Przyłącze </a> 
      </td>
      <td style="width: 70px;">
      					<a href=index.php?panel=fin&menu=buildings&order=p.adres> Adresacja IP </a>       	
      </td>
      <td style="width: 10px;">
			::
      </td>
    </tr>
    <?php
			$buildings->BuildingList($dbh, $p, $www);
		?>
	<tr>
		<td class="klasa1" colspan="9">
				<input type="submit" class="button1" value="Kasuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
<br/>
