<div class="content">
    <form method="post" action="index.php?controller=utilisateur" class="login">
        <fieldset>
        <legend>Changer de Mot de Passe :</legend>
            <div class="form-group">
                <?php $controller = static::$object; ?>
                <input type='hidden' name='action' value='<?php echo $name ?>'>
                <label for="old_passsword">Ancien Mot de passe</label> :
                <input type="password" name="old_passsword" id="old_passsword" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau Mot De Passe</label> :
                <input type="password" name="new_password" id="new_password" class="form-control" required/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div>