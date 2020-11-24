<div class="content">
    <form method="post" action="index.php?controller=book" class="login" id="register">
        <fieldset>
            <legend>Modifier un livre :</legend>
            <div class="form-group">
                <?php $controller = static::$object; ?>
                <input type='hidden' name='action' value='<?php echo $name ?>'>
            </div>
            <div class="form-group">
                <label for="isbn_id">ISBN</label> :
                <input type="text" name="isbn" id="isbn_id" value='<?php echo $isbn ?>' required readonly/>
            </div>
            <div class="form-group">
                <label for="titre_id">Titre</label> :
                <input type="text" class="form-control" name="titre" id="titre_id" required/>
            </div>
            <div class="form-group">
                <label for="numEditeur_id">Nom Editeur</label> :
                <select name="numEditeur" id="numEditeur_id" required>
                    <?php
                    $listEditeur = ModelEditeur::selectAll(";");
                    foreach ($listEditeur as $item) {
                            echo "<option value=\"" . $item->get('numEditeur') . "\">" . $item->get('nomEditeur') . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="numAuteur_id">Nom Auteur</label> :
                <select class="custom-select" name="numAuteur[]" id="numAuteur_id" multiple required>
                    <?php
                    $listAuteur = ModelAuteur::selectAll(";");
                    foreach ($listAuteur as $item) {
                        echo "<option value=\"" . $item->get('numAuteur') . "\">" . $item->get('prenomAuteur') . " ". $item->get('nomAuteur') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categorie_id">Categorie</label> :
                <select name="numCategorie[]" class="custom-select" id="categorie_id" multiple required>
                    <?php
                    $listCategorie = ModelCategorie::selectAll(";");
                    var_dump($listCategorie);
                    foreach ($listCategorie as $item) {
                        echo "<option value=\"" . $item->get('numCategorie') . "\">" . $item->get('nomCategorie') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prix_id">Prix</label> :
                <input type="number" name="prix" id="prix_id" required/>
            </div>
            <div class="form-group">
                <label for="date_id">Date de Parution</label> :
                <input type="date" name="date" id="date_id" required/>
            </div>
            <div class="form-group">
                <label for="resume_id">Resumé</label> :
<!--                <input type="text"  name="resume" id="resume_id"/>-->
                <textarea id="resume_id"class="form-control" name = "resume" rows="3" cols="50" maxlength="1024"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div>