<form method="post" action="index.php?controller=auteur">
    <fieldset>
        <legend>Ajouter un Auteur:</legend>
        <p>
            <?php $controller = static::$object; ?>

            <input type='hidden' name='action' value='<?php echo $name ?>'>

            <label for="prenomAuteur_id">prenom auteur</label> :
            <input type="text"  name="prenomAuteur" id="prenomAuteur_id" required/>

            <label for="nomAuteur_id">nom auteur</label> :
            <input type="text"  name="nomAuteur" id="nomAuteur_id" required/>

        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
