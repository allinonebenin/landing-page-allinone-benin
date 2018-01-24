<?php
namespace App\Table;
use Core\Table\Table;
	class CommentairesTable extends Table
	{

				public function getContenu($utilisateur_id, $article_id)
				{
					return $this->query(
					 "SELECT contenu
						FROM commentaires
						WHERE article_id=".$article_id."
						AND utilisateur_id=?
					", [$utilisateur_id], true);
				}

	}
?>
