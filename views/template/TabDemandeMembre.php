<h2> Table demande </h2>
<table id="demandeMembre">
    <tr>
        <th>montant</th>
        <th>description</th>
		<th>date</th>
		<th>statut</th>
    </tr>
    <?php foreach($demandeMembre as $demande): ?>
        <tr>
            <td><?= $demande->__get('montant'); ?></td>
            <td><?= $demande->__get('description'); ?></td>
			<td><?= $demande->__get('created_at'); ?></td>
			<td><?= $demande->__get('statut'); ?></td>
        </tr>
    <?php endforeach;?>
</table>