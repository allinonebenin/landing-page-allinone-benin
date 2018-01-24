<?php
namespace App\Table;
use Core\Table\Table;
	class Vue_projetTable extends Table
	{ 
		public function findip($ip, $projet_id)
		{
			return $this->query(
			   "SELECT utilisateur_ip
				FROM vue_projet
				WHERE projet_id = ?
				", [$projet_id], false);
		}
	}
?>