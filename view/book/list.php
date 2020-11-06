<form>
    <select name="book" id="book_id">
        <option value="">--Trier les livres--</option>
        <option value="isbn">numéro ISBN</option>
        <option value="titre">Titre</option>
        <option value="prix">Prix</option>
        <option value="dateParution">date de Parution</option>
    </select>
</form>
<?php
$tab_v = ModelBook::selectAll();
foreach ($tab_v as $u){
    $bISBN = $u->get('isbn');
    echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></br>';
}
?>
