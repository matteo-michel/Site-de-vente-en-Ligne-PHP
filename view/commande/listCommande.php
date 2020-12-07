<?php
$tab = array_reverse($tab);
foreach ($tab as $u) {
    $listeBookByNumCommande = ModelBookCommande::select($u->get('numCommande'));
    echo '<p>Pour la date du ' . $u->get('date') . '</p>';
    $prixTotal = 0;
    if (!$listeBookByNumCommande)
    {
        echo '<p> Les elements de cette commande n\'existent plus ! </p>';
    } else {
        foreach ($listeBookByNumCommande as $book) {
            $livreCommande = ModelBook::select($book->get('isbn'))[0];
            $resultAuteur = "";
            $auteurs = ModelAuteur::getBookAuteurs($livreCommande->get('isbn'));
            foreach ($auteurs as $a) {
                $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
            }
            $resultAuteur = rtrim($resultAuteur, ', ');
            echo '<div class="livre">';
            echo '<img src="../../ressource/linux.png">';
            echo '<div class="bookInfo">';
            echo '<p>Titre : ' . $livreCommande->get("titre") . '</p>';
            echo '<p> Auteurs : ' . $resultAuteur . '</p>';
            echo '<p> Quantite : ' . $book->get('quantite') . '</p>';
            echo '<p> Livre de numéro : <a href="index.php?=actionread&isbn=' . rawurlencode($livreCommande->get('isbn')) . '">' . htmlspecialchars($livreCommande->get('isbn')) . '</a></p>';
            echo '</div>';
            echo '<div class="panier">';
            echo '</div>';
            echo '</div>';
            $prixTotal = $prixTotal + $livreCommande->get('prix') * $book->get('quantite');
        }
        echo '<p>Le prix total de la commande est : ' . $prixTotal . ' €</p>';

    }
}