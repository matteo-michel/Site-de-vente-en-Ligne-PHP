<a href="index.php?controller=auteur&action=create">Ajouter un auteur</a>
<?php
$tab = ModelAuteur::selectAll(';');

foreach ($tab as $t)
{
    echo '<p> Auteur : '.$t->get('nomAuteur').' '.$t->get('prenomAuteur').'</p>';
    echo '<a href="index.php?controller=auteur&action=delete&numAuteur='.rawurlencode($t->get('numAuteur')).'">Supprimer</a>';
}
?>