<?php
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $testQuantite = true;
        foreach ($panier as $item)
        {
            $quantite = $item->get('quantite');
            $itemQuantite = ModelBook::select($item->get('isbn'))[0]->get('stock');
            if ($quantite > $itemQuantite) {
                echo "<p>Il n'y pas assez de produit en stock pour le livre de numéro : " . $item->get('isbn') . "</p>";

                $testQuantite = false;
            }
        }
        if ($testQuantite)  echo '<p><a href="index.php?controller=panier&action=acheterPanier_end">Valider la transaction</a></p>';
        else echo '<p><a href="index.php?controller=panier&action=readAll">Retour au panier</a></p>';
