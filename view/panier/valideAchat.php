<?php
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $testQuantite = true;
        foreach ($panier as $item)
        {
            $quantite = $item->get('quantite');
            $itemQuantite = ModelBook::select($item->get('isbn'))[0]->get('stock');
            if ($quantite > $itemQuantite) {
                echo "<div class='alert alert-danger'>Il n'y pas assez de produit en stock pour le livre de numéro : " . $item->get('isbn') . "</div>";

                $testQuantite = false;
            }
        }
//        if ($testQuantite)  echo '<p><a href="index.php?controller=panier&action=acheterPanier_end">Valider la transaction</a></p>';
        if ($testQuantite) {
            controllerPanier::acheterPanier_end();
        }
        else {
            echo '<a role="button" class="btn btn-danger" href="index.php?controller=panier&action=readAll">Retour au panier</a>';
            //header('Location: index.php?controller=panier&action=readAll');
            //echo "<div class='alert alert-danger'>La commande n'a pas pu être validée ! </div>";
        }
