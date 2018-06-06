<?php

class IMAGE
{
	

	function ImagePrint($id_dok, $dok)
	{
		include "../func/config.php";
		
		switch ($dok)
		{
			case termination:
				$q="select obraz from wypowiedzenia_umow_abonenckich where id_wyp = '$id_dok'";
				break;
			case complaint:
				$q="select image from complaint where id_cpl = '$id_dok'";
				break;
			case inltr:
				$q="select obraz from pisma_przychodzace where id_psp = '$id_dok'";
				break;
		}

	 $conn = pg_pconnect("dbname=$DBNAME1 user=$USER password=$PASS");
	 $rs = pg_exec($conn, $q);
	 $row = pg_fetch_row($rs,0);
	 pg_query ($conn, "begin");
   $loid = pg_lo_open($conn,$row[0], "r");
   pg_lo_read_all ($loid);
   pg_lo_close ($loid);
	 pg_query ($conn, "commit"); //OR END
	 pg_close(); 
 }

}

?>
