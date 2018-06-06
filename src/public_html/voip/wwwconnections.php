<?php

		
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
	    $_POST[order]="data";
  
  if (empty($_POST[rozliczona]))
			$_POST[rozliczona]="Rozliczone";

  $param=array
	(		'typ'			=>  $_GET[typ],    		'rodzpol' => $_POST[rodzpol],
    'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
    'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
    'order'		=>  $_POST[order], 'forma' => $_POST[forma],
		'abon'		=> $_POST[abon], 'ntl' => $_POST[ntl]
	);
?>

<a href="javascript&#058;displayWindow('pdf/mkpdf.php?dok=vb&data_od=
<?php echo $param[data_od] ?>&data_do=<?php echo $param[data_do]?>&abon=<?php echo $param[abon]?>',650,1000, '38')">
Biling</a> &nbsp;


<form method="POST" action="index.php?panel=admin&menu=voipcon">
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
       <td> Rodzaj połączenia </td>
       <td> Sortowanie  </td>
			        <td> Numer tel. </td>
       <td> Abonent  </td>
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
		      $rodzpol=array("Wszystkie", "Międzymiastowe", "Lokalne", "Komórkowe", "Międzynarodowe", "Specjalne");
		      $www->SelectFromArray($rodzpol,"rodzpol", $_POST[rodzpol]);
		    ?>
		</td>
		<td style="width: 200px;">
	      <?php
					$order=array("Data", "Nazwa abonenta", "Opłata", "Numer docelowy");
					$www->SelectFromArray($order,"order", $_POST[order]);
	      ?>
	     </td>
		  <td style="width: 200px;">
        <?php
					$www->Select2($dbh, $QA38, "ntl", $_POST[ntl]);
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


  <form method="POST" action="index.php?panel=fin&menu=updatewpl">
  <table style="text-align: center; width: <?php echo $conf[width2];?>; height:<?php echo $conf[height2];?>" class="tbk1">
    <tbody>		
	<tr class="tr1">
      <td style="width: 30px;">
      	Lp     	
      </td>
      <td style="width: 50px;">
      	Data      	
      </td>
    <td style="width: 400px;">
      	Abonent 
      </td>
      <td style="width: 100px;">
      	Numer źródłowy
    </td>
      <td style="width: 100px;">
      	Numer docelowy
      </td>
      <td style="width: 50px;">
			Opłata
      </td>
      <td style="width: 50px;">
			Czas połączenia
      </td>			
      <td style="width: 100px;">
			Rodzaj połączenia
      </td>   </tr>
    <?php
			$voip->ConnectionsList($dbh, $param);
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
