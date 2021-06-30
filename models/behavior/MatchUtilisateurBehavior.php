<?php
//dao = data acces object
//dal = data access layer
class MatchUtilisateurBehavior implements IMatch{
    public function fetchAllMatch($table,$connection){
		try {
            $statement = $connection->prepare("Select fk_champions, fk_match FROM match_champions 
			inner join matchleague on match_champions.fk_match = matchleague.pk where type = 'officiel'");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);           
            return $results;
      
        } catch (PDOException $e) {
            print $e->getMessage();
        } 
	}
	
}