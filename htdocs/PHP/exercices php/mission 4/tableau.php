<?php

$tab = array("tableau" => array(0 => "julien", 1 => "nicolas", 2 => "mathieu", 3 => "christelle", 4 => "nina", 5 => "johanna")); 


echo '<pre>';
print_r($tab);
echo '</pre>';

foreach($tab as $indice => $valeur){
	echo $valeur;
}


?>