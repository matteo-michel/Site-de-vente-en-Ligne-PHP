<form method="post" action="index.php">
  <fieldset>
    <legend>Mon formulaire :</legend>
    <p>
    <?php $controller = static::$object; ?>
    <input type='hidden' name='action' value='<?php echo $name ?>'>
      <label for="login_id">Login</label> :
      <input type="text"  name="login" id="login_id" required/>

      <label for="password_id">Mot De Passe</label> :
      <input type="password"  name="password" id="password_id" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères, 
      une lettre majuscule, minuscule et un chiffre" required/>

      <label for="prenom_id">Prenom</label> :
      <input type="text"  name="prenom" id="prenom_id" required/>

      <label for="nom_id">Nom</label> :
      <input type="text"  name="nom" id="nom_id" required/>

      <label for="email_id">Email</label> :
      <input type="email"  name="email" id="email_id" required/>

      <label for="isAdmin_id">Admin</label> :
      <input type="checkbox"  name="isAdmin" id="isAdmin_id"/>
    </p>
    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>