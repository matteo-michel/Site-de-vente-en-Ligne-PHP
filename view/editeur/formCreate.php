<form method="post" action="index.php?controller=editeur" class="login">
    <fieldset>
        <legend>Ajouter un Editeur :</legend>
        <div class="form-group">
            <?php $controller = static::$object; ?>

            <input type='hidden' name='action' value='<?php echo $name ?>'>

            <label for="nomEditeur_id">Nom éditeur</label> :
            <input type="text"  name="nomEditeur" id="nomEditeur_id" required/>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
    </fieldset>
</form>
