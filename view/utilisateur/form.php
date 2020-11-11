<form method="post" action="index.php">
  <fieldset>
    <legend>Connexion :</legend>
    <div class="form-group">
        <?php $controller = static::$object; ?>
        <input type='hidden' name='action' value='<?php echo $name ?>'>
        <label for="login_id">Login</label> :
        <input type="text"  name="login" id="login_id" class="form-control" required/>
    </div>
    <div class="form-group">
        <label for="password_id">Mot De Passe</label> :
        <input type="password"  name="password" id="password_id" class="form-control" required/>
    </div>
      <div class="text-center">
        <button type="submit" class="btn btn-success">Envoyer</button>
      </div>
  </fieldset> 
</form>