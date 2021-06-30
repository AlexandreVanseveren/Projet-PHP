<h2>Table Membre </h2>
<table id="membre">
    <tr>
        <th>psedo</th>
        <th>date de creation</th>
		<th>retrograder</th>
    </tr>
    <?php foreach($membre as $user): ?>
        <tr>
		<?php $pk=$user->__get('pk') ;?>
            <td><?= $user->__get('username'); ?></td>
            <td><?= $user->__get('created_at'); ?></td>
			<td>
			<form method='post' action='demote' >
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>
			<input type='hidden' name='parametre' value='fk_roles'>
			<input type='submit' name='retrograder'  value='retrograder' />
			</form>
			</td>
        </tr>
    <?php endforeach;	?>
</table>