<?php
namespace App\Entites;
	class UtilisateurEntites
	{
		public function getUrl()
		{
			return "admin.php?p=user&id=" . $this->id;
		}
	} 