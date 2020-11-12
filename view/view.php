<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>

        <link rel="stylesheet" href="../assets/bootstrap.min.css">
        <link rel="stylesheet" href="../CSS/form.css">
        <link rel="stylesheet" href="../CSS/home.css">
        <link rel="stylesheet" href="../CSS/profil.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <script src="../assets/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/29189c846f.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <ul class="navbar-nav mr-auto">
            <a href="index.php" class="navbar-brand">Book'Sell</a>
<!--            <ul class="nav navbar-nav navbar-form">-->
<!--                <form method="post" action="index.php">-->
<!--                    <select name="book" id="book_id">-->
<!--                        <option value="">--Trier les livres--</option>-->
<!--                        <option value="isbn">numéro ISBN</option>-->
<!--                        <option value="titre">Titre</option>-->
<!--                        <option value="prix">Prix</option>-->
<!--                        <option value="dateParution">date de Parution</option>-->
<!--                    </select>-->
<!--                    <input type="text" name="search">-->
<!--                    <input type="submit" value="Rechercher">-->
<!--                </form>-->
<!--            </ul>-->
                <?php
                if (!isset($_SESSION['login'])) {
                    echo "</ul>";
                    echo "<ul class=\"nav navbar-nav navbar-\">
                      <li class=\"nav-item\"><a href=\"index.php?controller=utilisateur&action=panier\" class=\"nav-link\"><i class=\"fas fa-shopping-cart\"></i> Mon panier</a></li>
                      <li><a href=\"index.php?controller=utilisateur&action=register\" class=\"nav-link\"><i class=\"fas fa-user\"></i> S'inscrire</a></li>
                      <li><a href=\"index.php?controller=utilisateur&action=login\" class=\"nav-link\"><i class=\"fas fa-sign-in-alt\"></i> Se Connecter</a></li>
                      </ul>";
                } else
                {
                    echo "<li class = \"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" href\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                          <i class=\"fas fa-tachometer-alt\"></i> Panel Administrateur
                         </a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">
                          <a class=\"dropdown-item\" href=\"index.php?controller=utilisateur\">Liste d'utilisateur</a>
                          <a class=\"dropdown-item\" href=\"index.php?controller=editeur\">Liste d'éditeur</a>
                          <a class=\"dropdown-item\" href=\"index.php?controller=categorie\">Liste de catégorie</a>
                          <a class=\"dropdown-item\" href=\"index.php?controller=auteur\">Liste d'auteur</a>
                          <a class=\"dropdown-item\" href=\"index.php?action=create\">Ajouter un livre</a>
                        </div></li>";
                    echo "</ul>";

                    echo "<ul class=\"nav navbar-nav navbar-right\">
                      <li class=\"nav-item\"><a href=\"index.php?controller=utilisateur&action=panier\" class=\"nav-link\"><i class=\"fas fa-shopping-cart\"></i> Mon panier</a></li>
                      <li><a href=\"index.php?controller=utilisateur&action=profile\" class=\"nav-link\"><i class=\"fas fa-user\"></i> Mon profile</a></li>
                      <li><a href=\"index.php?controller=utilisateur&action=logout\" class=\"nav-link\"><i class=\"fas fa-sign-out-alt\"></i> Deconnexion</a></li>
                      </ul>";
                }
                ?>
            </ul>
        </nav>
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