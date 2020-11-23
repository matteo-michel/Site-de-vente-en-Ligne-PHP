<?php
    $compteurPrix = 0;
    if(empty($tab)) {
        echo 'Le panier est vide !';
    } else {
        foreach ($tab as $t){
            $livre = ModelBook::select($t->get('isbn'))[0];
            $bISBN = $livre->get('isbn');
            $resultAuteur = "";
            $auteurs = ModelAuteur::getBookAuteurs($bISBN);

            foreach ($auteurs as $a) {
                $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
            }

            echo '<p> Auteurs : '. $resultAuteur .'</p>';
            echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a>'. " " . $livre->get('titre') . '</p>';
            echo '<p> Quantité : '. $t->get('quantite') .'</p>';
            echo '<p> Prix : '. $livre->get('prix')*$t->get('quantite') . '€' .  '</p>';

            echo "<p><a href=\"index.php?controller=panier&action=delete&isbn=" . rawurlencode($bISBN) . "\">Supprimer du panier</a></p>";
            $compteurPrix = $compteurPrix + ($livre->get('prix')*$t->get('quantite'));
        }

        echo 'Le prix total de la commande est de :' . $compteurPrix . '€';
        echo '<p><a href="index.php?controller=panier&action=acheterPanier">Passer la commande</a></p>';
        echo '<p><a href="index.php?controller=panier&action=clear">Vider le panier</a></p>';
    }