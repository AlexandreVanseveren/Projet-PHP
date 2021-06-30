
<br> <h2> Rajout match</h2>
    <form action="rajoutUser" method="post">
        <input type="hidden" name="nom" value="createMatch">
		<select name=side>
		   <option valeur='red'>red</option>
		   <option valeur='blue'>blue</option>
		</select>
        <select name=resultat>
		   <option valeur='lose'>lose</option>
		   <option valeur='win'>win</option>
		</select>
		 <select name=type>
		   <option valeur='officiel'>officiel</option>
		   <option valeur='scrim'>scrim</option>
		</select>
		joueurs séparé de ""<input type="textarea" name="joueurs">
		note<input type="textarea" name="note">
		mvp<input type="textarea" name="mvp">
		<select name=champions1>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions2>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions3>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions4>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions5>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions6>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions7>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions8>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions9>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		<select name=champions10>
		   <?php foreach($listChampions as $champions):?>
			<option valeur="<?= $champions->__get('nom');?>"><?= $champions->__get('nom');?></option>
			<?php endforeach ?>
		</select>
		
        <input type="submit">
    </form>