<a href="index.php?controller=categorie&action=create">Ajouter une categorie</a>
<?php
$tab = ModelCategorie::selectAll(';');

foreach ($tab as $t)
{
    echo '<p> Categorie : '.$t->get('nomCategorie').'</p>';
    echo '<a href="index.php?controller=categorie&action=delete&numCategorie='.rawurlencode($t->get('numCategorie')).'">Supprimer</a>';
}
?>