<div class="content">
    <form method="post" action="index.php?controller=utilisateur" class="login">
        <fieldset>
        <legend>S'inscrire :</legend>
        <div class="form-group">
            <?php $controller = static::$object; ?>
            <input type='hidden' name='action' value='<?php echo $name ?>'>
            <label for="login_id">Login</label> :
            <input type="text"  name="login" id="login_id" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="password_id">Mot De Passe</label> :
            <input type="password"  name="password" id="password_id" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères,
            une lettre majuscule, minuscule et un chiffre" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="prenom_id">Prenom</label> :
            <input type="text"  name="prenom" id="prenom_id" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="nom_id">Nom</label> :
            <input type="text"  name="nom" id="nom_id" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="email_id">Email</label> :
            <input type="email"  name="email" id="email_id" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="isAdmin_id">Admin</label> :
            <input type="checkbox"  name="isAdmin" id="isAdmin_id"/>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
      </fieldset>
    </form>
</div>