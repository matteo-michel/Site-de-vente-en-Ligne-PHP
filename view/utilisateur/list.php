<?php
foreach ($tab as $u){
    $uLogin = $u->get('login');
    echo '<p> Utilisateur de login : <a href="index.php?controller=utilisateur&action=profile&login=' . rawurlencode($uLogin) . '">' . htmlspecialchars($uLogin) . '</a></br>';
    if(isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1') {
        echo "<a href=\"index.php?controller=utilisateur&action=delete&login=" . rawurlencode($uLogin) . "\">Supprimer le compte</a>";
    }
}