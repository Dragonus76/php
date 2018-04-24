<?php

/*
echo '<pre>';
print_r($_POST)
;echo '</pre>';
*/

$mois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');


?>


<h1>Mission 2</h1>

<form method="post" action="">

	<label>Jour</label>
	<select name="jour">
		<?php
		for($j = 1; $j<=31; $j ++){
			echo '<option>' . $j . '</option>';
		}
		?>
	</select>
	
	<label>Mois</label>
	<select name="mois">
		<?php
		foreach($mois as $valeur){
			echo '<option>' . $valeur . '</option>';
		}
		?>	
	</select>
	
	<label>Année</label>
	<select name="année">
		<?php
		for($a = date('Y'); $a>=1900; $a --){
			echo '<option>' . $a . '</option>';
		}
		?>
	</select>
	
	<input type="submit" value="Envoi">

</form>