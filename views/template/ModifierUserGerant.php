<br><br><br><div><form action='modifierUtilisateur' method='post'>
			Veuillez choisir le nouveau role
		<select name=changement>
		   <option valeur='membre'>membre</option>
			<option valeur='utilisateur'>utilisateur</option>
		</select>
		<?php $pk=$_POST['pk'] ; ?>
		<br>
		<input type='hidden' name='pk' value='<?php echo "$pk" ; ?>'>
		<input type='hidden' name='parametre' value='fk_roles'>
		<input type='submit' name='modificationUser' value='modification' >
		</form>