<h2>Table utilisateur</h2>
<table id="user-list">
    <tr>
        <th>psedo</th>
        <th>date de creation</th>
		<th>role</th>
		<th>supprimer</th>
		<th>modifie</th>
    </tr>
    <?php foreach($user_list as $user): ?>
        <tr>
		<?php 
			$role=$user->__get('fk_roles');
			$pk=$user->__get('pk');?>
            <td><?= $user->__get('username'); ?></td>
            <td><?= $user->__get('created_at'); ?></td>
			<td><?= $role->__get('nom'); ?></td>
			<td>
			<form method='post' action='deleteUser' >
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>				
			<input type='submit' name='SupprimerUser' value='supprimer' />
			</form>
			</td>
			<td>
			<form method='post' action='modifierUser' >
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>
			<input type='submit' name='modifieUser'  value='modifie' />
			</form>
			</td>
        </tr>
    <?php endforeach;	?>
</table>