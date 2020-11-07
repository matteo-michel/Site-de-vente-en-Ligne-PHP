<?php
    if(empty($tab)) {
        echo 'Le panier est vide !';
    }
    foreach ($tab as $t){
        $livre = ModelBook::select($t);
        $bISBN = $livre->get('isbn');
        $resultAuteur = "";
        $auteurs = ModelAuteur::getBookAuteurs($bISBN);

        foreach ($auteurs as $a) {
            $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
        }

        echo '<p> Auteurs : '. $resultAuteur .'</p>';
        echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a>'. " " . $livre->get('titre') . '</p>';
        echo "<p><a href=\"index.php?controller=utilisateur&action=removeFromPanier&isbn=" . rawurlencode($bISBN) . "\">Supprimer du panier</a></p>";
    }