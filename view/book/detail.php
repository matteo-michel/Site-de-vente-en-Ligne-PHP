<?php
    echo $book[0]->get('isbn') . " | " . $book[0]->get('titre') . " | " . $book[0]->get('prix') . " | " . $book[0]->get('numEditeur');
    echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=book&action=update&isbn=" . rawurlencode($book[0]->get('isbn')) . "\">Modifier le livre</a>";
?>