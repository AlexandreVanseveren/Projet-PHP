<h2> Table Match </h2>
<table id="Match">
    <tr>
		<th>date</th>
        <th>resultat</th>
        <th>side</th>
		<th>mvp</th>
        <th>Top</th>
		<th>Champions</th>
        <th>Jungle</th>
		<th>Champions</th>
        <th>MID</th>
		<th>Champions</th>
        <th>ADC</th>
		<th>Champions</th>
        <th>Support</th>
		<th>Champions</th>
		<th>Top Adversaire</th>
		<th>Champions</th>
        <th>Jungle Adversaire</th>
		<th>Champions</th>
        <th>MID Adversaire</th>
		<th>Champions</th>
        <th>ADC Adversaire</th>
		<th>Champions</th>
        <th>Support Adversaire</th>
		<th>Champions</th>
		<th>delete</th>
    </tr>
	<?php
			$list=array();
			$i=0;
			foreach($listMatch as $donnée):
			$match = $donnée->__get('fk_match');
			$champions = $donnée->__get('fk_champions');
			$i=$i+1;
			$nom = $champions->__get('nom');
			array_push($list,$nom);
			if ($i % 10==0){
			$pk=$match->__get('pk');?>
	<tr>
			<td><?= $match->__get('dateHeure'); ?></td>
            <td><?= $match->__get('resultat'); ?></td>
            <td><?= $match->__get('side'); ?></td>
			<td><?= $match->__get('mvp'); ?></td>
			<?php 
			$joueurs=$match->__get('joueurs');
			$joueurs=explode(" ", $joueurs);
			$y=0;
			 foreach($joueurs as $joueur):?>
			<td><?= $joueur; ?></td>
			<td id="champions"><?= $list[$y]; ?></td>
			<?php
			$y=$y+1;
			endforeach;
			unset($list);
			$list= array();?>
			<td>
			<form method='post' action='deleteUser' >
			<input type='hidden' name='pk' value='<?php echo "$pk" ; ?> '>				
			<input type='submit' name='deleteMatch' value='delete' />
			</form>
			</td>
        </tr>
    <?php 
			}
	endforeach;	?>
</table>