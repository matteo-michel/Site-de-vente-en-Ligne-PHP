<div class="recherche">
    <form method="post" action="index.php">
        <select name="book" id="book_id">
            <option value="">--Trier les livres--</option>
            <option value="isbn">numéro ISBN</option>
            <option value="titre">Titre</option>
            <option value="prix">Prix</option>
            <option value="dateParution">date de Parution</option>
        </select>
        <input type="text" name="search">
        <input type="submit" value="Rechercher">
    </form>
</div>

<?php
    $order_by = '';
    if (isset($_POST['book']) && $_POST['book'] != '') {
        $order_by = 'ORDER BY ' . $_POST['book'];
        $tab = ModelBook::selectAll($order_by);
    } else if (isset($_POST['search']) && $_POST['search'] != '') {
        $q_array = explode(' ', $_POST['search']);
        $tab = array();
        foreach ($q_array as $q) {
            $listNewBook = ModelBook::getBookByAutors($q);
            if (empty($listNewBook)) echo "Il n’y a aucun résultat pour votre recherche. Vérifiez l’orthographe des mots saisis, complétez-les par un nouveau mot clé ou désactivez les filtres actifs";
            else {
                foreach ($listNewBook as $nb) {
                    $in_array = false;
                    foreach ($tab as $t) {
                        if ($t->get('isbn') == $nb->get('isbn')) $in_array = true;
                    }
                    if (!$in_array) array_push($tab, $nb);
                }
            }
        }
    } else
    {
        $start = 0;
        if(isset($_GET['page'])) {
            $start = 10 * $_GET['page'] - 10;
        }
        $tab = ModelBook::selectAmount($order_by, $start,10);
    }

    echo '<div class="home-content">';
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
        echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>';
        echo '</div>';
        echo '<div class="panier">';
        echo '<p>' . $u->get("prix") . '<sup>€</sup></p>';
        echo "<a class='btn btn-primary' role='button' href=\"index.php?controller=utilisateur&action=addPanier&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-shopping-basket\"></i>  Ajouter au panier</a>";
        echo '</div>';
        echo '</div>';
    }
    echo '<div>';
    echo "<ul class=\"pagination text-center\">";
    for ($i = 1; $i <= floor(ModelBook::getAmount()/10)+1; $i++) {
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=".$i."\">$i</a></li>";
    }
    echo "</ul>";
?>
