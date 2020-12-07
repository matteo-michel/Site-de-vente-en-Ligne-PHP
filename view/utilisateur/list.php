<?php
echo '<div class="home-content">';
foreach ($tab as $u){
    $uLogin = $u->get('login');
    echo '<div class="livre">';
    echo '<div class="bookInfo">';
    echo '<p> Utilisateur de login : <a href="index.php?controller=utilisateur&action=profile&login=' . rawurlencode($uLogin) . '">' . htmlspecialchars($uLogin) . '</a></br>';
    echo '</div>';
    if(isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1') {
        echo '<div class="panier">';
        echo "<a class='btn btn-primary' href=\"index.php?controller=utilisateur&action=update&login=" . rawurlencode($uLogin) . "\"><i class='fas fa-pen'></i> Modifier</a>";
        echo "<a class='btn btn-danger' role='button' href=\"index.php?controller=utilisateur&action=delete&login=" . rawurlencode($uLogin) . "\"><i class=\"fas fa-times\"></i> Supprimer le compte</a>";
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}