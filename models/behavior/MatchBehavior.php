<?php
//dao = data acces object
//dal = data access layer
class MatchBehavior implements IMatch{
   public function fetchAllMatch($table,$connection){
	   try {
            $statement = $connection->prepare("SELECT * FROM match_champions");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
   }
}