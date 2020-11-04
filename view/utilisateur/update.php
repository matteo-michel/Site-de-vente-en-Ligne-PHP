<form method="post" action="index.php">
<fieldset>
<legend>Modifer voiture :</legend>
    <input type='hidden' name='action' value='<?php echo $name ?>'>

    <label for="login_id">Login</label> :
    <input type="text"  name="login" id="login_id" value = "<?php echo $user->get('login'); ?>" required readonly/>

    <label for="prenom_id">Prenom</label> :
    <input type="text"  name="prenom" id="prenom_id" value = "<?php echo $user->get('prenom'); ?>" required/>

    <label for="nom_id">Nom</label> :
    <input type="text"  name="nom" id="nom_id" value = "<?php echo $user->get('nom'); ?>" required/>

    <label for="email_id">Email</label> :
    <input type="email"  name="email" id="email_id" value = "<?php echo $user->get('email'); ?>" required/>
    <p>
        <input type="submit" value="Envoyer" />
    </p>
</fieldset> 
</form>
