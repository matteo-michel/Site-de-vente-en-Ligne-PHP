<form method="post" action="index.php">
  <fieldset>
    <legend>Mon formulaire :</legend>
    <p>
    <?php $controller = static::$object; ?>
    <input type='hidden' name='action' value='<?php echo $name ?>'>
      <label for="login_id">Login</label> :
      <input type="text"  name="login" id="login_id" required/>

      <label for="password_id">Mot De Passe</label> :
      <input type="password"  name="password" id="password_id" required/>
    </p>
    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>