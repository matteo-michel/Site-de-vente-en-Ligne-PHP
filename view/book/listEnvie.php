<?php
foreach ($tab as $u){
    $bISBN = $u->get('isbn');
    $resultAuteur = "";
    $auteurs = ModelAuteur::getBookAuteurs($bISBN);

    foreach ($auteurs as $a) {
        $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
    }

    echo '<div class="livre">';
    echo '<img src="../../ressource/linux.png">';
    echo '<div class="bookInfo">';
    echo '<p>Titre : '. $u->get("titre") . '</p>';
    echo '<p> Auteurs : '. $resultAuteur .'</p>';
    echo '<p> Stock : '. $u->get('stock') .'</p>';
    echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>';
    echo '</div>';
    echo '<div class="panier">';
    echo '<p>' . $u->get("prix") . '<sup>€</sup></p>';
    if ($u->get('stock') == 0)
    {
        echo '<p id="stock"> Rupture de stock </p>';
    } else {
        echo "<a class='btn btn-primary' role='button' href=\"index.php?controller=utilisateur&action=addPanier&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-shopping-basket\"></i>  Ajouter au panier</a>";
    }
        echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=book&action=ajouterListeEnvie&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-times\"></i>  Supprimer de la liste d'envie</a>";
    echo '</div>';
    echo '</div>';
}