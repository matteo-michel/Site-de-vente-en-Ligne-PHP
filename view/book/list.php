<?php
foreach ($tab_v as $u){
    $bISBN = $u->get('isbn');
    echo '<p> Livre de numéro : <a href="">' . htmlspecialchars($bISBN) . '</a></br>';
}
?>
