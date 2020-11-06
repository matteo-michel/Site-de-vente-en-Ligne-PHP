<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
    </head>
    <body>
        <header>
            <ul>
                <?php 
                echo "<li><a href=\"index.php\">Accueil</a></li>";
                if (!isset($_SESSION['login'])) {
                    echo "<li><a href=\"index.php?controller=utilisateur&action=register\">S'inscrire</a></li>";
                    echo "<li><a href=\"index.php?controller=utilisateur&action=login\">Se Connecter</a></li>";
                } else
                {
                    echo "<li><a href=\"index.php?controller=utilisateur&action=profile\">Mon profile</a></li>";
                    echo "<li><a href=\"index.php?controller=utilisateur\">Liste d'utilisateur</a></li>";
                    echo "<li><a href=\"index.php?controller=utilisateur&action=logout\">Deconnexion</a></li>";
                }
                ?>
            </ul>
        </header>
		<?php
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (5*60))) {
                 session_unset();
                 session_destroy();
            } else {
                $_SESSION['LAST_ACTIVITY'] = time();
            }
			$filepath = File::build_path(array("view", static::$object, "$view.php"));
			require $filepath;
		?>
    </body>
</html>