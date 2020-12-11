<?php
echo "<p>Livres écris par " . ucfirst($auteur->get('prenomAuteur')) . " " . ucfirst($auteur->get('nomAuteur')) . ":</p>";
echo '<div class="home-content">';
foreach ($books as $b) {
    $bISBN = $b->get('isbn');
    $resultAuteur = "";
    $auteurs = ModelAuteur::getBookAuteurs($bISBN);

    foreach ($auteurs as $a) {
        $resultAuteur = $resultAuteur . '<a href="index.php?controller=auteur&action=read&numAuteur=' . $a->get('numAuteur') . '">' . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . '</a>' . ", ";
    }

    $resultAuteur = rtrim($resultAuteur, ', ');

    echo '<div class="livre">';
    if(!$b->get('image')) {
        echo '<img src="../../ressource/linux.png"/>';
    } else {
        echo '<img src="data:image/jpeg;base64,'.base64_encode($b->get('image')).'"/>';
    }
    echo '  <div class="bookInfo">
                <p>Titre : '. $b->get("titre") . '</p>
                <p> Auteurs : '. $resultAuteur .'</p>
                <p> Stock : '. $b->get('stock') .'</p>
                <p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>
                </div>
                <div class="panier">
                <p>' . $b->get("prix") . '<sup>€</sup></p>';
    echo '</div></div>';
}
echo '</div>';