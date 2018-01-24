<?php
namespace App\Table;
use Core\Table\Table;
	class UtilisateurTable extends Table
	{
	    public function newMember()
	    {
	    	return $this->query("SELECT COUNT(*) as tot
	                            FROM utilisateur
	                            WHERE datecreat BETWEEN '". date('Y-m-d', strtotime('-1 week'))."'
	                            AND '". date('Y-m-d', strtotime('+1 day')) ."'
	                            ",null,true);
	    }

	    public function verifmail($mail)
		{
			$lesmail= $this->query("SELECT mail
									FROM utilisateur");
			foreach ($lesmail as $lemail) {
				if($lemail->mail==$mail) return true;
			}
			return false;
		}

		public function lastNew()
		{
			return $this->query("SELECT id, nom, prenom, lien, DAY(datecreat) as j, MONTH(datecreat) as m, YEAR(datecreat) as a
								FROM utilisateur
								ORDER BY datecreat DESC
                                LIMIT 8");
		}

		public function afficher()
		{
			return $this->query("SELECT id, nom, prenom, lien, DAY(datecreat) as j, MONTH(datecreat) as m, YEAR(datecreat) as a
								FROM utilisateur
								ORDER BY id DESC");
		}

		public function afficherPage($premiereEntree, $messagesParPage)
		{
			return $this->query("SELECT id, nom, prenom, lien, DAY(datecreat) as j, MONTH(datecreat) as m, YEAR(datecreat) as a
								FROM utilisateur
								ORDER BY id DESC
								LIMIT ".$premiereEntree.", ".$messagesParPage."");
		}

		public function getNbrMessages()
		{
			return $this->query("SELECT COUNT(*) as nbr
								FROM utilisateur
								ORDER BY id DESC");
		}
	}
?>
