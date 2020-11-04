<?php
    $login = $_SESSION['login'];
    $user = modelUtilisateur::select($login);
    echo $user->get('login') . " | " . $user->get('nom') . " | " . $user->get('prenom') . " | " . $user->get('email');
    echo "<a href=\"index.php?action=update\">Modifier mon profil</a>";
?>