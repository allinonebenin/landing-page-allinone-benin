<?php
namespace App\Table;
use Core\Table\Table;
	class ProjetTable extends Table
	{
        public function getNomParent($id)
        {
            return $this->query(
               "SELECT t.datafilter
                FROM projet p, typeprojet t, appartenir a
                WHERE p.id=a.projet_id AND t.id=a.typeprojet_id
                AND  p.id=?
               ", [$id], false);
        }

        public function getPp($id)
        {
            return $this->query(
               "SELECT i.lien
                FROM projet p, image i
                WHERE p.id=i.projet_id
                AND i.typeimage_id=1
                AND p.id=?
               ", [$id], true);
        }

        public function getTypeProjet($id)
        {
            return $this->query(
               "SELECT t.nom, t.id
                FROM typeprojet t, appartenir a
                WHERE t.id=a.typeprojet_id
                AND a.type='off'
                AND projet_id=?
               ", [$id], true);
        }

        public function getId($nom, $description, $lien, $client)
        {
            return $this->query(
               "SELECT id
                FROM projet
                WHERE nom=?
                AND description=?
                AND lien=?
								AND client=?
               ", [$nom, $description, $lien, $client], true);
        }

        public function allImages($id)
        {
            return $this->query(
               "SELECT i.lien
                FROM projet p, image i
                WHERE p.id=i.projet_id
                AND p.id=?
               ", [$id], false);
        }

        public function sameProject($id)
        {
            return $this->query(
               "SELECT *
                FROM projet p, appartenir a
                WHERE p.id=a.projet_id
                AND typeprojet_id=?
               ", [$id], false);
        }

				public function thelast($limite)
				{
					return $this->query("SELECT *
										FROM projet
										WHERE id IN (SELECT projet_id FROM image)
										ORDER BY id DESC
		                LIMIT " . $limite);
				}

				public function bypage($premiereEntree, $messagesParPage, $val='id')
				{
						return $this->query("
							SELECT *
							FROM projet
							WHERE id IN (SELECT projet_id FROM image)
							ORDER BY ".$val." DESC
							LIMIT ".$premiereEntree.", ".$messagesParPage."");
				}
	}
?>
