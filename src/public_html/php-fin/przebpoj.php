<?
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

        if (empty($_POST[zatwierdzona]))
                    $_POST[zatwierdzona]="Zatwierdzone";
                                

        if (empty($_POST[order]))
	        $_POST[order]="Data";
	
        $param=array
        (
	'typ'		=>  $_GET[typ],    	
        'data_od'	=> "$_POST[od_rok]"."-"."$_POST[od_miesiac]"."-"."$_POST[od_dzien]",
        'data_do'	=> "$_POST[do_rok]"."-"."$_POST[do_miesiac]"."-"."$_POST[do_dzien]",
        'order'		=>  $_POST[order], 	'zatwierdzona'	=> $_POST[zatwierdzona],
	'pojazd'	=>  $_POST[pojazd] 
	);


?>

<a href="index.php?panel=fin&menu=addnewjzd&data_od=<? echo $param[data_od] ?>
&data_do=<? echo $param[data_do]?>&pojazd=<? echo $param[pojazd]?>">Nowe jazdy </a>&nbsp;
<a href="javascript&#058;displayWindow('func/pdf.php?dok=epp&data_od=<? echo $param[data_od] ?>
&data_do=<? echo $param[data_do]?>&pojazd=<? echo $param[pojazd]?>',1100,800, '38')">Ewidencja przebiegu pojazdu</a>



<br/>
<br/>


<?
	$_SESSION[upd1]=array('jazdy'=>'id_jzd');
	//$_SESS
	$_SESSION[upd2]=array();
?>
<form method="POST" action="index.php?panel=fin&menu=przebpoj">
<table style="text-align: left; width: 750px; height: 50px;" class="tbk1" >
  <tbody>
    <tr class="tr1">
       <td style="width: 80px;">
           Od 
       </td>
       <td>
       <?
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
       <?
           $miesiace=array("01","02","03","04","05","06","07","08","09","10","11","12");
           $www->SelectFromArray($miesiace,"od_miesiac", $_POST[od_miesiac]);
       ?>
       </td>
       <td style="width: 20px;">
       <?
            $dni=array("01","02","03","04","05","06","07","08","09","10","11","12", "13","14","15",
            "16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
            $www->SelectFromArray($dni,"od_dzien", $_POST[od_dzien]);
       ?>
       </td>
       <td> Status </td>
       <td> Sortowanie  </td>
       <td> Pojazd </td>
       <td> Wyślij  </td>
		<tr class="tr1">
		<td style="width: 80px;">Do</td>
		    <td>
                        <?
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
	                           <?
			                                   $www->SelectFromArray($miesiace,"do_miesiac", $_POST[do_miesiac]);
		                           ?>
			                   </td>
					              <td style="width: 20px;">
			                              <?
                                      $www->SelectFromArray($dni,"do_dzien", $_POST[do_dzien]);
				                              ?>
			                    </td>
			                    
				    <td style="width: 200px;">
                        		<?
                                            $zatwierdzona=array("Zatwierdzone", "Niezatwierdzone");
                                           $www->SelectFromArray($zatwierdzona,"zatwierdzona", $_POST[zatwierdzona]);
                                       ?>
                                     </td>
                            	    <td style="width: 200px;">
	                            <?
                            		    $order=array("Data", "Cel");
					$www->SelectFromArray($order,"order", $_POST[order]);
	                        ?>
	                </td>
					            <td style="width: 200px;">
                           <?
                        		Select($Q14, $name='pojazd', $_POST[pojazd], $oth='')
		                          //$ida=SelectWlasc("abon", $_POST[abon]);
			    ?>
			                    </td>
	                <td style="width: 200px;">
                            <input type="submit" class="button1" value="Filtruj" name="przycisk">
	                    </td>
		        </tr>
  </tbody>
  </table>
  </form>

  <form method="POST" action="index.php?panel=fin&menu=updatejzd">
  <table style="text-align: left; width: 750px; height: 60px;" class="tbk1">
    <tbody>		
	<tr class="tr1">
      <td style="width: 90px;">
      	Id
      </td>
      <td style="width: 100px;">
      	Data wyjazdu      	
      </td>
    <td style="width: 300px;">
      	Opis trasy wyjazdu
      </td>
      <td style="width: 200px;">
      	Cel wyjazdu
    </td>
      <td style="width: 50px; ">
      	Km
      </td>
      <td style="width: 20px;">
	Usuń
      </td>
    </tr>

    <?
	ListaJazd($param);
    ?>
	<tr>
    	<td class="klasa1" colspan="8">
	    <input type="submit" class="button1" value="Uaktualnij >>>" name="przycisk">
	</td>
	</tr>
  </tbody>
</table>
</form>
<br/>
