<!Doctype html>
<html>
    <head>
        <title>Mon Site - <?= $page ?></title>
        <link rel="stylesheet" href="<?= RACINE_SITE ?>css/style.css"/>
        <meta charset="utf-8">
        <meta name="descritpion" content="<?= $meta_description ?>">
    </head>
    <body>    
        <header>
			<div class="conteneur">                      
				<span>
					<a href="" title="Mon Site">MonSite.com</a>
                </span>
				<nav>

				<!-- On va rendre la nav dynamique selon que l'user est connecté ou non -->
					
					<?php if(userConnect()) : ?> <!-- si l'user est connecté : -->
					
						<!-- on propose les liens de profil et de déconnexion -->
						<a <?= ($page == 'Profil') ? 'class="active"' : '' ?> href="<?= RACINE_SITE ?>profil.php"><!-- ceci est la version racourcie d'un if, où '?' remplace les {} et ':' remplace else -->
						Profil</a>

						<a href="<?= RACINE_SITE ?>deconnexion.php">
						Déconnexion</a>

					
					<?php else : ?> <!-- si l'user n'est pas connecté : -->
						<a 
						<?= ($page == 'Inscription') ? 'class="active"' : '' ?> 
						href="<?= RACINE_SITE ?>inscription.php">
						Inscription</a>

						<a 
						<?= ($page == 'Connexion') ? 'class="active"' : '' ?> 
						href="<?= RACINE_SITE ?>connexion.php">
						Connexion</a>

					<?php endif; ?>

						<a 
						<?= ($page == 'Boutique') ? 'class="active"' : '' ?> 
						href="<?= RACINE_SITE ?>boutique.php">
						Boutique</a>

						<a 
						<?= ($page == 'Panier') ? 'class="active"' : '' ?> 
						href="<?= RACINE_SITE ?>panier.php">Panier</a>

					<!-- On vérifie si l'user est l'admin -->
					<?php if(userAdmin()) : ?>
						<a href="<?= RACINE_SITE ?>/backoffice/gestion_boutique.php">Gestion Boutique</a>
						<a href="<?= RACINE_SITE ?>/backoffice/gestion_membres.php">Gestion Membres</a>
						<a href="<?= RACINE_SITE ?>/backoffice/gestion_commandes.php">Gestion Commandes</a>
					<?php endif; ?>

				</nav>
			</div>
        </header>
        <section>
			<div class="conteneur">      