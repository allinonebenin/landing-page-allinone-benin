<?php
namespace App\Table;
use Core\Table\Table;
	class EmployeTable extends Table
	{
		  public function nombreLike($id)
        {
        	return $this->query("SELECT COUNT(*) as nbr
								FROM article a, employe e, likes l
								WHERE a.employe_id=e.id
								AND l.article_id=a.id
								AND e.id=?
								", [$id], true);
        }

			  public function nombreComment($id)
        {
        	return $this->query("SELECT COUNT(*) as nbr
								FROM article a, employe e, commentaires c
								WHERE a.employe_id=e.id
								AND c.article_id=a.id
								AND e.id=?
								", [$id], true);
        }

		public function afficher()
		{
			return $this->query("SELECT id, nom, prenom, lien, DAY(datecreat) as j, MONTH(datecreat) as m, YEAR(datecreat) as a
								FROM employe
								ORDER BY id DESC");
		}

		public function afficherPage($premiereEntree, $messagesParPage)
		{
			return $this->query("SELECT id, nom, prenom, lien, DAY(datecreat) as j, MONTH(datecreat) as m, YEAR(datecreat) as a
								FROM employe
								ORDER BY id DESC
								LIMIT ".$premiereEntree.", ".$messagesParPage."");
		}

	}
?>
