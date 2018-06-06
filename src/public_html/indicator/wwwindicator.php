
<?php
        if ( empty($_POST[od_rok]) && empty($_POST[od_miesiac]) && empty($_POST[od_dzien]) )
            {
            $_POST[od_rok]=date("2015");
            $_POST[od_miesiac]="01";
            $_POST[od_dzien]=date("01");
            }
        if ( empty($_POST[do_rok]) && empty($_POST[do_miesiac]) && empty($_POST[do_dzien]) )
            {
            $_POST[do_rok]=date("Y");
            $_POST[do_miesiac]=date("m");
            $_POST[do_dzien]=date("d");
            }
	
	$p=array(
			'etap' 		=> $_POST[etap],		'nazwa'	=> $_POST[nazwa],		'ulice'	=> $_POST[ulice], 'typ'=>$_POST[typ],
			'budynki'	=> $_POST[budynki],	'saldo' 	=> $_POST[saldo],		'miasto' => $_POST[miasto],
			'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
			'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
 			);

	
	if (empty($p[etap]))
	$p[etap]=$conf[select];
	
	if (empty($p[typ]))
					$p[typ]='niewykonane';
	
//echo $p[typ];
	
	if (empty($p[umowa]))
		$p[umowa]='oczekujący';
	
	if ( !isset($p[usluga]) )
		$p[usluga]="Internet";
	
	
	foreach ($p as $k => $v)
	{
		if ( !isset($p[$k]) )
			$p[$k]=$conf[select];
	}
	
	$m=$_POST[do_miesiac];
	$y=$_POST[do_rok];
	$yb=$y-1;

	
	$_SESSION['plugging'.$_SESSION[login]]=$p;
	

	?>

<form method="POST" action="index.php?panel=inst&menu=plg">
<table style="text-align: left; width: 1000px; height: 50px;" class="tbk1">
  <tbody>
    <tr class="tr1">
       <td style="width: 200px;">
           Okres od
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
       
		<td style="width: 80px;"> od do</td>
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
          <input type="submit" value="Filtruj" class="button1" name="przycisk">
	      </td>
	</tr>
	
  </tbody>
  </table>
  </form>
	
	
	<form method="POST" action="index.php?panel=inst&menu=plgmake">
<?php
$_SESSION[etap]=$p[etap];
?>
<table class="tbk1" style="text-align: left; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>;">
  <tbody>
    <tr class="tr1">
		      <td style="width: 10px;">
			Lp.
      </td>
      <td style="width: 50px;">
      	Id <br> Zgłoszenie
      </td>
      <td style="width: 50px;">
      	Zakończenie
      </td>
      <td style="width: 235px;">
      	Imię i nazwisko <br> (nazwa)
       </td>
      <td style="width: 225px;">
      	Adres instalacji
      </td>
      <td style="width: 140px; ">
      	Dane kontaktowe
      </td>
      <td style="width: 15px;">
		   Czas na podłączenie
      </td>

    </tr>
    <?php
    $indicator->IndicatorList($dbh, $p);	?>
	<tr>
		<td class="klasa1" colspan="10">
				<input type="submit" class="button1" value="Zastosuj >>>" name="przycisk">
		</td>
	</tr>
  </tbody>
</table>
</form>
	
