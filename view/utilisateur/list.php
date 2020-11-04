<?php
foreach ($tab_v as $u){
    $uLogin = $u->get('login');
    echo '<p> Utilisateur de login : <a href="">' . htmlspecialchars($uLogin) . '</a></br>';
}
?>