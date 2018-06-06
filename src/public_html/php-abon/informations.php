
<table style="width : 400px;" class="tbk3">
  <tbody>
    <tr>
      <td class="klasa1" colspan="2">
			 <strong>Dane komputera z którego się podłączono</strong> 
		</td>
	 </tr>
    <tr>
      <td style="width : 100px;"> Przeglądarka </td>
      <td>
			<?php
				echo $_SERVER[HTTP_USER_AGENT];
			?>
		</td>
    </tr>
    <tr>
      <td> Adres IP </td>
      <td>
			<?php
				echo $_SERVER[REMOTE_ADDR];
			?>

		</td>
    </tr>
    <tr>
      <td> Nazwa hosta </td>
      <td>
			<?php
				echo $_SERVER[REMOTE_HOST];
			?>

		</td>
    </tr>
  </tbody>
</table>
