<form method="post" action="index.php?controller=categorie">
    <fieldset>
        <legend>Ajouter une Catégorie:</legend>
        <p>
            <?php $controller = static::$object; ?>

            <input type='hidden' name='action' value='<?php echo $name ?>'>

            <label for="nomCategorie_id">nom categorie</label> :
            <input type="text"  name="nomCategorie" id="nomCategorie_id" required/>

        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
