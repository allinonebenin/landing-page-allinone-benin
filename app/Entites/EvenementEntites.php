<?php
namespace App\Entites;
	class EvenementEntites
	{
		public function getUrl()
		{
			return "admin.php?p=event&id=" . $this->id;
		}
	} 
