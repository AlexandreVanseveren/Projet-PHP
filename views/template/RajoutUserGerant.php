<br><h2>Rajout utilisateur</h2>
    <form action="rajoutUtilisateur" method="post">
        <input type="hidden" name="type" value="createUser">
        Psedo:<input type="text" name="username">
        Mot de passe:<input type="text" name="password">
		<select name=role>
		   <option valeur='membre'>membre</option>
		   <option valeur='utilisateur'>utilisateur</option>
		</select>
        <input type="submit">
    </form>