<?php 

echo '<pre>'; 
print_r($_POST);
echo '</pre>'; 

if($_POST){
	
	foreach($_POST as $indice => $valeur){
		
		if($indice == 'cp'){
			echo 'Code Postal : <strong>' . $valeur . '</strong><br/>';
		}
		else{
			echo ucfirst(str_replace('_', ' ', $indice)) . ' : <strong>' . $valeur . '</strong><br/>';
		}
		//strtoupper() => tout en majuscule
		//strtolower() => tout en minuscule
		//ucfirst()    => première lettre en maj
		
		//str_replace() => remplacer dans une CC un caractere par un autre. 
		// 1er arg : Le caractere à remplacer
		// 2eme arg : Le remplacant
		// 3eme arg : La CC
	}
}



?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			label{
				float: left;
				width:150px; 
			}
			
			input, textarea{
				float: left;
				width:220px; 
			}
			
			input[type='submit']{
				margin-left: 150px;
				border: none; 
				color: #39dcdc; 
				border: 1px solid #39dcdc; 
				background: white; 
				padding: 5px 0px;
				border-radius: 4px;
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
			
			textarea{
				resize: none;
				height: 80px; 
			}
		</style>
	</head>
	<body>
		<h1>Formulaire</h1>
		<form method="post" action="">
			<div class="form-group">
				<label>Nom</label>
				<input type="text" name="nom" />
			</div>
		
			<div class="form-group">
				<label>Prénom</label>
				<input type="text" name="prenom" />
			</div>
			
			<div class="form-group">
				<label>Adresse</label>
				<input type="text" name="adresse" />
			</div>
		
			<div class="form-group">
				<label>Code Postal</label>
				<input type="text" name="code_postal" />
			</div>
			
			<div class="form-group">
				<label>Sexe</label>
				<select name="sexe">
					<option value="m">Homme</option>
					<option value="f">Femme</option>
				</select>
			</div>
			
			<div class="form-group">
				<label>Description</label>
				<textarea name="description"></textarea>
			</div>
			
			<input type="submit" value="Envoyer" />
			
		</form>
	</body>
</html>