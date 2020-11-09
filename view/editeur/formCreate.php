<form method="post" action="index.php?controller=editeur">
    <fieldset>
        <legend>Ajouter un Editeur:</legend>
        <p>
            <?php $controller = static::$object; ?>

            <input type='hidden' name='action' value='<?php echo $name ?>'>

            <label for="nomEditeur_id">nom editeur</label> :
            <input type="text"  name="nomEditeur" id="nomEditeur_id" required/>

        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
