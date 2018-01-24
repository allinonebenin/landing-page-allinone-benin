<?php
namespace App\Table;
use Core\Table\Table;
	class ActiviteTable extends Table
	{
			public function afficher($user_id)
			{
				 return $this->query(
						"SELECT *
						 FROM activite a, article ar
						 WHERE a.commentaires_id=ar.id
						", [$id], true);
			}

			public function afficherwhere($att, $valatt, $utilisateur_id)
			{
				return $this->query(
				 "SELECT *
					FROM activite
					WHERE " . $att . "=".$valatt."
					AND utilisateur_id=?
					ORDER BY id DESC",
					[$utilisateur_id], false);
			}
			public function comptewhere($nomid, $id, $utilisateur_id)
			{
				return $this->query(
				 "SELECT COUNT(*) as tot
					FROM activite
					WHERE ". $nomid . "=".$id."
					AND utilisateur_id=?",
					[$utilisateur_id], true);
			}

	}
?>
