<?php
namespace App\Table;
use Core\Table\Table;
	class ArticleTable extends Table
	{
        public function getNbrCom($id)
        {
            return $this->query(
               "SELECT COUNT(*) as nbr
                FROM commentaires
                WHERE article_id=?
               ", [$id], true);
        }

        public function popular($nbr=5)
        {
            return $this->query(
                "SELECT *
                FROM article
                ORDER BY nombrevue DESC, datepub DESC
                LIMIT ".$nbr
            );
        }

				public function afficherwhere($nomid, $id)
				{
					return $this->query(
					 "SELECT id, nom, description, DAY(datepub) as j,
					 MONTH(datepub) as m, YEAR(datepub) as a, nombrevue, lien
						FROM article
						WHERE " . $nomid . "= ?",
						[$id], false);
				}

	}
?>
