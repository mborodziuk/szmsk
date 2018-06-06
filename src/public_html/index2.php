<table  style="height : 1000px; width : 100%; horizontal-align=center;">
  <tbody >
    <tr>
				<td style="height: 60px;" class="klasa5" style=" horizontal-align=center;">
                                                <img src="<?php echo $conf[szmsk_logo] ?>"/>
				</td>
																	                 
				<td colspan="3" class="klasa7" style="horizontal-align=center;">

          <?php
					/*
							if (!isset($_SESSION['visits']))
							{
								$_SESSION['visits'] = 1;
							}
							else
							{
								$_SESSION['visits']++;
							}
*/

 
						if (    isset($_SESSION['id_abon']) )
              {
                echo "Zalogowany jako : "."<strong>".$_SESSION['login']."</strong>";
                echo "<br/> Pracownik : "."<strong>".$_SESSION['nazwa']."</strong>";
								//echo "Na systemie pracuje".$_SESSION['visits']." użytkowników";
								 
				        if ( ValidateAuth("'fin'",$_SESSION['login'],$_SESSION['haslo']) )
									{
										include("php/panel-fin.php");
										$_SESSION['uprawnienia']='fin';
									}
								else if ( ValidateAuth("'admin','fin'",$_SESSION['login'],$_SESSION['haslo']) )
                  {
                    include("php/panel-admin.php");
										$_SESSION['uprawnienia']='admin';
                  }
                else if ( ValidateAuth("'admin','fin','inst'",$_SESSION['login'],$_SESSION['haslo']) )
                  {
                   include("php/panel-inst.php");
										$_SESSION['uprawnienia']='inst';
                  }
									else if ( ValidateAuth("'admin','fin','inst', 'sprzedaz'",$_SESSION['login'],$_SESSION['haslo']) )
                  {
                   include("php/panel-sprzedaz.php");
										$_SESSION['uprawnienia']='sprzedaz';
                  }
									else if ( ValidateAuth("'admin','fin','inst', 'sprzedaz', 'callcenter'",$_SESSION['login'],$_SESSION['haslo']) )
                  {
                   include("php/panel-callcenter.php");
										$_SESSION['uprawnienia']='callcenter';
                  }
                else 
									{
										include("php/panel-abon.php");
										$_SESSION['uprawnienia']='abon';
									}
									
								switch ( $_GET["panel"] )
									{
										case "fin":
											if ( ValidateAuth("'fin'",$_SESSION['login'],$_SESSION['haslo']) )
												{  
													include("func/fin.php");
													include("php/menu-fin.php");
													include("php/php-menu-fin.php");
												}
												break;
																	
										case "admin":
											if ( ValidateAuth("'admin','fin'",$_SESSION['login'],$_SESSION['haslo']) )
												{
													include("func/admin.php");
													include("php/menu-admin.php");
													include("php/php-menu-admin.php");
												}
												break;
				
										case "inst":
											if ( ValidateAuth("'sprzedaz','inst', 'admin','fin', 'callcenter'",$_SESSION['login'],$_SESSION['haslo']) )
												{
													include("func/inst.php");		     
													include("php/menu-inst.php");
													include("php/php-menu-inst.php");
												}
												break;
										case "sprzedaz":
											if ( ValidateAuth("'sprzedaz', 'inst', 'admin','fin', 'callcenter'",$_SESSION['login'],$_SESSION['haslo']) )
												{
													include("func/inst.php");		     
													include("php/menu-sprzedaz.php");
													include("php/php-menu-sprzedaz.php");
												}
												break;

										case "callcenter":
											if ( ValidateAuth("'sprzedaz', 'inst', 'admin','fin', 'callcenter'",$_SESSION['login'],$_SESSION['haslo']) )
												{
													include("func/inst.php");		     
													include("php/menu-callcenter.php");
													include("php/php-menu-callcenter.php");
												}
												break;
							
										case "abon":
												if ( ValidateAuth("'abon' ,'sprzedaz', 'inst', 'admin','fin', 'callcenter'",$_SESSION['login'],$_SESSION['haslo']) )
												{
													include("func/abon.php");			     
													include("php/menu-abon.php");
													include("php/php-menu-abon.php");
												}
												break;
												
										default:
													include("func/abon.php");
													include("php/menu-abon.php");
													include("php/php-menu-abon.php"); 
													break;													         
									}
							}

							else 	
								switch ( $_GET["panel"] )
									{
									case NULL :
										include("func/auth.php");
										break;
									case "zaloguj" :
										include("func/auth.php");
										break;
									case "authwyslij" :
										if ( ValidateAuth("'abon','admin','fin','inst'",$_POST['login'],$_POST['haslo']) )
												include("php-fin/informations.php");
										else
												include("func/auth.php");
										break;
									default :
										include("func/auth.php");
										break;
									}
							?>
					</td>
    </tr>

    <tr>
      <td style="width: 157px;">
       <img src="graphics/logo.jpg"/>
      </td>
      <td colspan="1" rowspan="1" style="height: 50px;"> SZMSK ver. 0.16.02  Copyright &copy; 2005-2016 by Mirosław Borodziuk
      </td>
    </tr>
  </tbody>
</table>

