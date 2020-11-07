<form method="post" action="index.php">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <?php $controller = static::$object; ?>
            <input type='hidden' name='action' value='<?php echo $name ?>'>

            <label for="isbn_id">ISBN</label> :
            <input type="text"  name="isbn" id="isbn_id" required/>

            <label for="titre_id">Titre</label> :
            <input type="text"  name="titre" id="titre_id" required/>

            <label for="numEditeur_id">Nom Editeur</label> :
            <select name="numEditeur" id="numEditeur_id" required>
                <?php
                $listEditeur = ModelEditeur::selectAll(";");
                foreach ($listEditeur as $item) {
                        echo "<option value=\"" . $item->get('numEditeur') . "\">" . $item->get('nomEditeur') . "</option>";
                    }
                ?>
            </select>
            <a href="">Ajouter un Editeur</a>

            <label for="numAuteur_id">Nom Auteur</label> :
            <select name="numAuteur[]" id="numAuteur_id" multiple required>
                <?php
                $listAuteur = ModelAuteur::selectAll(";");
                foreach ($listAuteur as $item) {
                    echo "<option value=\"" . $item->get('numAuteur') . "\">" . $item->get('prenomAuteur') . ",". $item->get('nomAuteur') . "</option>";
                }
                ?>
            </select>
            <a href="">Ajouter un Auteur</a>

            <label for="categorie_id">Categorie</label> :
            <select name="numCategorie[]" id="categorie_id" multiple required>
                <?php
                $listCategorie = ModelCategorie::selectAll(";");
                var_dump($listCategorie);
                foreach ($listCategorie as $item) {
                    echo "<option value=\"" . $item->get('numCategorie') . "\">" . $item->get('nomCategorie') . "</option>";
                }
                ?>
            </select>
            <a href="">Ajouter une Catégorie</a>

            <label for="prix_id">Prix</label> :
            <input type="number"  name="prix" id="prix_id" required/>

            <label for="date_id">dateParution</label> :
            <input type="date"  name="date" id="date_id" required/>

            <label for="resume_id">Resume</label> :
            <input type="text"  name="resume" id="resume_id"/>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
