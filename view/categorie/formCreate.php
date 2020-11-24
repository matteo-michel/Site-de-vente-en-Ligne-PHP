<form method="post" action="index.php?controller=categorie" class="login">
    <fieldset>
        <legend>Ajouter une Catégorie :</legend>
        <div class="form-group">
            <?php $controller = static::$object; ?>

            <input type='hidden' name='action' value='<?php echo $name ?>'>
            <input type='hidden' name='numCategorie' value='<?php echo $numCategorie?>'>

            <label for="nomCategorie_id">Nom catégorie</label> :
            <input type="text"  name="nomCategorie" id="nomCategorie_id" required/>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
    </fieldset>
</form>
