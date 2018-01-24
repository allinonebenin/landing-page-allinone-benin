<?php
namespace App\Table;
use Core\Table\Table;
	class LikesTable extends Table
	{
		public function verify($article_id, $user_id)
		{
			return $this->query("SELECT COUNT(*) as liker
													FROM likes
													WHERE article_id=".$article_id."
													AND utilisateur_id=?"
												, [$user_id], true);
		}

		public function verifyetat($article_id, $user_id)
		{
			return $this->query("SELECT COUNT(*) as liker
													FROM likes
													WHERE etat='1'
													AND article_id=".$article_id."
													AND utilisateur_id=?"
												, [$user_id], true);
		}

		public function comptelike($id)
		{
            return $this->query("SELECT COUNT(*) as tot
                                FROM likes
                                WHERE etat='1' 
																AND article_id= ?",
                                [$id], true);
		}
	}
?>
