<!DOCTYPE html>
<html>
	<head>
		<style>
			select{
				
			}
			
			input[type='submit']{
				border: none; 
				margin-top: 20px;
				color: #39dcdc; 
				border: 1px solid #39dcdc; 
				background: white; 
				padding: 5px 0px;
				border-radius: 4px;
				width: 100px;
			}
			
			input[type='submit']:hover{
				
				background: #39dcdc; 
				color: white; 
				cursor: pointer; 
				transition: 0.4s;
			}
			
			.form-group{
				clear: both;
				margin: 10px 0px;
				overflow:hidden;
			}
		</style>
	</head>
	<body>
		<h1>Date de naissance</h1>
		<form method="post" action="">
			<div class="form-group">
				<label>Date de naissance</label><br/>
				
				<select name="jours">
					<?php
					for($i=1; $i <= 31; $i++){
						echo '<option>' . substr('0'.$i, -2) . '</option>';
					}
					?>
				</select>
				
				
				
				<select name="mois">
					<?php
					$mois = array(
						'01' => 'Janvier',
						'02' => 'Février',
						'03' => 'Mars',
						'04' => 'Avril',
						'05' => 'Mai',
						'06' => 'Juin',
						'07'=> 'Juillet',
						'08' => 'Aout',
						'09' => 'Septembre',
						'10' => 'Octobre',
						'11' => 'Novembre',
						'12' => 'Décembre',
					);					
					foreach($mois as $indice => $valeur){
						echo '<option value="' . $indice . '">' . $valeur . '</option>'; 
					}
					?>
				</select>
				<select name="annees">
					<?php
					$i = date('Y');
					while($i >= 1900){
						echo '<option>' . $i . '</option>';
						$i --;
					}
					?>
				</select><br/>
				<input type="submit" value="Envoyer" />
			</div>
			
			
			
		</form>
	</body>
</html>