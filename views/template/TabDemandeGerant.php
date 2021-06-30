<h2> Table Demande </h2>
<table id="user-list">
    <tr>
        <th>montant</th>
        <th>description</th>
		<th>date</th>
		<th>statut</th>
		<th>membre</th>
		<th>valider</th>
		<th>supprimer</th>
    </tr>
    <?php foreach($demandeMembre as $demande): ?>
        <tr>
			<?php $pk=$demande->__get('pk') ;
			$user=$demande->__get('fk_user');
			$statut=$demande->__get('statut');?>
            <td><?= $demande->__get('montant'); ?></td>
            <td><?= $demande->__get('description'); ?></td>
			<td><?= $demande->__get('created_at'); ?></td>
			<td><?= $demande->__get('statut'); ?></td>
			<td><?= $user->__get('username'); ?></td>
			<?php if ($statut != "valide"){ ?>
			<td>
			<form method='post' action='changementStatu' >
			<input type='hidden' name='modifieDemande' value='modifieDemande'>
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>
			<input type='submit' name='modificationDemande'  value='valider' />
			</form>
			</td>
			<?php }else{?>
				<td>deja valide</td>
			<?php } ?>
			<td>
			<form method='post' action='deleteDemande' >
			<input type='hidden' name='supprDemande' value='supprDemande'>
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>				
			<input type='submit' name='supprimerDemande' value='supprimer' />
			</form>
			</td>
        </tr>
    <?php endforeach;	?>
</table>