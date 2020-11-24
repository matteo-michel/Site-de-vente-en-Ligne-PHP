<a href="index.php?controller=editeur&action=create">Ajouter un editeur</a>
<?php
$tab = ModelEditeur::selectAll(';');

foreach ($tab as $t)
{
    echo '<p> Editeur : '.$t->get('nomEditeur').'</p>';
    echo '<a href="index.php?controller=editeur&action=delete&numEditeur='.rawurlencode($t->get('numEditeur')).'">Supprimer</a>';
    echo '<a href="index.php?controller=editeur&action=update&numEditeur='.rawurlencode($t->get('numEditeur')).'">Modifier</a>';
}
?>