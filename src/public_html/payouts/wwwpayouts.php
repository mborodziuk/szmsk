<?php

	$Q1="select sum(kwota) from wplaty where forma='gotówka'";
	$Q2="select sum(kwota) from wyplaty where forma='gotówka'";
		
	$sum_wplaty=Query2($Q1, $dbh);	
	$sum_wyplaty=Query2($Q2, $dbh);	
		
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
  if (empty($_POST[order]))
	    $_POST[order]="Data wpłaty";
  
  if (empty($_POST[rozliczona]))
			$_POST[rozliczona]="Rozliczone";

  $param=array
	(
		'typ'			=>  $_GET[typ],    		'rozliczona' => $_POST[rozliczona],
    'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
    'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
    'order'		=>  $_POST[order], 'forma' => $_POST[forma],
		'prac'		=> $_POST[prac]
	);
?>

<a href="index.php?panel=fin&menu=payoutadd">Wypłata </a> &nbsp;
<br/>
<br/>

<?php
	$_SESSION[upd1]=array('wyplaty'=>'id_wyp');
	$_SESSION[upd2]=array();
	
	$saldo=$sum_wplaty[0]-$sum_wyplaty[0];
	$saldo=number_format($saldo, 2, ',','');
	
	echo "<strong>Saldo:</strong>  $saldo <br>";


?>

<form method="POST" action="index.php?panel=fin&menu=payouts">
<table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1" >
  <tbody>
    <tr class="tr1">
       <td style="width: 80px;">
           Od 
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
       <td> Typ dokumentow </td>
       <td> Sortowanie  </td>
       <td> Nazwa kontrahenta  </td>
       <td> Wyślij  </td>
		<tr class="tr1">
		<td style="width: 80px;">Do</td>
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
		      $rozliczona=array("Rozliczone", "Nierozliczone");
		      $www->SelectFromArray($rozliczona,"rozliczona", $_POST[rozliczona]);
		    ?>
		</td>
		<td style="width: 200px;">
	      <?php
					$order=array("Data wpłaty", "Nazwa kontrahenta", "Gotówka", "Forma wpłaty", );
					$www->SelectFromArray($order,"order", $_POST[order]);
	      ?>
	     </td>
	  <td style="width: 200px;">
        <?php
	         $ida=Select($QUERY12, "prac");
	      ?>
	  </td>
	  <td style="width: 200px;">
          <input type="submit" class="button1" value="Filtruj" name="przycisk">
	  </td>
	</tr>
  </tbody>
  </table>
  </form>


  <form method="POST" action="index.php?panel=fin&menu=payoutsupdall">
  <table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
    <tbody>		
	<tr class="tr1">
      <td style="width: 90px;">
      	Id
      </td>
      <td style="width: 80px;">
      	Księgowanie Zlecenie Forma      	
      </td>
    <td style="width: 50px;">
      	Kwota
      </td>
      <td style="width: 200px;">
      	Kontrahent Abonent
    </td>
      <td style="width: 300px;">
      	Opis
      </td>
      <td style="width: 40px;">
			KP
      </td>
      <td style="width: 20px;">
			Usuń
      </td>
   </tr>
    <?php
			$payout->PayoutList($dbh, $param, $www);
    ?>
	<tr>
    	<td class="klasa1" colspan="9">
	    <input type="submit" class="button1" value="Uaktualnij >>>" name="przycisk">
	</td>
	</tr>
  </tbody>
</table>
</form>

<br/>
