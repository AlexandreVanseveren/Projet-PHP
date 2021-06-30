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
    </tr>
    <?php 	
			$list=array();
			$i=0;
			foreach($matchOffi as $donnee):
			$match = $donnee->__get('fk_match');
			$champions = $donnee->__get('fk_champions');
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
			<td><?= $list[$y]; ?></td>
			<?php
			$y=$y+1;
			endforeach;
			unset($list);
			$list= array();?>		
        </tr>
    <?php 
	}
	endforeach;	?>
</table>