<?php
    $compteurPrix = 0;
    if(empty($tab)) {
        echo 'Le panier est vide !';
    } else {
        echo '<div class="home-content">';
        foreach ($tab as $t){
            $livre = ModelBook::select($t->get('isbn'))[0];
            $bISBN = $livre->get('isbn');
            $resultAuteur = "";
            $auteurs = ModelAuteur::getBookAuteurs($bISBN);

            foreach ($auteurs as $a) {
                $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
            }

            echo '<div class="livre">';
            echo '<div class="bookInfo">';
            echo '<p> Auteurs : '. $resultAuteur .'</p>';
            echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a>'. " " . $livre->get('titre') . '</p>';
            echo '<p> Quantité : '. $t->get('quantite') .'</p>';
            echo '<p> Prix : '. $livre->get('prix')*$t->get('quantite') . '€' .  '</p>';
            echo '</div>';
            echo '<div class="panier">';
            echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=panier&action=delete&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-times\"></i> Supprimer du panier</a>";
            echo '</div>';
            echo '</div>';
            $compteurPrix = $compteurPrix + ($livre->get('prix')*$t->get('quantite'));
        }
        echo '<div>';

        echo '<div class="panier-info">';
        echo 'Le prix total de la commande est de : ' . $compteurPrix . '€';
        echo '<a class="btn btn-success" href="index.php?controller=panier&action=acheterPanier">Passer la commande</a>';
        echo '<a class="btn btn-danger" href="index.php?controller=panier&action=clear">Vider le panier</a>';
        echo '</div>';
    }