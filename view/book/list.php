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

<?php
    $order_by = ';';
    if (isset($_POST['book']) && $_POST['book'] != '') {
        $order_by = 'ORDER BY ' . $_POST['book'];
        $tab = ModelBook::selectAll($order_by);
    } else if (isset($_POST['search']) && $_POST['search'] != '') {
        $q_array = explode(' ', $_POST['search']);
        $tab = array();
        foreach ($q_array as $q) {
            $listNewBook = ModelBook::getBookByAutors($q);
            foreach ($listNewBook as $nb) {
                $in_array = false;
                foreach ($tab as $t) {
                    if ($t->get('isbn') == $nb->get('isbn')) $in_array = true;
                }
                if (!$in_array) array_push($tab, $nb);
            }
        }
    } else
    {
        $tab = ModelBook::selectAll($order_by);
    }


    foreach ($tab as $u){
        $bISBN = $u->get('isbn');
        $resultAuteur = "";
        $auteurs = ModelAuteur::getBookAuteurs($bISBN);

        foreach ($auteurs as $a) {
            $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
        }

        echo '<p> Auteurs : '. $resultAuteur .'</p>';
        echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a>'. " " . $u->get('titre') . '</p>';
    }
?>
